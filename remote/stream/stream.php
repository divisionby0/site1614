<?php
if( !defined('STREAM_SUBSYSTEM')){
    die('sorry');
}
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../Remote.php');

class Streams extends Remote{

    public function __construct()
    {
        parent::__construct();
    }

    function getServiceData( $serviceName ){
        $stmt = $this->db->prepare("SELECT * FROM stream_service WHERE name=?");
        $stmt->execute(array($serviceName));
        $res = $stmt->fetch();
        $res['api_headers'] = json_decode($res['api_headers']);
        return $res;
    }

    function getStream($channelName, $serviceName = 'twitch' )
    {
        $service = $this->getServiceData( $serviceName );
        $ch = curl_init( $service['api_url'].'streams/' . $channelName);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $service['api_headers']);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode( $result );
    }

    function getChannel($channelName, $serviceName = 'twitch' )
    {
        $service = $this->getServiceData( $serviceName );
        $ch = curl_init( $service['api_url'].'channels/' . $channelName);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $service['api_headers']);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode( $result );
    }

    function fillStreams( $serviceName = 'twitch' ){
        $service = $this->getServiceData( $serviceName );
        $stmt = $this->db->prepare("SELECT * FROM stream_channel WHERE service_id = ? AND NOT disabled AND COALESCE(display_name, '') > '' ");
        $stmt->execute(array($service['id']));
        while($res = $stmt->fetch()){
            $stream = $this->getStream( $res['name'] );
            if( isset($stream->stream) && $stream->stream){
                $this->saveStream( $stream->stream );
            } else {
                $this->deleteStream( $res['name'] );
            }
        }
        // remove old streams
        $stmt = $this->db->prepare("DELETE FROM stream_stream where stream_stream.id NOT IN (SELECT s3.max_id FROM (SELECT max(s.id) as max_id FROM stream_stream s GROUP BY s.channel_id) s3)");
        $stmt->execute(array($service['id']));

    }

    function fillChannels( $serviceName = 'twitch' ){
        $service = $this->getServiceData( $serviceName );
        $stmt = $this->db->prepare("SELECT * FROM stream_channel WHERE service_id = ? AND NOT disabled AND checked_at IS NULL OR DATE_ADD(checked_at, INTERVAL +30 MINUTE) < NOW()");
        $stmt->execute(array($service['id']));
        while($res = $stmt->fetch()){
            $channel = $this->getChannel( $res['name'] );
            if( $channel ){
                $this->saveChannel( $channel );
                $this->fillVideos( $channel->name, $serviceName );
            }
        }

    }

    function deleteStream( $channelName ){
        $stmt = $this->db->prepare("
            DELETE FROM stream_stream WHERE channel_id = (SELECT id FROM stream_channel WHERE name = :name)
            ");
        $stmt->execute(array(
            ':name' => $channelName
        ));
    }

    function saveChannel( $channel ) {
        $stmt = $this->db->prepare("
            UPDATE stream_channel
            SET remote_id = :remote_id,
            followers = :followers,
            display_name = :display_name,
            status = :status,
            language = :language,
            game = :game,
            checked_at = NOW() WHERE name = :name");
        $stmt->execute(array(
            ':name' => $channel->name,
            ':remote_id' => $channel->_id,
            ':followers' => $channel->followers,
            ':display_name' => $channel->display_name,
            ':status' => $channel->status,
            ':language' => $channel->language,
            ':game' => $channel->game
        ));
    }

    function saveStream( $stream ) {
        $stmt = $this->db->prepare("
            INSERT INTO stream_stream( remote_id, game, viewers, created_at, preview_template_url, channel_id )
            VALUES (:remote_id, :game, :viewers, :created_at, :preview_template_url, (SELECT id FROM stream_channel WHERE name = :name))
            ON DUPLICATE KEY UPDATE
            remote_id = :remote_id,
            game = :game,
            viewers = :viewers,
            created_at = :created_at,
            preview_template_url = :preview_template_url,
            channel_id = (SELECT id FROM stream_channel WHERE name = :name)
            ");
        $stmt->execute(array(
            ':name' => $stream->channel->name,
            ':remote_id' => $stream->_id,
            ':game' => $stream->game,
            ':viewers' => $stream->viewers,
            ':created_at' => $stream->created_at,
            ':preview_template_url' => $stream->preview->template
        ));
    }

    function saveVideo( $video ) {
        $stmt = $this->db->prepare("
            INSERT INTO stream_video( remote_id, title, description, game, preview, url, views, created_at, length, channel_id )
            VALUES (:remote_id, :title, :description, :game, :preview, :url,  :views, :created_at, :length, (SELECT id FROM stream_channel WHERE name = :name))
            ");
        $stmt->execute(array(
            ':name' => $video->channel->name,
            ':title' => $video->title,
            ':description' => $video->description,
            ':preview' => $video->preview,
            ':url' => $video->url,
            ':remote_id' => $video->_id,
            ':game' => $video->game,
            ':views' => $video->views,
            ':length' => $video->length,
            ':created_at' => $video->created_at,
        ));
    }

    function loadStreamsData( $count = 0 ){
        $limit = ($count > 0) ? ' LIMIT ' . intval( $count ) : '';
        $streams = $this->db->query(" SELECT * FROM stream_channel c
            LEFT OUTER JOIN stream_stream s ON s.channel_id = c.id WHERE NOT c.disabled ORDER BY viewers DESC $limit")
            ->fetchAll();
        foreach( $streams as $key => $stream ){
            switch( $stream['language'] ){
                case 'ru':
                    $streams[$key]['language_desc'] = 'Стрим на русском языке';
                    break;
                case 'en':
                    $streams[$key]['language_desc'] = 'Stream in English';
                    break;
                default:
                    $streams[$key]['language_desc'] = $stream['language'] . 'stream';
            }

        }
        return $streams;
    }

    function loadStreamData( $name ){
        $stmt = $this->db
            ->prepare('SELECT * FROM stream_channel c LEFT OUTER JOIN stream_stream s ON s.channel_id = c.id
              WHERE c.name = :name AND NOT c.disabled');
        $stmt->execute(array( ':name' => $name));
        $stream = $stmt->fetch();
        return $stream;
    }

    function loadStreamVideos( $channelName, $serviceName = 'twitch', $limit = 0 ){
        if($limit){
            $limit_str = "LIMIT $limit";
        }
        $service = $this->getServiceData( $serviceName );
        $stmt = $this->db->prepare(" SELECT v.* FROM stream_video v INNER JOIN stream_channel c ON v.channel_id = c.id WHERE c.name = :name AND c.service_id = :service_id ORDER BY remote_id DESC $limit");
        $stmt->execute(array(
            ':name' => $channelName,
            ':service_id' => $service['id']
        ));
        $videos = $stmt->fetchAll();
        return $videos;
    }

    function fillVideos( $channelName, $serviceName = 'twitch' ){
        $service = $this->getServiceData( $serviceName );
        $stmt = $this->db
            ->prepare('SELECT max(remote_id) as max_id FROM stream_video WHERE channel_id = (SELECT id FROM stream_channel WHERE name = :name AND service_id = :service_id)');
        $stmt->execute(array(
            ':name' => $channelName,
            ':service_id' => $service['id']
        ));
        $maxVideoRec = $stmt->fetch();
        $maxVideoId = $maxVideoRec ? $maxVideoRec['max_id'] : 0;
        $ch = curl_init( $service['api_url']."channels/$channelName/videos?limit=12&broadcasts=true");
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $service['api_headers']);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec( $ch );
        curl_close( $ch );
        $videos = json_decode($result);
        foreach($videos->videos as $video){
            $video->_id = intval(str_replace('v', '', $video->_id));
            if( $video->_id > $maxVideoId ){
                $this->saveVideo( $video );
            }
        }
    }
}

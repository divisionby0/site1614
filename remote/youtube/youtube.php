<?php
if( !defined('STREAM_SUBSYSTEM')){
    die('sorry');
}
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../Remote.php');

class Youtube extends Remote{

    private $key;

    public function __construct()
    {
        parent::__construct();
        $this->key = YOUTUBEKEY;
    }

    function getUser($id)
    {
        $ch = curl_init(
            "https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails&id=$id&key={$this->key}");

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($result);
    }

    function getVideos($plid){
        $ch = curl_init(
            "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=$plid&key={$this->key}");

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($result);
    }

    function fillVideos(){
        $stmt = $this->db->prepare("SELECT u.* FROM youtube_user u
            WHERE NOT disabled AND COALESCE(videos_list_id, '') > ''");
        $stmt->execute();
        while($res = $stmt->fetch()){
            $videos = $this->getVideos( $res['videos_list_id'] );
            $videos = isset($videos->items) ? $videos->items : [];
            foreach($videos as $video){
                $this->saveVideo( $video, $res['id'] );
            }
        }
    }

    function saveVideo($video, $channel_id) {
        $stmt = $this->db->prepare("
            INSERT INTO youtube_video(remote_id, published_at, title, thumbnail, channel_id, video_id)
            VALUES (:remote_id, :published_at, :title, :thumbnail, :channel_id, :video_id)
            ON DUPLICATE KEY UPDATE
            remote_id = :remote_id,
            published_at = :published_at,
            title = :title,
            thumbnail= :thumbnail,
            channel_id = :channel_id,
            video_id = :video_id
            ");
        $stmt->execute(array(
            ':remote_id' => $video->id,
            ':published_at' => $date = date('Y-m-d H:i:s', strtotime($video->snippet->publishedAt)),
            ':title' => $video->snippet->title,
            ':thumbnail' => $video->snippet->thumbnails->standard->url,
            ':channel_id' => $channel_id,
            ':video_id' => $video->snippet->resourceId->videoId
        ));

        // save svodki
        if($this->db->lastInsertId()) {
            $stmt = $this->db->prepare("
            INSERT INTO svodki( type, record_id, record_date)
            VALUES( :type, :record_id, :record_date)
            ON DUPLICATE KEY UPDATE
            type = :type,
            record_id = :record_id,
            record_date = :record_date
            ");
            $stmt->execute(array(
                ':type' => 'youtube',
                ':record_id' => $this->db->lastInsertId(),
                ':record_date' => $date = date('Y-m-d H:i:s', strtotime($video->snippet->publishedAt))
            ));
        }
    }


    function fillUsers(){
        $stmt = $this->db->prepare("SELECT * FROM youtube_user WHERE NOT disabled AND checked_at IS NULL OR DATE_ADD(checked_at, INTERVAL +30 MINUTE) < NOW()");
        $stmt->execute();
        while($res = $stmt->fetch()){
            $user = $this->getUser( $res['remote_id'] );
            if( isset($user->items) && count($user->items)){
                $this->saveUser( $user->items[0], $res['id'] );
            }
        }

    }

    function saveUser( $user, $user_id ) {
        $stmt = $this->db->prepare("
            UPDATE youtube_user
            SET
            title = :title,
            thumbnail = :thumbnail,
            videos_list_id = :videos_list_id,
            checked_at = NOW() WHERE id = :user_id");
        $stmt->execute(array(
            ':title' => $user->snippet->title,
            ':thumbnail' => $user->snippet->thumbnails->default->url,
            ':videos_list_id' => $user->contentDetails->relatedPlaylists->uploads,
            ':user_id' => $user_id,
        ));
    }

    function loadVideos( $count = 0, $ids = [] ){
        if($ids){
            $count = 0;
            $ids_str = implode(',', $ids);
        }
        $in_ids = $ids ? "AND t.id IN ($ids_str)" : '';

        $limit = ($count > 0) ? ' LIMIT ' . intval( $count ) : '';
        $videos = $this->db->query(" SELECT u.title as usertitle, u.thumbnail as userthumb, u.remote_id as user_id, t.* FROM youtube_user u LEFT OUTER JOIN youtube_video t ON t.channel_id = u.id
            WHERE NOT u.disabled $in_ids ORDER BY t.published_at DESC $limit")->fetchAll();

        return $videos;
    }
}
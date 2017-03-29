<?php
if( !defined('STREAM_SUBSYSTEM')){
    die('sorry');
}
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../util.php');
require_once('vendor/autoload.php');
require_once(__DIR__ . '/../yandextranslate.php');
use Abraham\TwitterOAuth\TwitterOAuth;


class Twitters {
    private $db;
    private $conn;
    public function __construct()
    {
        $dsn = 'mysql:host='.DBHOST.';dbname='.DBNAME.';charset='.DBCHARSET;
        $options = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->db = new PDO($dsn, DBUSER, DBPASS, $options);

        $this->conn = new TwitterOAuth(TWITTERCONSUMERKEY, TWITTERCONSUMERSECRET,
            TWITTERTOKEN, TWITTERTOKENSECRET);
    }

    function getUser($name)
    {
        $user = $this->conn->get('users/lookup', ['screen_name' => $name]);
        return count($user) ? $user[0] : false;
    }

    function getTwits($name, $last_id = false){
        $request_data = ['screen_name' => $name];
        if($last_id){
            $request_data['since_id'] = $last_id;
        }
        $timeline = $this->conn->get('statuses/user_timeline', $request_data);
        return $timeline;
    }

    function fillTwits(){
        $stmt = $this->db->prepare("SELECT u.*, max(t.remote_id) as max_id FROM twitter_user u
            LEFT OUTER JOIN twitter_twit t ON u.id = t.user_id WHERE NOT disabled AND COALESCE(screen_name, '') > '' GROUP BY u.id");
        $stmt->execute();
        while($res = $stmt->fetch()){
            $timeline = $this->getTwits( $res['screen_name'], $res['max_id'] );
            foreach($timeline as $twit){
                $this->saveTwit( $twit, $res['id'] );
            }
        }
    }

    function saveTwit($twit, $user_id) {
        $stored_twit_stmt = $this->db->prepare('SELECT id, lang_detected, text_eng, text_ru FROM twitter_twit WHERE remote_id = :remote_id');
        $stored_twit = $stored_twit_stmt->execute([':remote_id' => $twit->id]);
        //expand links
        if(isset($twit->entities->urls)){
            foreach($twit->entities->urls as $url_e){
                $twit->text = str_replace($url_e->url, $url_e->expanded_url, $twit->text);
            }
        }
        if(!$stored_twit || !$stored_twit['lang_detected']){
            $yt = new YandexTranslate();
            $text = replaceTwitterTags(replaceLinks($twit->text));
            $lang = $yt->detectLanguage($twit->text);
            if($lang != 'ru'){
                $text_eng = $text;
                $text_ru = $yt->translate($text, "$lang-ru");
            }
            else {
                $text_ru = $text;
                $text_eng = '';
                $lang = $lang ?: 'uu';
            }
        } else {
            $text_ru = $stored_twit['text_ru'];
            $text_eng = $stored_twit['text_eng'];
            $lang = $stored_twit['lang_detected'];
        }

        $stmt = $this->db->prepare("
            INSERT INTO twitter_twit( text, remote_id, created_at, photo_url, user_id, text_ru, text_eng, lang_detected )
            VALUES (:text, :remote_id, :created_at, :photo_url, :user_id, :text_ru, :text_eng, :lang_detected)
            ON DUPLICATE KEY UPDATE
            text = :text,
            remote_id = :remote_id,
            created_at = :created_at,
            photo_url = :photo_url,
            user_id = :user_id,
            text_ru = :text_ru,
            text_eng = :text_eng,
            lang_detected = :lang_detected
            ");
        $stmt->execute(array(
            ':text' => $twit->text,
            ':remote_id' => $twit->id,
            ':created_at' => $date = date('Y-m-d H:i:s', strtotime($twit->created_at)),
            ':photo_url' => isset($twit->entities->media) && count($twit->entities->media) && $twit->entities->media[0]->type == 'photo' ?
                $twit->entities->media[0]->media_url : '',
            ':user_id' => $user_id,
            ':text_ru' => $text_ru,
            ':text_eng' => $text_eng,
            ':lang_detected' => $lang
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
                ':type' => 'twitter',
                ':record_id' => $this->db->lastInsertId(),
                ':record_date' => $date = date('Y-m-d H:i:s', strtotime($twit->created_at))
            ));
        }
    }

    function fillUsers(){
        $stmt = $this->db->prepare("SELECT * FROM twitter_user WHERE NOT disabled AND checked_at IS NULL OR DATE_ADD(checked_at, INTERVAL +30 MINUTE) < NOW()");
        $stmt->execute();
        while($res = $stmt->fetch()){
            $user = $this->getUser( $res['screen_name'] );
            if( $user ){
                $this->saveUser( $user );
            }
        }

    }

    function saveUser( $user ) {
        $stmt = $this->db->prepare("
            UPDATE twitter_user
            SET remote_id = :remote_id,
            name = :name,
            followers = :followers,
            language = :language,
            description = :description,
            profile_image_url = :profile_image_url,
            checked_at = NOW() WHERE screen_name = :screen_name");
        $stmt->execute(array(
            ':remote_id' => $user->id,
            ':name' => $user->name,
            ':followers' => $user->followers_count,
            ':language' => $user->lang,
            ':description' => $user->description,
            ':profile_image_url' => $user->profile_image_url,
            ':screen_name' => $user->screen_name,
        ));
    }

    function loadTwits( $count = 0, $ids = [] ){
        if($ids){
            $count = 0;
            $ids_str = implode(',', $ids);
        }
        $in_ids = $ids ? "AND t.id IN ($ids_str)" : '';
        $limit = ($count > 0) ? ' LIMIT ' . intval( $count ) : '';
        $twits = $this->db->query(" SELECT * FROM twitter_user u LEFT OUTER JOIN twitter_twit t ON t.user_id = u.id
            WHERE NOT u.disabled $in_ids ORDER BY t.created_at DESC $limit")->fetchAll();

        return $twits;
    }
}

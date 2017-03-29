<?php
if( !defined('STREAM_SUBSYSTEM')){
    die('sorry');
}
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../yandextranslate.php');
require_once(__DIR__ . '/../Remote.php');

class Instagram extends Remote{
    private $db;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($username) {
        $ch = curl_init(
            "https://www.instagram.com/$username/");

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec( $ch );
        curl_close( $ch );
        $matches = [];
        preg_match('|window\._sharedData =(.*);</script>|', $result, $matches);
        $result_object = json_decode($matches[1]);
        return isset($result_object->entry_data->ProfilePage[0]->user) ?
            $result_object->entry_data->ProfilePage[0]->user : false;
    }

    function fillUsers(){
        $stmt = $this->db->prepare("SELECT * FROM instagram_user WHERE NOT disabled AND checked_at IS NULL OR TRUE OR DATE_ADD(checked_at, INTERVAL +2 MINUTE) < NOW()");
        $stmt->execute();
        while($res = $stmt->fetch()){
            $user = $this->getUser( $res['username'] );
            if($user){
                $this->saveUser( $user, $res['id'] );
                foreach($user->media->nodes as $media){
                    $this->saveMedia($media, $res['id']);
                }
            }
        }
    }

    function saveMedia($media, $user_id) {
        $stored_media_stmt = $this->db->prepare('SELECT id, lang, caption_ru FROM instagram_media WHERE remote_id = :remote_id');
        $stored_media = $stored_media_stmt->execute([':remote_id' => $media->id]);
        if(!$stored_media || !$stored_media['lang']){
            $yt = new YandexTranslate();
            $caption = $media->caption;
            $lang = $yt->detectLanguage($media->caption);
            if($lang != 'ru'){
                $caption_ru = $yt->translate($caption, "$lang-ru");
            }
            else {
                $caption_ru = '';
            }
        } else {
            $caption_ru = $stored_media['caption_ru'];
            $caption = $stored_media['caption'];
            $lang = $stored_media['lang'];
        }

        $stmt = $this->db->prepare("
            INSERT INTO instagram_media(user_id, remote_id, media_url, is_video, publication_date, caption, code, caption_ru, lang)
            VALUES (:user_id, :remote_id, :media_url, :is_video, :publication_date, :caption, :code, :caption_ru, :lang)
            ON DUPLICATE KEY UPDATE
            user_id = :user_id,
            remote_id = :remote_id,
            media_url = :media_url,
            is_video = :is_video,
            publication_date = :publication_date,
            code = :code,
            caption_ru = :caption_ru,
            lang = :lang
            ");
        $stmt->execute(array(
            ':user_id' => $user_id,
            ':remote_id' => $media->id,
            ':media_url' => $media->display_src,
            ':is_video' => $media->is_video,
            ':publication_date' => date('Y-m-d H:i:s', $media->date),
            ':caption' => $caption,
            ':code' => $media->code,
            ':caption_ru' => $caption_ru,
            ':lang' => $lang,
        ));

        // save svodki
        if($this->db->lastInsertId()){
            $stmt = $this->db->prepare("
            INSERT INTO svodki( type, record_id, record_date)
            VALUES( :type, :record_id, :record_date)
            ON DUPLICATE KEY UPDATE
            type = :type,
            record_id = :record_id,
            record_date = :record_date
            ");
            $stmt->execute(array(
                ':type' => 'instagram',
                ':record_id' => $this->db->lastInsertId(),
                ':record_date' => $date = date('Y-m-d H:i:s', $media->date)
            ));
        }
    }

    function saveUser( $user, $user_id ) {
        $stmt = $this->db->prepare("
            UPDATE instagram_user
            SET
            full_name = :full_name,
            remote_id = :remote_id,
            profile_pic_url = :profile_pic_url,
            checked_at = NOW() WHERE id = :user_id");
        $stmt->execute(array(
            ':full_name' => $user->full_name,
            ':remote_id' => $user->id,
            ':profile_pic_url' => $user->profile_pic_url,
            ':user_id' => $user_id,
        ));
    }

    function loadPosts( $count = 0, $ids = [] ){
        if($ids){
            $count = 0;
            $ids_str = implode(',', $ids);
        }
        $in_ids = $ids ? "AND p.id IN ($ids_str)" : '';
        $limit = ($count > 0) ? ' LIMIT ' . intval( $count ) : '';
        $medias = $this->db->query(" SELECT u.remote_id as userid, u.full_name, u.username, u.profile_pic_url, p.* FROM instagram_user u LEFT OUTER JOIN instagram_media p ON p.user_id = u.id
            WHERE NOT u.disabled $in_ids ORDER BY p.publication_date DESC $limit")->fetchAll();

        foreach($medias as $key=>$media){
            if($media['lang'] && $media['lang'] == 'ru')
            {
                $medias[$key]['caption_eng'] = '';
                $medias[$key]['caption_ru'] = $media['caption'];
            }
            else
            {
                $medias[$key]['caption_eng'] = $media['caption'];
            }
        }
        return $medias;
    }
}
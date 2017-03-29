<?php
if( !defined('STREAM_SUBSYSTEM')){
    die('sorry');
}
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../Remote.php');
require_once("../div0/utils/StringUtil.php");


class Vk extends Remote{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($username) {
        $ch = curl_init(
            "https://api.vk.com/method/users.get?v=5.60&fields=photo_50,screen_name&user_ids=$username");

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec( $ch );
        curl_close( $ch );
        $result_object = json_decode($result);
        return isset($result_object->response[0]) ? $result_object->response[0] : false;
    }

    public function getWall($user_id) {
        $ch = curl_init(
            "https://api.vk.com/method/wall.get?v=5.60&owner_id=$user_id");

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = curl_exec( $ch );
        curl_close( $ch );
        $result_object = json_decode($result);
        return isset($result_object->response->items) ? $result_object->response->items : [];
    }

    function fillWall(){
        $stmt = $this->db->prepare("SELECT u.* FROM vk_user u
            WHERE NOT disabled AND screen_name > ''");
        $stmt->execute();
        while($res = $stmt->fetch()){
            $wall = $this->getWall( $res['remote_id'] );
            foreach($wall as $post){
                if($post->text){
                    $this->savePost( $post, $res['id'] );
                }
            }
        }
    }

    function savePost($post, $user_id) {
        $stmt = $this->db->prepare("
            INSERT INTO vk_post(user_id, publication_date, text, post_photo_url, remote_id)
            VALUES (:user_id, :publication_date, :text, :photo_url, :remote_id)
            ON DUPLICATE KEY UPDATE
            user_id = :user_id,
            publication_date = :publication_date,
            text = :text,
            post_photo_url = :photo_url,
            remote_id = :remote_id
            ");
        $stmt->execute(array(
            ':user_id' => $user_id,
            ':publication_date' => date('Y-m-d H:i:s', $post->date),
            ':text' => $post->text,
            ':photo_url' => isset($post->attachments[0]->photo->photo_604) ? $post->attachments[0]->photo->photo_604 : '',
            ':remote_id' => $post->id,
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
                ':type' => 'vkontakte',
                ':record_id' => $this->db->lastInsertId(),
                ':record_date' => $date = date('Y-m-d H:i:s', $post->date)
            ));
        }
    }

    function fillUsers(){
        $stmt = $this->db->prepare("SELECT * FROM vk_user WHERE NOT disabled AND checked_at IS NULL OR DATE_ADD(checked_at, INTERVAL +30 MINUTE) < NOW()");
        $stmt->execute();
        while($res = $stmt->fetch()){
            $user = $this->getUser( $res['screen_name'] );
            if( $user){
                $this->saveUser( $user, $res['id'] );
            }
        }

    }

    function saveUser( $user, $user_id ) {
        $stmt = $this->db->prepare("
            UPDATE vk_user
            SET remote_id = :remote_id,
            first_name = :first_name,
            last_name = :last_name,
            photo_url = :photo_url,
            checked_at = NOW() WHERE id = :user_id");
        $stmt->execute(array(
            ':remote_id' => $user->id,
            ':first_name' => $user->first_name,
            ':last_name' => $user->last_name,
            ':photo_url' => $user->photo_50,
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
        $posts = $this->db->query(" SELECT u.remote_id as userid, u.first_name, u.last_name, u.screen_name, u.photo_url, p.* FROM vk_user u LEFT OUTER JOIN vk_post p ON p.user_id = u.id
            WHERE NOT u.disabled $in_ids ORDER BY p.publication_date DESC $limit")->fetchAll();

        foreach($posts as $key => $post){
            //$posts[$key]['text'] = replaceLinks($post['text']);
            $posts[$key]['text'] = StringUtil::replaceLinks($post['text']);
        }

        return $posts;
    }
}

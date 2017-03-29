<?php
if( !defined('STREAM_SUBSYSTEM')){
    die('sorry');
}
require_once('config.php');

class YandexTranslate{
    private $key;
    function __construct(){
        $this->key = YANDEXTRANSLATEKEY;
    }

    function detectLanguage($text){
        $ch = curl_init(
            "https://translate.yandex.net/api/v1.5/tr.json/detect?key={$this->key}");
        curl_setopt( $ch, CURLOPT_POSTFIELDS, ['text' => preg_replace('|^@|', ' @', $text)]);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        return isset($result->code) && $result->code == '200' ? $result->lang : false;
    }

    function translate($text, $lang){
        $ch = curl_init(
            "https://translate.yandex.net/api/v1.5/tr.json/translate?format=html&key={$this->key}&lang=$lang");
        curl_setopt( $ch, CURLOPT_POSTFIELDS, ['text' => preg_replace('|^@|', ' @', $text)]);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        return isset($result->code) && $result->code == '200' ? $result->text[0] : false;
    }
}
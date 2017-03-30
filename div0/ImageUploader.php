<?php
$accepted_origins = array("http://site1614/qa/add", "http://1614.ru/");
$imageFolder = "../images/";
//$imageFolder = 'http://'.$_SERVER['HTTP_HOST'] .'/images/';


reset ($_FILES);
$temp = current($_FILES);
if (is_uploaded_file($temp['tmp_name'])){
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        } else {
            //header("HTTP/1.0 403 Origin Denied");
            //return;
        }
    }

    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.0 500 Invalid file name.");
        return;
    }

    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.0 500 Invalid extension.");
        return;
    }

    $filetowrite = $imageFolder . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    echo json_encode(array('location' => 'http://'.$_SERVER['HTTP_HOST'] .'/images/'. $temp['name']));
    //echo json_encode(array('location' => 'http://'.$_SERVER['HTTP_HOST'] .'/images/'. $temp['name']));
    //echo json_encode(array('location' => $_SERVER['HTTP_HOST'].$temp['name']));
} else {
    header("HTTP/1.0 500 Server Error");
}
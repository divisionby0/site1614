<?php
$source = '<p>&nbsp;</p><img src="http://site1614/iasilyev"</p>';

$hasImage = "0";
//preg_match('/(<img(\s*\S*\s)*src\s*=\s*("|\')\S*\.(jpg|jpeg|JPEG|JPG|png|PNG|gif|GIF)("|\')(\s*\S*\s*)*/*>)/', $source, $matches);
if(preg_match('<img', $source)){
    echo 'HAS IMG TAG !!!';
}

$pos = strpos($source, "<img src=");

//preg_match('/^<a.*?href=(["\'])(.*?)\1.*$/', $str, $m);


//if(sizeof($matches) > 0){
   // $hasImage = "1";
//}

if(isset($pos) && $pos!==false){
    $hasImage = "1";
}

echo $source;
echo 'hasImage='.$hasImage;
echo '<p>pos='.$pos.'</p>';
//echo '<p>matches:</p>';
//var_dump($matches);

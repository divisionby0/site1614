<?php
if( !isset($_REQUEST['secret']) || $_REQUEST['secret'] != 'gjk45hlgh,mnxc8sdg' ) {
    die;
}
DEFINE('STREAM_SUBSYSTEM', true);
require_once('twitter.php');

set_time_limit(0);

$twitters = new Twitters();
$twitters->fillUsers();
$twitters->fillTwits();

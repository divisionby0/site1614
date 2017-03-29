<?php
if( !isset($_REQUEST['secret']) || $_REQUEST['secret'] != 'gjk45hlgh,mnxc8sdg' ) {
    die;
}
DEFINE('STREAM_SUBSYSTEM', true);
require_once('instagram.php');

set_time_limit(0);

$vk = new Instagram();
$vk->fillUsers();
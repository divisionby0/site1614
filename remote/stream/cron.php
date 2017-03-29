<?php
if( !isset($_REQUEST['secret']) || $_REQUEST['secret'] != 'gjk45hlgh,mnxc8sdg' ) {
    die;
}
DEFINE('STREAM_SUBSYSTEM', true);
require_once('stream.php');

set_time_limit(0);

$streams = new Streams();
$streams->fillChannels();
$streams->fillStreams();

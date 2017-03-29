<!doctype HTML>
<html>
<head>
    <title>Стримы</title>
    <meta name="description" content="?" />
    <meta name="keywords" content="?" />
    <?php require_once("../../+/meta.php");?>
</head>
<body>
<?php require_once("../../+/header.php");?>



<!-- content -->
<main class="streams">

    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <ul>
            <li><a href="#">CS:GO</a></li>
            <li><img src="/i/bullet.png" alt=""></li>
            <li><a href="#">Киберспорт</a></li>
            <li><img src="/i/bullet.png" alt=""></li>
            <li><a href="#">Стримы</a></li>
            <li><img src="/i/bullet.png" alt=""></li>
            <li>ESL_CSGO</li>
        </ul>
    </div>
    <!-- /breadcrumbs -->


<?php
    if(file_exists( 'stream.php' )) {
        DEFINE('STREAM_SUBSYSTEM', true);
        require_once('stream.php');
        $streams = new Streams();
    }
    $name = array_pop(explode('/stream/', $_SERVER['REQUEST_URI']));
    if( $name && $streams ) {
        $stream = $streams->loadStreamData( $name );
    }
    if($stream):
?>
    <h1 class="center"><strong><?= number_format($stream['viewers'], 0, '.', ' '); ?></strong> смотрят <strong><?= $stream['display_name'] ?></strong></h1>

    <iframe src="https://player.twitch.tv/?channel=<?= $stream['name'] ?>" frameborder="0" scrolling="no" height="720" width="1180"></iframe>

<?php
        $videos = $streams->loadStreamVideos( $name, 'twitch', 3 );
        if($videos):
?>
    <div class="streams">

        <h2>Записи трансляций <strong><?= $stream['display_name'] ?></strong></h2>
        <div class="history_streams">
<?php
function rdate($param, $time=0) {
    if(intval($time)==0)$time=time();
    $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    return date(str_replace(array('M', 'Y'),array($MonthNames[date('n',$time)-1], date('Y', $time) == date('Y') ? '' : date('Y', $time)),$param), $time);
}
foreach($videos as $video):
?>
            <figure>
                <a href="<?= $video['url'] ?>"  style="background-image: url(<?= $video['preview'] ?>)">
                    <figcaption><?= rdate('d M Y', strtotime($video['created_at'])) ?></figcaption>
                </a>
                <span><?= $video['length'] ?></span>
                <h4><a href="<?= $video['url'] ?>"><?= $video['title'] ?></a></h4>
            </figure>
<?php
    endforeach;
?>
        </div>
    </div>
<?php endif; ?>
<?php endif; ?>
<?php
if($streams):
$streamList = $streams->loadStreamsData( 8 );
?>
    <div class="streams" style="margin-top: -145px;">
        <h2><a href="#">Другие онлайн-стримы</a></h2>

        <div>
            <?php foreach($streamList as $stream): ?>
                <?php if(isset($stream['viewers'])): ?>
                    <figure style="background-image: url(<?= str_replace(array('{width}', '{height}'), array(280, 158)
                        , $stream['preview_template_url']) ?>);">
                        <a href="/stream/<?= $stream['name'] ?>">
                            <span>Twitch</span>
                            <img src="/i/<?= $stream['language'] ?>-flag.png" alt="<?= $stream['language_desc'] ?>" />
                            <figcaption><?= $stream['display_name'] ?>: <?= number_format($stream['viewers'], 0, '.', ' '); ?></figcaption>
                        </a>
                    </figure>
                <?php else: ?>
                    <figure style="background-image: url(/i/stream_off.jpg)">
                        <a href="/stream/<?= $stream['name'] ?>" class="stream_off">
                            <figcaption><?= $stream['display_name'] ?>: OFF</figcaption>
                        </a>
                    </figure>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>


    </div>
<?php endif; ?>

    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <ul>
            <li><a href="#">CS:GO</a></li>
            <li><img src="/i/bullet.png" alt=""></li>
            <li><a href="#">Киберспорт</a></li>
            <li><img src="/i/bullet.png" alt=""></li>
            <li><a href="#">Стримы</a></li>
            <li><img src="/i/bullet.png" alt=""></li>
            <li>ESL_CSGO</li>
        </ul>
    </div>
    <!-- /breadcrumbs -->

</main>
<!-- /content -->


<?php require_once("../../+/prefooter.php");?>
<?php require_once("../../+/footer.php");?>
</body>
</html>
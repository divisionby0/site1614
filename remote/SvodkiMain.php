<?php
require_once('config.php');
require_once('util.php');


class SvodkiMain
{
    private $db;
    public $startdate;
    private $enddate;
    private $services;
    public $url_final;
    public $counts;
    public function __construct()
    {
        $url_parts = explode('/', strtok($_SERVER["REQUEST_URI"],'?'));
        $this->url_final = $url_parts[count($url_parts) - 1];
        $serviceName = "'{$this->url_final}'";
        $dsn = 'mysql:host='.DBHOST.';dbname='.DBNAME.';charset='.DBCHARSET;
        $options = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->db = new PDO($dsn, DBUSER, DBPASS, $options);

        $twitter_enabled = file_exists( 'twitter/twitter.php');
        $youtube_enabled = file_exists( 'youtube/youtube.php');
        $vkontakte_enabled = file_exists( 'vk/vk.php');
        $instagram_enabled = file_exists( 'instagram/instagram.php');

        $this->services = [];
        if($twitter_enabled){
            $this->services[] = "'twitter'";
        }
        if($youtube_enabled){
            $this->services[] = "'youtube'";
        }
        if($vkontakte_enabled){
            $this->services[] = "'vkontakte'";
        }
        if($instagram_enabled){
            $this->services[] = "'instagram'";
        }

        $curService = '';
        if(in_array($serviceName, $this->services))
        {
            $this->services = [$serviceName];
            $curService = $this->url_final;
        }
        $this->startdate = isset($_REQUEST['day']) && $_REQUEST['day'] ? strtotime($_REQUEST['day']) : strtotime('today');
        $this->enddate = $this->startdate + 60 * 60 * 24;

        $stmt = $this->db->query("SELECT type , COUNT( id ) as cnt FROM  `svodki` WHERE record_date > '" .
            date('Y-m-d', $this->startdate) . "' AND record_date <= '" . date('Y-m-d', $this->enddate) . "' GROUP BY TYPE");
        $total = 0;

        while($row = $stmt->fetch()){
            $this->counts[$row['type']] = (int)$row['cnt'];
            $total += $row['cnt'];
            if($row['type'] == $curService){
                $this->counts['current'] = (int)$row['cnt'];
            }
        }
        $this->counts['total'] = $total;
        $this->counts['current'] = isset($this->counts['current']) ? $this->counts['current'] : $total;
        $this->counts['perpage'] = ENTRIESPERPAGE;
    }

    function displaySvodki($page = 0){
        $services_enabled = implode(',', $this->services);
        $svodki = $this->getEntries($services_enabled, $page * ENTRIESPERPAGE, ENTRIESPERPAGE, $this->startdate, $this->enddate);
        if(count($svodki) > 0) {
            foreach ($svodki as $key => $record) {
                switch ($record['type']) {
                    case 'twitter':
                        $this->displayTwitter($record);
                        break;
                    case 'youtube':
                        $this->displayYoutube($record);
                        break;
                    case 'vkontakte':
                        $this->displayVkontakte($record);
                        break;
                    case 'instagram':
                        $this->displayInstagram($record);
                        break;
                }
            }
        }
        else {
            if($page == 0){
                $this->displayNothing();
            }
        }
        $this->counts['displayed'] = count($svodki);
    }

    function displayTwitter($record) {
        ?>
        <div class="grid-item svodki_twitter">
            <div class="svodki_info_twitter">
                <span><a href="/svodki/twitter" title="Лента новостей CS:GO из twitter">Twitter</a> <b><?= rdate(strtotime($record['created_at'])) ?> от<a href="https://twitter.com/@<?= $record['screen_name'] ?>" title="Перейти на аккаунт <?= $record['screen_name'] ?> в twitter"><img src="<?= $record['profile_image_url'] ?>" alt="<?= $record['screen_name']?>"><em>@</em><?= $record['screen_name'] ?></a></b></span>
                <noindex><div class="anchor"><a href="https://twitter.com/@<?= $record['screen_name'] ?>/status/<?= $record['remote_id']?>" rel="nofollow" target="_blank" title="Перейти на это сообщение в twitter"></a></div></noindex>
            </div>
            <p class="ru">
                <?= $record['text_ru'] ?>
            </p>
            <?php if($record['text_eng']):?>
                <p class="eng">
                    <?= $record['text_eng'] ?>
                </p>
            <?php endif;?>
            <?php if($record['photo_url']): ?>
                <img src="<?= $record['photo_url'] ?>"/>
            <?php endif;?>
        </div>
        <?php
    }

    function displayYoutube($video)
    {
        ?>
        <div class="grid-item svodki_youtube">
            <div class="svodki_info_youtube">
            <span><a href="/svodki/youtube"
                     title="Видео CS:GO в Youtube">youtube</a> <b><?= rdate(strtotime($video['published_at'])) ?><a
                        href="https://www.youtube.com/channel/<?= $video['user_id'] ?>"
                        title="Перейти на ютуб канал <?= $video['usertitle'] ?>"><img src="<?= $video['userthumb'] ?>"
                                                                                      alt="<?php $video['usertitle'] ?>"><?= $video['usertitle'] ?>
                    </a></b></span>
                <noindex>
                    <div class="anchor"><a href="https://www.youtube.com/watch?v=<?= $video['video_id'] ?>" rel="nofollow" target="_blank"
                                           title="Смотреть на Youtube"></a></div>
                </noindex>
            </div>
            <iframe width="540" height="303" src="https://www.youtube.com/embed/<?= $video['video_id'] ?>" frameborder="0"
                    allowfullscreen></iframe>
            <div class="ydesc">
                <nofollow><a href="https://www.youtube.com/watch?v=<?= $video['video_id'] ?>"
                             rel="nofollow"><?= $video['title'] ?></a></nofollow>
            </div>
        </div>
        <?php
    }

    function displayVkontakte($record)
    {
        ?>
        <div class="grid-item svodki_vk">
            <div class="svodki_info_vk">
            <span><a href="/svodki/vkontakte"
                     title="Лента новостей CS:GO из ВКонтакте">vk</a> <b><?= rdate(strtotime($record['publication_date'])) ?>
                    от<a href="https://vk.com/id<?= $record['userid'] ?>"
                         title="Перейти на аккаунт <?= $record['first_name'] ?> <?= $record['last_name'] ?> в ВКонтакте"><img
                            src="<?= $record['photo_url'] ?>"
                            alt="<?= $record['screen_name'] ?>"><?= $record['screen_name'] ?></a></b></span>
                <noindex>
                    <div class="anchor"><a href="https://vk.com/wall<?= $record['userid'] ?>_<?= $record['remote_id'] ?>"
                                           rel="nofollow" target="_blank" title="Перейти на это сообщение ВКонтакте"></a></div>
                </noindex>
            </div>
            <p class="ru">
                <?= $record['text'] ?>
            </p>
            <?php if ($record['post_photo_url']): ?>
                <img src="<?= $record['post_photo_url'] ?>"/>
            <?php endif; ?>
        </div>

        <?php
    }

    function displayInstagram($media)
    {
        ?>
        <div class="grid-item svodki_instagram">
            <div class="svodki_info_instagram">
            <span><a href="/svodki/instagram"
                     title="Лента новостей CS:GO в instagram">instagram</a> <b><?= rdate(strtotime($media['publication_date'])) ?>
                    от<a href="https://instagram.com/<?= $media['username']; ?>"
                         title="Перейти на аккаунт <?= $media['username'] ?> в instagram"><img
                            src="<?= $media['profile_pic_url'] ?>"
                            alt="<?= $media['username'] ?>"><?= $media['username'] ?></a></b></span>
                <noindex>
                    <div class="anchor">
                        <a href="https://instagram.com/p/<?= $media['code'] ?>/" rel="nofollow"
                           target="_blank" title="Смотреть в instagram"></a>
                    </div>
                </noindex>
            </div>
            <p class="ru">
                <?= $media['caption_ru'] ?></p>
            <?php if ($media['caption_eng']): ?>
                <p class="eng">
                    <?= $media['caption_eng'] ?>
                </p>
            <?php endif; ?>
            <img src="<?= $media['media_url'] ?>" alt="">
        </div>
        <?php
    }

    function displayNothing(){
    ?>
        <div class="grid-item svodki_nonews">
            <p>
                Пока новостей нет. <a href="#" title="">Добавить новость</a> от себя
            </p>
        </div>
    <?php
    }

    public function getEntries($services, $offset = 0, $count = 20, $startdate = 0, $enddate = 0){
        $date_str = $startdate ? "AND record_date > '" . date('Y-m-d H:i', $startdate) . "'" : '';
        $date_str .= $enddate  ? " AND record_date <= '" . date('Y-m-d H:i', $enddate) . "'" : '';
        $stmt = $this->db->prepare("SELECT * FROM svodki WHERE type IN ($services) $date_str ORDER BY record_date DESC LIMIT $offset, $count");
        $stmt->execute();
        $ids = [];
        $records = [];
        $recordsHash = [];
        while($row = $stmt->fetch()){
            $ids[$row['type']][] = $row['record_id'];
            $recordsHash[$row['type']][$row['record_id']] = $row['id'];
            $records[$row['id']] = [];
        }
        foreach($ids as $service => $id_array){
            switch($service){
                case 'twitter':
                    require_once('twitter/twitter.php');
                    $twitter = new Twitters();
                    $twits = $twitter->loadTwits(0, $id_array);
                    foreach($twits as $twit){
                        $twit['type'] = 'twitter';
                        $record_id = $recordsHash['twitter'][$twit['id']];
                        $records[$record_id] = $twit;
                    }
                    break;
                case 'youtube':
                    require_once('youtube/youtube.php');
                    $youtube = new Youtube();
                    $youtube_videos= $youtube->loadVideos(0, $id_array);
                    foreach($youtube_videos as $video){
                        $video['type'] = 'youtube';
                        $record_id = $recordsHash['youtube'][$video['id']];
                        $records[$record_id] = $video;
                    }
                    break;
                case 'instagram':
                    require_once('instagram/instagram.php');
                    $instagram = new Instagram();
                    $instagram_posts = $instagram->loadPosts(0, $id_array);
                    foreach($instagram_posts as $post){
                        $post['type'] = 'instagram';
                        $record_id = $recordsHash['instagram'][$post['id']];
                        $records[$record_id] = $post;
                    }
                    break;
                case 'vkontakte':
                    require_once('vk/vk.php');
                    $vk= new Vk();
                    $vk_posts = $vk->loadPosts(0, $id_array);
                    foreach($vk_posts as $post){
                        $post['type'] = 'vkontakte';
                        $record_id = $recordsHash['vkontakte'][$post['id']];
                        $records[$record_id] = $post;
                    }
                    break;
            }
        }
        return $records;
    }

    function getCurrentDateText($usebold = true, $short = false, $date = false){
        $curDate = $date ?: $this->startdate;
        if($short){
            $text = $curDate ==
            strtotime('today') ?
                'Сегодня' :
                ($curDate == strtotime('yesterday') ?
                    'Вчера' : rdate($curDate));
        }
        else {
            $text = $curDate ==
            strtotime('today') ?
                ($usebold ? '<strong>Сегодня,</strong> ' : 'Сегодня, ') :
                ($curDate == strtotime('yesterday') ?
                    ($usebold ? '<strong>Вчера,</strong> ' : 'Вчера, ') : '');
            $text .= rdate($curDate, false);
        }
        return $text;
    }

    function pager(){
        $today = strtotime('today');
        $firstDate = $this->getFirstFoundDate();
        $start = min($today, $this->startdate + 60 * 60 * 24);
        $start = max($firstDate + 2 * 60 * 60 * 24, $start);
        $pagerStr = '';
        $curDay = $start;
        if($curDay < $today){
            $pagerStr .= '<li><a href="/svodki/?day=' . date('Y-m-d', $today) . '">' . $this->getCurrentDateText(false, false, $today) . '</a></li>';
            if($curDay < $today - 60 * 60 * 24) {
                $pagerStr .= '<li><span>&hellip;</span></li>';
            }
        }
        for($curItem = 0; $curItem < 3; $curItem++){
            $pagerStr .= '<li>' .
                ($curDay == $this->startdate ? $this->getCurrentDateText(false, false, $curDay) :
                    '<a href="/svodki/?day=' . date('Y-m-d', $curDay) . '">' . $this->getCurrentDateText(false, false, $curDay) . '</a>') . '</li>';
            $curDay-= 60 * 60 * 24;
        }
        if($curDay > $firstDate - 60 * 60 * 24){
            if($curDay > $firstDate) {
                $pagerStr .= '<li><span>&hellip;</span></li>';
            }
            $pagerStr .= '<li><a href="/svodki/?day=' . date('Y-m-d', $firstDate) . '">' . $this->getCurrentDateText(false, false, $firstDate) . '</a></li>';
        }
        return $pagerStr;
    }

    function getFirstFoundDate(){
        $service_filter = count($this->services) == 1 ? "AND type = {$this->services[0]}" : '';
        $stmt = $this->db->query("SELECT MIN(record_date) FROM svodki WHERE 1=1 $service_filter");
        $timeStr = $stmt->fetchColumn();
        return strtotime(explode(' ', $timeStr)[0]);
    }

    function getPageTitle(){
        switch($this->url_final){
            case 'twitter':
                return 'Twitter CS:GO';
            case 'youtube':
                return 'Youtube CS:GO';
            case 'vkontakte':
                return 'Вконтакте CS:GO';
            case 'instagram':
                return 'Instagram CS:GO';
            default:
                return 'Сводки с фронта';
        }
    }

    function getCount($service){
        return isset($this->counts[$service]) ? '+' . $this->counts[$service] : '';
    }

    function haveMore(){
        $key = in_array($this->url_final, ['twitter', 'vkontakte', 'youtube', 'instagram']) ? $this->url_final : 'total' ;
        if(isset($this->counts[$key])){
            return $this->counts[$key] > ENTRIESPERPAGE;
        }
        return false;
    }

    function dateQuery(){
        return $this->startdate == strtotime('today') ? '' : ('?day=' . date('Y-m-d', $this->startdate));
    }
}
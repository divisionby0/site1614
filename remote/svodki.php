<?php 
DEFINE('STREAM_SUBSYSTEM', true);
require_once('SvodkiMain.php');
require_once ("../div0/DBConfig.php");


$svodki = new SvodkiMain();

if(isset($_REQUEST['sv'])):
    $svodki->displaySvodki($_REQUEST['page']);
else:
?>
<!doctype HTML>
<html>
<head>
    <title>Сводки</title>
    <meta name="description" content="?" />
    <meta name="keywords" content="?" />
    <?php require_once("../+/meta.php");?>
</head>
<body>
<?php require_once("../+/header.php");?>

<script type="text/javascript">
    var recordCounts = <?= json_encode($svodki->counts) ?>;
    var currentDate = '<?= date('Y-m-d', $svodki->startdate) ?>';
</script>

<main class="svodki">

    <div class="breadcrumbs">
        <ul>
            <li><a href="#">CS:GO</a></li>
            <li><img src="/i/bullet.png" alt=""></li>
            <li>Сводки (сегодня, 15 июня)</li>
        </ul>
    </div>
    
    <nav class="svodki">
        <ul>
            <?php if($svodki->url_final == ''): ?>
            <li>Всё</li>
            <?php else: ?>
                <li><a href="/svodki/<?= $svodki->dateQuery() ?>">Всё</a><sup><?= $svodki->getCount('total')?></sup></li>
            <?php endif; ?>
            <li><a href="#">Новости</a><sup></sup></li>
            <?php if($svodki->url_final == 'twitter'): ?>
                <li>Twitter</li>
            <?php else: ?>
                <li><a href="/svodki/twitter<?= $svodki->dateQuery() ?>">Twitter</a><sup><?= $svodki->getCount('twitter')?></sup></li>
            <?php endif; ?>
            <?php if($svodki->url_final == 'vkontakte'): ?>
            <li>Вконтакте</li>
            <?php else: ?>
            <li><a href="/svodki/vkontakte<?= $svodki->dateQuery() ?>">Вконтакте</a><sup><?= $svodki->getCount('vkontakte')?></sup></li>
            <?php endif; ?>
                <?php if($svodki->url_final == 'youtube'): ?>
                <li>Youtube</li>
            <?php else: ?>
            <li><a href="/svodki/youtube<?= $svodki->dateQuery() ?>">Youtube</a><sup><?= $svodki->getCount('youtube')?></sup></li>
            <?php endif; ?>
            <?php if($svodki->url_final == 'instagram'): ?>
                <li>Instagram
            <?php else: ?>
            <li><a href="/svodki/instagram<?= $svodki->dateQuery() ?>">Instagram</a><sup><?= $svodki->getCount('instagram')?></sup></li>
            <?php endif; ?>
        </ul>
        <div>
            <p>Сообщить новость</p>
        </div>
    </nav>

    <h1 class="center"><?= $svodki->getPageTitle()?></h1>
    <div class="today_date"><?= $svodki->getCurrentDateText()?></div>
    <div class="grid">

<?php
$svodki->displaySvodki();
?>

        <?php
        if(false):
        ?>
        <div class="grid-item svodki_news">
            <div class="svodki_info_news"><span><a href="#" title="Новости CS:GO">Новости</a> <b>Менее часа назад от BOT Eliot</b></span></div>
            <h3><a href="#">Adren и&nbsp;Mou покидают HellRaisers</a></h3>
            <div class="svodki_news_tags"><span><a href="#" title="Прочитать все новости, которые содержат тег «hellraisers»">hellraisers</a></span><span>adren</span><span><a href="#" title="Прочитать все новости, которые содержат тег «mou»">mou</a></span></div>
            <div class="svodki_news_preview"><a href="#" title="Adren и Mou покидают HellRaisers"><img src="/i/temp_preview.jpg" alt="Adren и Mou покидают HellRaisers"/></a></div>

            <p>
                HellRaisers вынуждены изменить свой состав. Несколько минут назад стало известно, что
                Даурен «AdreN» Кыстаубаев и&nbsp;Рустем «mou» Тлепов решили покинуть  HellRaisers.
                Скорее всего причиной стали неутешительные результаты. Хотел бы&nbsp;напомнить, что
                команда недавно попрощалась с&nbsp;Михаилом «Dosia» Столяровым&nbsp;<noindex><a href="#" title="Читать полностью">&hellip;</a></noindex>
            </p>
            <div class="svodki_news_summary"><strong style="color:#2d2716" title="Кол-во патронов" >0</strong>&nbsp;<a href="#" class="svodki_comment_link">Прокомментируй первым</a></div>
        </div>


        <div class="grid-item svodki_news">
            <div class="svodki_info_news"><span><a href="#" title="Новости CS:GO">Новости</a> <b>Менее часа назад от BOT Eliot</b></span></div>
            <h3><a href="#">Adren и&nbsp;Mou покидают HellRaisers</a></h3>
            <div class="svodki_news_tags"><span><a href="#" title="Прочитать все новости, которые содержат тег «hellraisers»">hellraisers</a></span><span>adren</span><span><a href="#" title="Прочитать все новости, которые содержат тег «mou»">mou</a></span></div>
            <div class="svodki_news_preview"><a href="#" title="Adren и Mou покидают HellRaisers"><img src="/i/temp_preview.jpg" alt="Adren и Mou покидают HellRaisers"/></a></div>

            <p>
                HellRaisers вынуждены изменить свой состав. Несколько минут назад стало известно, что
                Даурен «AdreN» Кыстаубаев и&nbsp;Рустем «mou» Тлепов решили покинуть  HellRaisers.
                Скорее всего причиной стали неутешительные результаты. Хотел бы&nbsp;напомнить, что
                команда недавно попрощалась с&nbsp;Михаилом «Dosia» Столяровым&nbsp;<noindex><a href="#" title="Читать полностью">&hellip;</a></noindex>
            </p>
            <div class="svodki_news_summary"><strong style="color:#2d2716" title="Кол-во патронов" >0</strong>&nbsp;<a href="#" class="svodki_comment_link">Прокомментируй первым</a></div>
        </div>

        <div class="grid-item svodki_twitter">
            <div class="svodki_info_twitter">
                <span><a href="#" title="Лента новостей CS:GO из twitter">Twitter</a> <b>10 минут назад от<a href="#" title="Перейти на аккаунт HLTVorg в twitter"><img src="/i/temp_twi_ava.jpg" alt="HLTVorg"><em>@</em>HLTVorg</a></b></span>
                <noindex><div class="anchor"><a href="#" rel="nofollow"  title="Перейти на это сообщение в twitter"></a></div></noindex>
            </div>
            <p class="ru">
                График сегодняшнего имеет много совпадений между ведущими мировыми 20 команд в&nbsp;ESL ESEA, <a href="#" rel="nofollow">#FaceIt</a> &&nbsp;CEVO (раз в ЦЭСТ)
            </p>
            <p class="eng">
                Tonight's schedule has plenty of matches between the world's top 20 teams in ESL ESEA, FACEIT & CEVO (times in CEST)
            </p>
        </div>

        <?php endif;?>
    </div>
    <div class="clear"></div>

    <?php
        if($svodki->haveMore()):
    ?>
    <div class="loadmore"><a href="#">Подгрузить ещё сводки за <?= $svodki->getCurrentDateText(false,true)?></a><img src="/i/loadmore.png" ></div>
    <?php endif; ?>
    <ul class="pagination">
        <?= $svodki->pager() ?>
    </ul>

    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <ul>
            <li><a href="#">CS:GO</a></li>
            <li><img src="/i/bullet.png" alt=""></li>
            <li>Сводки (<?= $svodki->getCurrentDateText(false) ?>)</li>
        </ul>
    </div>
    <!-- /breadcrumbs -->

</main>
<!-- /content -->


<?php require_once("../+/prefooter.php");?>
<?php require_once("../+/footer.php");?>
</body>
</html>
<?php endif; ?>
<?php session_start(); ?>
<!doctype HTML>
<html>

<head>
  <title>CS:GO • Новости, стримы и обсуждение на сайте 16-14.ru</title>
  <meta name="description" content="?" />
  <meta name="keywords" content="csgo, cs, cs:go, контра, кс" />
  <?php
  require_once("+/meta.php");
  include_once ("div0/utils/Logger.php");
  ?>
</head>

<body>
  <?php require_once("+/header.php");?>
    <!-- content -->
    <main class="index">
<?php

$streamSubsystemExists = file_exists( 'remote/stream/stream.php');
Logger::logMessage("streamSubsystemExists=".$streamSubsystemExists);

    if($streamSubsystemExists):
        DEFINE('STREAM_SUBSYSTEM', true);
        require_once('remote/stream/stream.php');
        $streams = new Streams();
        $streamList = $streams->loadStreamsData( 8 );
?>
      <div class="streams">
        <h2><a href="/streams">Онлайн стримы</a></h2>
        <div id="streams__area" class="streams__area">
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



      <!-- svodki -->
      <div class="news__row">
        <h2><a href="#">Сводки с фронта</a></h2>
		
		<div class="svodki_news sticked">
		  <img src="/i/img-sticked.png" alt="" title="Закреплено" />
          <div class="svodki_info_news"><span><a href="#" title="Новости CS:GO">новости</a> <b>Только что от <a href="#">skvsk</a></b></span></div>
          <h3><a href="#">Обновление CS:GO от 13.06.16: появились новые наклейки и&nbsp;скины к&nbsp;оружию</a></h3>
          <div class="svodki_news_tags"><span><a href="#" title="Прочитать все новости, которые содержат тег «hellraisers»">Патч</a></span></div>
          <p>
            <noindex><a href="#" title="Читать полностью">&hellip;</a></noindex>
          </p>
          <div class="svodki_news_summary"><strong style="color:#2d2716" title="Кол-во патронов">0</strong>&nbsp;<a href="#" class="svodki_comment_link">Прокомментируй первым</a></div>
        </div>
		
		<div class="svodki_instagram">
          <div class="svodki_info_instagram">
            <span><a href="#" title="Лента новостей CS:GO из twitter">instagram</a> <b>5 минут назад от<a href="#" title="Перейти на аккаунт get_rightcs в instagram"><img src="/i/temp_twi_ava.jpg" alt="get_rightcs">get_rightcs</a></b></span>
            <noindex>
              <div class="anchor">
                <a href="#" rel="nofollow" title="Перейти на это сообщение в instagram"></a>
              </div>
            </noindex>
          </div>
          <p class="ru">
            На&nbsp;нашем пути к&nbsp;Ландскрона, направляясь в&nbsp;Лондон завтра! Если&nbsp;бы удивительное время на&nbsp;DreamHack, как всегда, но&nbsp;до&nbsp;сих пор грустит о&nbsp;размещении второй. 
			Но&nbsp;это время голову назад в&nbsp;офис и&nbsp;просто сосредоточиться еще больше на&nbsp;CSGO Спасибо всем, кто пришел на&nbsp;стенд, который был <a href="#" rel="nofollow">@xtrfy</a> и&nbsp;сделал наше путешествие круто.    </p>
          <p class="eng">
            On&nbsp;our way to&nbsp;Landskrona, heading to&nbsp;London tomorrow! Had a&nbsp;amazing time on&nbsp;DreamHack as&nbsp;always, but still sad about placing second. But it&rsquo;s time to&nbsp;head back 
			to&nbsp;the office and just focus even more on&nbsp;CSGO Thanks everyone who came by&nbsp;the booth that <a href="#" rel="nofollow">@xtrfy</a> had and made our trip cool.
          </p>
		  <img src=" https://scontent-frt3-1.cdninstagram.com/l/t51.2885-15/e35/13422985_239410819776261_45723686_n.jpg" alt="">
		   <div class="idesc">
            <span>3450 likes</span>
		  </div>
        </div>
		
        <div class="svodki_news">
          <div class="svodki_info_news"><span><a href="#" title="Новости CS:GO">Новости</a> <b>Менее часа назад от BOT Eliot</b></span></div>
          <h3><a href="#">Adren и&nbsp;Mou покидают HellRaisers</a></h3>
          <div class="svodki_news_tags"><span><a href="#" title="Прочитать все новости, которые содержат тег «hellraisers»">hellraisers</a></span><span>adren</span><span><a href="#" title="Прочитать все новости, которые содержат тег «mou»">mou</a></span></div>
          <div class="svodki_news_preview">
            <a href="#" title="Adren и Mou покидают HellRaisers"><img src="/i/temp_preview.jpg" alt="Adren и Mou покидают HellRaisers" /></a>
          </div>
          <p>
            HellRaisers вынуждены изменить свой состав. Несколько минут назад стало известно, что Даурен «AdreN» Кыстаубаев и&nbsp;Рустем «mou» Тлепов решили покинуть HellRaisers. Скорее всего причиной стали неутешительные результаты. Хотел бы&nbsp;напомнить, что
            команда недавно попрощалась с&nbsp;Михаилом «Dosia» Столяровым&nbsp;
            <noindex><a href="#" title="Читать полностью">&hellip;</a></noindex>
          </p>
          <div class="svodki_news_summary"><strong style="color:#2d2716" title="Кол-во патронов">0</strong>&nbsp;<a href="#" class="svodki_comment_link">Прокомментируй первым</a></div>
        </div>

        <div class="svodki_twitter">
          <div class="svodki_info_twitter">
            <span><a href="#" title="Лента новостей CS:GO из twitter">Twitter</a> <b>10 минут назад от<a href="#" title="Перейти на аккаунт HLTVorg в twitter"><img src="/i/temp_twi_ava.jpg" alt="HLTVorg"><em>@</em>HLTVorg</a></b></span>
            <noindex>
              <div class="anchor">
                <a href="#" rel="nofollow" title="Перейти на это сообщение в twitter"></a>
              </div>
            </noindex>
          </div>
          <p class="ru">
            График сегодняшнего имеет много совпадений между ведущими мировыми 20 команд в&nbsp;ESL ESEA, <a href="#" rel="nofollow">#FaceIt</a> &&nbsp;CEVO (раз в ЦЭСТ)
          </p>
          <p class="eng">
            Tonight's schedule has plenty of matches between the world's top 20 teams in ESL ESEA, FACEIT & CEVO (times in CEST)
          </p>
        </div>

        <div class="svodki_twitter">
          <div class="svodki_info_twitter">
            <span><a href="#" title="Лента новостей CS:GO из twitter">Twitter</a> <b>10 минут назад от<a href="#" title="Перейти на аккаунт HLTVorg в twitter"><img src="/i/temp_twi_ava.jpg" alt="HLTVorg"><em>@</em>HLTVorg</a></b></span>
            <noindex>
              <div class="anchor">
                <a href="#" rel="nofollow" title="Перейти на это сообщение в twitter"></a>
              </div>
            </noindex>
          </div>
          <p class="eng">
            Tonight's schedule has plenty of matches between the world's top 20 teams in ESL ESEA, <a href="#" rel="nofollow">FACEIT</a> & CEVO (times in CEST)
          </p>
          <a href="#" class="single">hitbox.tv/csruhub</a>
          <img src="/i/temp_twi_img.jpg" alt="">
        </div>

        <div class="svodki_news">
          <div class="svodki_info_news"><span><a href="#" title="Новости CS:GO">Новости</a> <b>Сегодня от <a href="#" title="Профиль пользователя Ugin">Ugin</a></b></span></div>
          <h3><a href="#">VP и TSM проходят в финал сетки победителей PGL Season 1</a></h3>
          <div class="svodki_news_tags"><span><a href="#" title="Прочитать все новости, которые содержат тег «virtus-pro»">virtus-pro</a></span><span><a href="#" title="Прочитать все новости, которые содержат тег «tsm»">tsm</a></span></div>
          <p>
            Virtus.pro и&nbsp;Team SoloMid выходят в&nbsp;верхнюю сетку PGL Season 1. В&nbsp;последней схватке Virtus.pro одолели своего соперника Team Liquid, а&nbsp;Team SoloMid в&nbsp;свою очередь победили команду Fnatic и&nbsp;также попали в&nbsp;верхнюю сетку
            финала. Virtus.pro vs&nbsp;Team Liquid Битва между Virtus.pro и&nbsp;Team Liquid происходила на&nbsp;картах de_overpass и&nbsp;de_mirage. На&nbsp;de_overpass Virtus.pro показали&nbsp;
            <noindex><a href="#" title="Читать полностью">&hellip;</a></noindex>
          </p>
          <div class="svodki_news_summary"><a href="#">4 комментария</a>&nbsp;
            <a href="#" title="Перейти к последнему комментарию" class="last_comment"></a>
          </div>
        </div>

        <div class="svodki_twitter">
          <div class="svodki_info_twitter">
            <span><a href="#" title="Лента новостей CS:GO из twitter">Twitter</a> <b>Час назад от<a href="#" title="Перейти на аккаунт Arsenij Trynozhenko в twitter"><img src="/i/temp_twi_ava.jpg" alt="Arsenij Trynozhenko"><em>@</em>Arsenij Trynozhenko</a></b></span>
            <noindex>
              <div class="anchor">
                <a href="#" rel="nofollow" title="Перейти на это сообщение в twitter"></a>
              </div>
            </noindex>
          </div>
          <p class="ru">
            Сегодня буду отдыхать, без стримов, братки
          </p>
        </div>

        <div class="svodki_vk">
          <div class="svodki_info_vk">
            <span><a href="#" title="Лента новостей CS:GO из Vkontakte">vk</a> <b>Час назад от<a href="#" title="Перейти на аккаунт ceh9 вконтакте"><img src="https://pp.vk.me/c629423/v629423232/2e17a/NwmooCvtRGU.jpg" alt="ceh9">ceh9</a></b></span>
            <noindex>
              <div class="anchor">
                <a href="#" rel="nofollow" title="Перейти на это сообщение вконтакте"></a>
              </div>
            </noindex>
          </div>
          <!--<p class="ru">
					Довольно интересный гайд получился, о коммуникации в команде
				</p>-->
          <iframe width="540" height="303" src="https://www.youtube.com/embed/49IiMsuQ4Qk" frameborder="0" allowfullscreen></iframe>
          <div class="vdesc">
            <nofollow><a href="#" rel="nofollow">CS:GO Guide by ceh9:"Effective Communication in CS:GO" (ENG SUBS)</a></nofollow><span>3450 просмотров</span>
		  </div>
        </div>

        <div class="all"><a href="#">Все сводки</a></div>

      </div>
      <!-- /svodki -->

      <!-- right_side -->
      <div class="right_side">

		
		 
		 
        <!-- questions -->
        <h2><a href="#">Новые вопросы</a></h2>
		
		<div class="question sticked">
          <img src="/i/img-inside.png" alt="" title="Вопрос подкреплён изображением или скриншотом" />
          <table>
            <tr>
               <td valign="middle" align="center" width="50"><span class="patrons" style="color:#735f27" title="Кол-во патронов">18</span></td>
              <td>
                <div class="svodki_info_news"><span><b>Сегодня от <a href="#" title="Профиль пользователя Ugin">Ugin</a></b></span></div>
                <h4><a href="#">Ошибка(Pure server: file [GAME]\pak01_001.vpk does not match the...</a></h4>
                <ul>
                  <li><a href="#">технические проблемы</a></li>
                  <li>137 просмотров</li>
                  <li>Ждёт ответа</li>
                </ul>
              </td>
            </tr>
          </table>
        </div>
		
		<div class="question ">
          <img src="/i/img-sticked.png" alt="" title="Закреплено" />
          <table>
            <tr>
              <td valign="middle" align="center" width="50"><span class="patrons" style="color:#f9cc4f" title="Кол-во патронов">0</span></td>
              <td>
                <div class="svodki_info_news"><span><b>Сегодня от <a href="#" title="Профиль пользователя Levitas">Levitas</a></b></span></div>
                <h4><a href="#">Внимание! Внимание! Говорит Германия</a></h4>
                <ul>
                  <li><a href="#">о проекте</a></li>
                  <li>137 просмотров</li>
                  <li>Ждёт ответа</li>
                </ul>
              </td>
            </tr>
          </table>
        </div>
		
        

        <div class="question">
          <table>
            <tr>
              <td valign="middle" align="center" width="50"><span class="patrons" style="color:#735f27" title="Кол-во патронов">22</span></td>
              <td>
                <div class="svodki_info_news"><span><b>1 час назад от <a href="#" title="Профиль пользователя B3r1m0R">B3r1m0R</a></b></span></div>
                <h4><a href="#">4:3 растянутый на windows 10</a></h4>
                <ul>
                  <li><a href="#">технические проблемы</a></li>
                  <li>137 просмотров</li>
                  <li><a href="#" class="svodki_comment_link">2 ответа</a>&nbsp;
                    <a href="#" title="Перейти к последнему ответу" class="last_comment"></a>
                  </li>
                  <li></li>
                </ul>
              </td>
            </tr>
          </table>
        </div>

        <div class="question">
          <table>
            <tr>
              <td valign="middle" align="center" width="50"><span class="patrons" style="color:#f9cc4f" title="Кол-во патронов">1&nbsp;012</span></td>
              <td>
                <div class="svodki_info_news"><span><b>Сегодня от <a href="#" title="Профиль пользователя Ugin">Ugin</a></b></span></div>
                <h4><a href="#">Ошибка(Pure server: file [GAME]\pak01_001.vpk does not match the asdasdas asdas asddddd</a></h4>
                <ul>
                  <li><a href="#">технические проблемы</a></li>
                  <li>137 просмотров</li>
                  <li>Ждёт ответа</li>
                </ul>
              </td>
            </tr>
          </table>
        </div>

        <div class="question">
          <img src="/i/img-inside.png" alt="" title="Вопрос подкреплён изображением или скриншотом" />
          <table>
            <tr>
              <td valign="middle" align="center" width="50"><span class="patrons" style="color:#735f27" title="Кол-во патронов">120</span></td>
              <td>
                <div class="svodki_info_news"><span><b>1 час назад от <a href="#" title="Профиль пользователя B3r1m0R">B3r1m0R</a></b></span></div>
                <h4><a href="#">4:3 растянутый на windows 10</a></h4>
                <ul>
                  <li><a href="#">технические проблемы</a></li>
                  <li>137 просмотров</li>
                  <li><a href="#" class="svodki_comment_link">2 ответа</a>&nbsp;
                    <a href="#" title="Перейти к последнему ответу" class="last_comment"></a>
                  </li>
                </ul>
              </td>
            </tr>
          </table>
        </div>

        <div class="all"><a href="#">Все вопросы</a></div>
        <!-- /questions -->
		
		<!-- blogs -->
        <h2 style="margin-top:45px"><a href="#">Новое в блогах</a></h2>
		
		<div class="question">
          <img src="/i/img-sticked.png" alt="" title="Закреплено" />
          <table>
            <tr>
              <td valign="middle" align="center" width="50"><span class="patrons" style="color:#f9cc4f" title="Кол-во патронов">0</span></td>
              <td>
                <div class="svodki_info_news"><span><b>1 час назад от <a href="#" title="Профиль пользователя Levitas">Levitas</a></b></span></div>
                <h4><a href="#">Внимание! Внимание! Говорит Германия</a></h4>
                <ul>
                  <li>137 просмотров</li>
                  <li>Ждёт комментария</li>
				  <li><a href="#" title="Перейти в блог имени Levitas'a">Блог имени Levitas</a>'a</li>
                </ul>
              </td>
            </tr>
          </table>
        </div>
		
        <div class="question">
          <img src="/i/img-inside.png" alt="" title="Вопрос подкреплён изображением или скриншотом" />
          <table>
            <tr>
              <td valign="middle" align="center" width="50"><span class="patrons" style="color:#f9cc4f" title="Кол-во патронов">5k</span></td>
              <td>
                <div class="svodki_info_news"><span><b>Сегодня от <a href="#" title="Профиль пользователя Ugin">Ugin</a></b></span></div>
                <h4><a href="#">Ошибка(Pure server: file [GAME]\pak01_001.vpk does not match the...</a></h4>
                <ul>
                  
                  <li>2 просмотра</li>
                  <li><a href="#" class="svodki_comment_link">2 комментария</a>&nbsp;
                    <a href="#" title="Перейти к последнему комментарию" class="last_comment"></a></li>
				  <li><a href="#" title="Перейти в блог имени Ugin'a">Блог имени Ugin</a>'a</li>
                </ul>
              </td>
            </tr>
          </table>
        </div>
		
		<div class="question">
          <img src="/i/img-inside.png" alt="" title="Вопрос подкреплён изображением или скриншотом" />
          <table>
            <tr>
              <td valign="middle" align="center" width="50"><span class="patrons" style="color:#f9cc4f" title="Кол-во патронов">5k</span></td>
              <td>
                <div class="svodki_info_news"><span><b>Сегодня от <a href="#" title="Профиль пользователя Ugin">skvsk</a></b></span></div>
                <h4><a href="#">Ошибка(Pure server: file [GAME]\pak01_001.vpk does not match the...</a></h4>
                <ul>
                  
                  <li>2 просмотра</li>
                  <li><a href="#" class="svodki_comment_link">1 комментарий</a>&nbsp;
                    <a href="#" title="Перейти к последнему комментарию" class="last_comment"></a></li>
				  <li><a href="#" title="Перейти в блог имени skvsk'a">Блог имени skvsk</a>'a</li>
                </ul>
              </td>
            </tr>
          </table>
        </div>
		
		<div class="all"><a href="#">Все блоги</a></div>
		 <!-- /blogs -->

        <!-- matches -->
        <div class="b__matches">
          <h2><a href="#">Ближайшие матчи</a></h2>

          <div class="m__a m__live">
            <p>CEVO Professional Season 8</p><strong>LIVE</strong>
            <a href="#">
              <table>
                <tr>
                  <td><span class='team'>Titan.CS</span><img src="/i/flags/france.jpg" alt="" /></td>
                  <td class="vstd" valign="middle"></td>
                  <td align="right"><img src="/i/flags/eu.jpg" alt="" /><span class='team'>Gamers2</span></td>
                </tr>
              </table>
            </a>
          </div>

          <div class="m__a">
            <p>QuickShot Arena #10</p><strong>1 ч 29 мин</strong>
            <a href="#">
              <table>
                <tr>
                  <td><span class='team'>ESC Gaming</span></td>
                  <td class="vstd" valign="middle"></td>
                  <td align="right"><span class='team'>Team BX3</span></td>
                </tr>
              </table>
            </a>
          </div>

          <div class="m__a">
            <p>QuickShot Arena #10</p><strong>17:00 мск</strong>
            <a href="#">
              <table>
                <tr>
                  <td><span class='team'>Titan.CSasda</span><img src="/i/flags/france.jpg" alt="" /></td>
                  <td class="vstd" valign="middle"></td>
                  <td align="right"><img src="/i/flags/eu.jpg" alt="" /><span class='team'>Gamers2</span></td>
                </tr>
              </table>
            </a>
          </div>

          <div class="m__a">
            <p>QuickShot Arena #10</p><strong>17:00 мск</strong>
            <a href="#">
              <table>
                <tr>
                  <td><span class='team'>Titan.CS</span><img src="/i/flags/france.jpg" alt="" /></td>
                  <td class="vstd" valign="middle"></td>
                  <td align="right"><img src="/i/flags/eu.jpg" alt="" /><span class='team'>Gamersasda2s</span></td>
                </tr>
              </table>
            </a>
          </div>
          <div class="m__a">
            <p>QuickShot Arena #10</p><strong>1 ч 29 мин</strong>
            <a href="#">
              <table>
                <tr>
                  <td><span class='team'>ESC Gaming</span></td>
                  <td class="vstd" valign="middle"></td>
                  <td align="right">
                    </span><img src="/i/flags/france.jpg" alt="" /><span class='team'>Team BX3</span></td>
                </tr>
              </table>
            </a>
          </div>


          <div class="all"><a href="#">Все матчи</a></div>
        </div>
        <!-- /matches -->

        <!-- tourneys -->
        <div class="b__tourneys">
          <h2><a href="#">Турниры</a></h2>

          <div class="m__a t_a m__live">
            <a href="#">ESL ESEA Pro League Season 2</a>
            <p>14 дек — 20 фев</p>
            <strong>$ 1 250 000</strong>
          </div>
          <div class="m__a t_a">
            <a href="#">FACEIT League 2015</a>
            <p>Осень 2015</p>
            <strong>$ 150 000</strong>
          </div>
          <div class="m__a t_a">
            <a href="#">CS:GO Champions League Season 2</a>
            <p>2 недели</p>
            <strong>$ 50 000</strong>
          </div>
          <div class="m__a t_a">
            <a href="#">CEVO Professional Season 8</a>
            <p>Дата неизвестна</p>
            <strong>$ 175 000</strong>
          </div>

          <div class="all"><a href="#">Все турниры</a></div>
        </div>
        <!-- /tourneys -->


        <!-- random_team -->
        <div class="b__matches" style="margin:-85px 0 0 20px!important;float: right;">
          <h2>Случайная <a href="#">команда</a></h2>
          <div class="random_team">

            <h5 style="background:url(/i/teams/fnatic/fnatic_avatar.png) no-repeat"><a href="#" title="Команда CS:GO Fnatic">Fnatic</a> <span title="Процент побед на про-сцене">66.17%</span></h5>
            <ul>
              <li>
                <a href="#"><img src="/i/teams/fnatic/olaf.jpg" alt=""></a>
              </li>
              <li>
                <a href="#"><img src="/i/teams/fnatic/olaf.jpg" alt=""></a>
              </li>
              <li>
                <a href="#"><img src="/i/teams/fnatic/olaf.jpg" alt=""></a>
              </li>
              <li>
                <a href="#"><img src="/i/teams/fnatic/olaf.jpg" alt=""></a>
              </li>
              <li>
                <a href="#"><img src="/i/teams/fnatic/olaf.jpg" alt=""></a>
              </li>
            </ul>
            <table cellpadding="0" cellspacing="0">
              <tr>
                <td><span>Страна:</span></td>
                <td align="right"><img src="/i/flags/france.jpg" alt="">Швеция</td>
              </tr>
              <tr>
                <td><span>Игр на про-сцене:</span></td>
                <td align="right">616</td>
              </tr>
              <tr>
                <td><span title="Соотношение убийств к смертям">K/D R</span></td>
                <td align="right">1.2</td>
              </tr>
            </table>
          </div>
          <div class="all"><a href="#">Все команды</a></div>
        </div>
        <!-- /random_team -->


        <!-- 240400 -->
        <div class="a240400">
          <a href="#"><img src="/i/temp_240400.jpg" alt=""></a>
        </div>
        <!-- /240400 -->


      </div>
      <!-- /right_side -->

    </main>
    <!-- /content -->


    <?php require_once("+/prefooter.php");?>
      <?php require_once("+/footer.php");?>
</body>

</html>

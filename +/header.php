<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/remote/steam/steamsignin.php');
?>
<header>
		<p id="botNameContainer">BOT Eliot: Comeback Israel</p>

	<?php if(isset($_SESSION['steam_user'])): ?>
		<ul class="auth" style="background:url(<?= $_SESSION['steam_user']['avatar']?>) no-repeat;">
			<li>
				<a href="http://steamcommunity.com/profiles/<?php $_SESSION['steam_user']['id'] ?>/" class="green" title="Перейти в свой профиль на этом сайте"><?php echo $_SESSION['steam_user']['name'];?></a>
			</li>
			<li><a href="/remote/steam/login.php?a=logout" title="Разлогиниться [выйти]">&#215;</a></li>
		</ul>
	<?php else: ?>
		<div class="auth" style="background-image:">
			<a href="<?= SteamSignIn::genUrl()?>" class="green">Войти на сайт</a>
		</div>
	<?php endif; ?>

		<div class="logo"><a href="/"><img src="/i/1614.png" alt="16-14"></a></div>

		<nav>
			<ul>
				<li class="active">
					<h2>cs:go</h2>
				</li>
				<li>
					<a href="/svodki/" class="nav">Сводки</a>
				</li>
				<li >
					<a href="/streams" class="nav">Стримы</a>
				</li>
				
				<li>
					<a href="/qa" class="nav">Вопросы</a>
				</li>
				<li><a href="#" class="nav">Блоги</a></li>
			</ul>
			<div class="ya-site-form ya-site-form_inited_no searchfield" onclick="return {'action':'http://1614.ru/searchresults','arrow':false,'bg':'transparent','fontsize':12,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по сайту 1614.ru','suggest':true,'target':'_self','tld':'ru','type':3,'usebigdictionary':true,'searchid':2277154,'input_placeholder':'поиск по сайту','input_borderColor':'#7f9db9'}">
				<form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8"><input type="hidden" name="searchid" value="2277154"/>
					<input type="hidden" name="l10n" value="ru"/>
					<input type="hidden" name="reqenc" value=""/>
					<input type="search" name="text" value="" class="searchfield__input"/>
				</form>
				<a href="javascript:;" class="searchfield__button searchfield__button_active">
					<img src="/i/search-icon.png" alt="">
				</a>
			</div>
					<input type="text" name="name" disabled class="searchfield__input" placeholder="Поиск на сайте">
			
		</nav>
	</header>
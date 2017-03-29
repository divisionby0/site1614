<!doctype HTML>
<html>
	<head>
		<title>Стримы</title>
		<meta name="description" content="?" /> 
		<meta name="keywords" content="?" /> 
		<?php require_once("+/meta.php");?>
	</head>
	<body>
	<?php require_once("+/header.php");?>
	
	
	<!-- content -->
	<main class="streams">
	
		<!-- breadcrumbs -->
		<div class="breadcrumbs">
			<ul>
				<li><a href="#">CS:GO</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li><a href="#">Киберспорт</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li>Стримы</li>
			</ul>
		</div>
		<!-- /breadcrumbs -->
		
		<!-- nav -->
		<nav>
				<ul>
					<li><a href="#">Киберспорт</a></li>
					<li>Стримы</li>
					<li><a href="#">Турниры</a></li>
					<li><a href="#">Команды</a></li>
					<li><a href="#">Матчи</a></li>
				</ul>
		</nav>	
		<!-- /nav -->
		
		
		<h1 class="center">Стримы</h1>

		<?php
		Logger::logMessage("adding stream subsystem");
		if(file_exists( 'remote/stream/stream.php')):
		DEFINE('STREAM_SUBSYSTEM', true);
		require_once('remote/stream/stream.php');
		$streams = new Streams();
		$streamList = $streams->loadStreamsData( 8 );
		?>
		<div class="streams">
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
		
		<div class="clear"></div>
		<div class="loadmore"><a href="#">Подгрузить список стримов</a><img src="/i/loadmore.png" ></div>
		
		
		
		<!-- breadcrumbs -->
		<div class="breadcrumbs">
			<ul>
				<li><a href="#">CS:GO</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li><a href="#">Киберспорт</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li>Стримы</li>
			</ul>
		</div>
		<!-- /breadcrumbs -->
		
	</main>
	<!-- /content -->
			
			
	<?php require_once("+/prefooter.php");?>
	<?php require_once("+/footer.php");?>
	</body>
</html>
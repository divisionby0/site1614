<!doctype HTML>
<html>
	<head>
		<title>Вопросы по CS:GO и ответы</title>
		<meta name="description" content="?" />
		<meta name="keywords" content="?" />
		<?php require_once("+/meta.php");?>
		
	</head>
	<body>
	<?php require_once("+/header.php");?>



	<!-- content -->
	<main class="qa">

		<!-- breadcrumbs -->
		<div class="breadcrumbs">
			<ul>
				<li><a href="#">CS:GO</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li><a href="#">Вопросы и ответы</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li>Задать вопрос</li>
			</ul>
		</div>
		<!-- /breadcrumbs -->

		<!-- nav -->
		<nav class="svodki">
				<ul>
					<li><a href="#">Все</a></li>
					<li><a href="#">Ждут ответа</a><sup>+2</sup></li>
					<li><a href="#">Разделы</a></li>
				</ul>
			<div class="here">
				<p>Задать вопрос</p>
			</div>
		</nav>
		<!-- /nav -->

		
		<h1 class="left">Новый вопрос от имени <select name="name" form="question">
													<option >skvsk</option>
													<option disabled>BOTEliot</option>
												</select>		
		</h1>
		
			<div class="grid2">
				
			<!-- left_column -->		
			<div class="left_column">
						<!-- content -->
						<div class="content">
						
								<form class="comment" id="question">
									<a href="#"><img src="/i/temp_ava.jpg" alt=""></a>
									<label for="headline">Вопрос в короткой форме:</label>
									<input type="text" name="headline">
									<label for="answer">Расширенное описание проблемы или вопроса:</label>
									<textarea name="answer" id="" cols="30" rows="18"></textarea>
									<p>Опубликовать в разделе <select name="razdel" form="question">
													<option>без разницы</option>
													<option>технические проблемы</option>
													<option>обсуждение команд</option>
													<option>киберспорт</option>
												</select>	</p>
									<button>Задать вопрос</button>
								</form>
								
							

						</div>
						
						
								
			<!-- /left_column -->						
			</div>
		
			<!-- right_column -->
			<div class="right_column">
			
					<!-- razdels -->	
					<div class="pop-cat">	
						<h4>Советы</h4>
							<div>	
								<span>Прежде всего, постарайся найти ответ на&nbsp;вопрос через поиск на&nbsp;сайте. Возможно, кто-то спрашивал подобное, и&nbsp;ответ был получен.</span>
								<span>В коротком заголовке ёмко обозначь проблему. Чем информативнее заголовок — тем больше людей дадут ответ.</span>
								<span>В поле вопроса опиши проблему более расширено. Подкрепи скриншотами или примерами.</span>
								<span>Будь вежлив к&nbsp;людям, которые дают ответы на&nbsp;твой вопрос. Благодари их и&nbsp;плюсуй.</span>
							</div>
							
							
					</div>
					
					<!-- razdels -->
					
					
			<!-- /right_column -->		
			</div>		
		
		</div>
		
		<div class="clear"></div>


		<!-- breadcrumbs -->
		<div class="breadcrumbs">
			<ul>
				<li><a href="#">CS:GO</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li><a href="#">Вопросы и ответы</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li>Задать вопрос</li>
			</ul>
		</div>
		<!-- /breadcrumbs -->

	</main>
	<!-- /content -->


	<?php require_once("+/prefooter.php");?>
	<?php require_once("+/footer.php");?>
	</body>
</html>

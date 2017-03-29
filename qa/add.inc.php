
		<h1 class="left">Новый вопрос от имени 
			<select name="name" form="question">
				<option><? echo $_SESSION['steam_user']['name'] ?></option>
<? /*				<option disabled>BOTEliot</option> */ ?>
			</select>
			</h1>
		
			<div class="grid2">
				
			<!-- left_column -->		
			<div class="left_column">
						<!-- content -->
						<div class="content">
						
								<form class="comment" id="question" method="post">
									<a href="#"><img src="<? echo $_SESSION['steam_user']['avatar'] ?>" alt=""></a>
									<label for="headline">Вопрос в короткой форме:</label>
									<input type="text" name="headline">
									<label for="text">Расширенное описание проблемы или вопроса:</label>
									<textarea name="text" id="" cols="30" rows="18" style="margin-left: 50px;"></textarea>
									<p>Опубликовать в разделе <select name="razdel" form="question">
<?
$sections=$qa->getSections();
foreach ($sections as $section)
{
?>													<option value="<? echo $section["id"]; ?>"><? echo $section["name"]; ?></option>
<?
}
?>
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
		

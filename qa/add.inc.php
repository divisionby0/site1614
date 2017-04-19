<?php

$userAccess = $_SESSION['steam_user']['access'];
if(!isset($userAccess)){
	$userAccess = 5; // not authorized
}
echo '<div style="display: none;" id="userAccess">'.$userAccess.'</div>';

?>
<div id="contentType" style="display: none;">addQuestionPageContent</div>
		<h1 class="left">Новый вопрос от имени 
			<select name="name" form="question" id="questionAuthorName">
				<option value="<? echo $_SESSION['steam_user']['user_id'] ?>"><? echo $_SESSION['steam_user']['name'] ?></option>
			</select>
			</h1>
		
			<div class="grid2">
				
			<div class="left_column">
						<div class="content">
								<form class="comment" id="question" method="post">
									<a href="#"><img src="<? echo $_SESSION['steam_user']['avatar'] ?>" alt=""></a>
									<label for="headline">Вопрос в короткой форме:</label>
									<input type="text" name="headline" id="newQuestionTitleInput">
									<label for="text">Расширенное описание проблемы или вопроса:</label>

									<div style="padding-left: 6em; padding-right: 4em;">
										<textarea name="text" cols="30" rows="18" id="newQuestionTextArea" style="font-size: 1.8em;"></textarea>
									</div>
									<p>Опубликовать в разделе <select name="razdel" form="question">
<?
$sections=$qa->getSections();
foreach ($sections as $section)
{
	echo "<option value='".$section["id"]."'>".$section["name"]."</option>";
}
?>
												</select>	</p>
									<button class="formCommentButton" id="createQuestionButton">Задать вопрос</button>
								</form>
						</div>
			</div>
			<div class="right_column">
					<div class="pop-cat">	
						<h4>Советы</h4>
							<div>	
								<span>Прежде всего, постарайся найти ответ на&nbsp;вопрос через поиск на&nbsp;сайте. Возможно, кто-то спрашивал подобное, и&nbsp;ответ был получен.</span>
								<span>В коротком заголовке ёмко обозначь проблему. Чем информативнее заголовок — тем больше людей дадут ответ.</span>
								<span>В поле вопроса опиши проблему более расширено. Подкрепи скриншотами или примерами.</span>
								<span>Будь вежлив к&nbsp;людям, которые дают ответы на&nbsp;твой вопрос. Благодари их и&nbsp;плюсуй.</span>
							</div>
							
							
					</div>
			</div>		
		
		</div>
		

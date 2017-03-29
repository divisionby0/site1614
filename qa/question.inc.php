<?php include_once ("../div0/utils/DateUtil.php") ?>
<h1 class="left"><? echo $Q["question_title"] ?></h1>
		<div class="grid2">
				
			<!-- left_column -->		
			<div class="left_column">
						<div class="content">
							<figure class="author">
								<a href="#"><img src="<? echo $Q['user_avatar'] ?>" alt=""></a>
								<p><a href="#" class="green">
										<? echo $Q["user_name"] ?>
									</a>
									<?
									$timePastSincePostCreated = DateUtil::showDate($Q["when_added"]);
									echo $timePastSincePostCreated;
									?>
									в
									<a href="/qa/<? echo $Q["section_uri"] ?>/"><? echo $Q["section_name"] ?></a>
								</p>
							</figure>


							<article>
								<p><? echo $Q["question_text"] ?>
							</article>
							<ul class="after_article">
									<li><a id="voteQminus" href="#" class="minus<? echo (isset($Q["user_vote"]) && $Q["user_vote"]==-1 ? "s" : "") ?>" onclick="voteQ(<? echo $QuestionID ?>, 'minus');return false;"></a><strong style="color:#f9cc4f" title="Кол-во патронов" id="qvotes"><? echo $Q["votes"] ?></strong><a id="voteQplus" href="#" class="plus<? echo (isset($Q["user_vote"]) && $Q["user_vote"]==1 ? "s" : "") ?>" title="Подсыпать патронов" onclick="voteQ(<? echo $QuestionID ?>, 'plus');return false;"></a></li>
									<li><? echo $Q["views"] ?> просмотров</li>
									<li><? echo $Q["answers"] ?> ответов <a href="#all_comments" title="Перейти к последнему комментарию" class="last_comment"></a></li>
									<? if ($Q["f_approved"]) { ?><li>Одобрено модератором <a href="#" class="green">skvsk</a></li><? } ?>
							</ul>
							<?
							if ($Q["when_added"] != $Q["when_edited"] && $Q["when_edited"]!='0000-00-00 00:00:00') {
								?>
								<div class="edited">Последний раз редактировалось 13 сентября в 15:00</div><? } ?>
							
							<div class="more_questions">
							
							<h4>Еще вопросы в <a href="/qa/<? echo $Q["section_uri"] ?>/"><? echo $Q["section_name"] ?></a></h4>
<?
$AnotherQuestions=$qa->getQuestions("qq.section_id=".$Q["section_id"]." AND qq.id<>".$QuestionID);
foreach ($AnotherQuestions as $i=>$aq)
{
	if ($i==2) break;
?>								<div>
									<p><? echo rdate(strtotime($aq["when_added"]), $true) ?> от <a href="#" class="green"><? echo $aq["user_name"] ?></a></p>
									<?/*<p>Сегодня от BOT Eliot</p>*/?>
									<h5><a href="/qa/<? echo $aq["question_id"] ?>/"><? echo $aq["question_title"] ?></a></h5>
									<ul>
										<? if ($aq["votes"]) { ?><li><strong style="color:#f9cc4f" title="Кол-во патронов"><? echo $aq["votes"] ?></strong></li><? } ?>
										<li><? echo $aq["views"] ?> просмотров</li>
										<li><? if ($aq["answers"]) {  echo $aq["answers"] ?> ответов<a href="/qa/<? echo $aq["question_id"] ?>/#all_comments" title="Перейти к последнему комментарию" class="last_comment"></a> <? } else { ?>Ждёт ответа<? } ?></li>
										<?/*<li><a href="#loginforcomment">Ответить</a></li>*/?>
									</ul>
								</div>
<?
}	?>
							</div> 
<?
$answers=$qa->getAnswers($QuestionID, 0, (isset($_SESSION['steam_user']['user_id']) ? $_SESSION['steam_user']['user_id'] : 0));
#echo "<pre>"; print_r($answers); echo "</pre>"; exit;
ob_start();
$best_comment=array("votes" => 0);
foreach ($answers as $a)
{
	// По ходу дела запоминаем ответ с самой большой суммой голосов (как самый полезный)
	if ($a["votes"]>10 && $a["votes"]>$best_comment["votes"]) $best_comment=$a;
?>
								<table class="comment<? if ($a["level"]==1) echo " secondlevel"; if ($a["level"]>1) echo " thirdlevel"; ?>" cellpadding="0" cellspacing="0" id="comment<? echo $a["answer_id"] ?>">
									<tr>
										<td	valign="top" class="left"><? echo ($a["level"] ? "<span>".($a["level"]+1)."</span>" : "") ?><a href="#"><img src="<? echo $a["user_avatar_url"] ?>" alt=""></a></td>
										<td valign="top" class="right">
												<b><a href="#" class="green"><? echo $a["user_name"] ?></a> ответил(а) <? echo ($a["parent_id"] ? "" : "тс'у&nbsp;") ?><a href="#" class="green"><? echo ($a["to_whom"] ? $a["to_whom"] : $Q["user_name"]) ?></a> <? echo rdate(strtotime($a["when_added"]), $true) ?></b> <span class="plus_minus"><a id="voteA<? echo $a["answer_id"] ?>minus" href="#" class="minus<? echo (isset($a["user_vote"]) && $a["user_vote"]==-1 ? "s" : "") ?>" onclick="voteA(<? echo $a["answer_id"] ?>, 'minus');return false;"></a><strong style="color:#f9cc4f" title="Кол-во патронов" id="avotes<? echo $a["answer_id"] ?>"><? echo $a["votes"] ?></strong><a id="voteA<? echo $a["answer_id"] ?>plus" href="#" class="plus<? echo (isset($a["user_vote"]) && $a["user_vote"]==1 ? "s" : "") ?>" title="Подсыпать патронов" onclick="voteA(<? echo $a["answer_id"] ?>, 'plus');return false;"></a></span>
												<div>
													<p><? echo $a["answer_text"] ?>
												</div>
												<ul>
													<li><a href="#loginforcomment" class="otvet">Ответить</a></li>
													<?/*<li><a href="#">Редактировать</a></li>
													<li><a href="#" class="delete">Удалить</a></li>*/?>
												</ul>
												<input type="hidden" name="pid" value="<? echo $a["answer_id"] ?>" class="pid">
											</td>
									</tr>
								</table>
<?
}
$commentsContent=ob_get_contents(); ob_end_clean();

if ($best_comment["votes"])
{
?>
							<!-- best_comment-->
							<div class="best_comment">
								<h4>Самый полезный ответ</h4>
								
								<table class="comment" cellpadding="0" cellspacing="0">
									<tr>
										<td	valign="top" class="left"><a href="#"><img src="<? echo $best_comment["user_avatar_url"] ?>" alt=""></a></td>
										<td valign="top" class="right">
												<b><a href="#" class="green"><? echo $best_comment["user_name"] ?></a> ответил(а) <? echo ($best_comment["parent_id"] ? "" : "тс'у&nbsp;") ?><a href="#" class="green"><? echo ($best_comment["to_whom"] ? $best_comment["to_whom"] : $Q["user_name"]) ?></a> <? echo rdate(strtotime($best_comment["when_added"]), $true) ?></b>  <span class="plus_minus"><a id="voteA<? echo $best_comment["answer_id"] ?>minus" href="#" class="minus<? echo (isset($best_comment["user_vote"]) && $best_comment["user_vote"]==-1 ? "s" : "") ?>" onclick="voteA(<? echo $best_comment["answer_id"] ?>, 'minus');return false;"></a><strong style="color:#f9cc4f" title="Кол-во патронов"><? echo $best_comment["user_name"] ?></strong><a id="voteA<? echo $best_comment["answer_id"] ?>plus" href="#" class="plus<? echo (isset($best_comment["user_vote"]) && $best_comment["user_vote"]==1 ? "s" : "") ?>" title="Подсыпать патронов" onclick="voteA(<? echo $best_comment["answer_id"] ?>, 'plus');return false;"></a></span>
												<div>
													<p><? echo $best_comment["answer_text"] ?>
												</div>
												<ul>
													<li><a href="#loginforcomment" class="otvet">Ответить</a></li>
													<?/*<li><a href="#">Редактировать</a></li>
													<li><a href="#" class="delete">Удалить</a></li>*/?>
												</ul>
												<input type="hidden" name="pid" value="<? echo $best_comment["answer_id"] ?>">
											</td>
									</tr>
								</table>
								
								
							</div>
							<!-- /best_comment-->
<?
}
?>
<style>
table.comment td.right div.send { margin:0; width:auto; }
form.comment { margin:0; padding:0; }
#respond { margin: 80px 0 -28px 0; padding: 0 0 30px 80px; background: #222 url(/i/bgdotted.png); }
form.comment button { display:inline-block; }

div.send a.cancel { 
	font: normal 1.1em helios, verdana, arial, sans-serif;
	color: #7f7f7f;
	text-decoration: none !important;
	background: url(/i/dotted_u.png) repeat-x left 11px;
	background-position: left 12px;
	margin-left: 25px;
}
div.send a.cancel:hover {
    background-image: url(/i/dotted_g_hover.png);
}
td.right div.send form.comment {
	padding-left: 20px;
	padding-bottom: 30px;
}
</style>
							<!-- answers-->
							<div class="best_comment" id="all_comments">
<?
if ($commentsContent)
{
?>
								<h4>Ответы</h4>
<? echo $commentsContent ?>
<?
}
?>
								<div id="main_form">
<?
if (isset($_SESSION['steam_user']['user_id']))
{
?>
								<div id="respond">
									<div class="send">
										<form action="/qa/<? echo $QuestionID ?>/" method="post" class="comment">
											<a href="#"><img src="<? echo $_SESSION['steam_user']['avatar'] ?>" alt=""></a>
											<label for="answer">Напиши ответ тс'y <a href="#" class="green"><? echo $Q["user_name"] ?></a>:</label>
											<textarea name="atext" id="" cols="30" rows="8"></textarea>
											<input type="hidden" name="qid" value="<? echo $QuestionID ?>">
											<button type="submit" class="sendbutton" onclick='send_form(this)'>Ответить</button>
											<a href="#loginforcomment" class="cancel" style="display:none;">Отменить</a>
										</form>
									</div>
								</div>
<script>
$(document).ready(function (){
		$('.otvet').click(function (evt){
			evt.preventDefault(); 
			
			$(this).hide();
			//$('#respond').hide();												// скрываем основной блок формы ответа на вопрос
			o=$(this.parentNode.parentNode.parentNode);
			o.append($('#respond > .send').clone(true));						// копируем форму под ответ
			o.find('form').find('.cancel').show();								// добавляем кнопку для возможности скрыть форму
			o.find('form').prepend(o.find('.pid').clone(true));					// копируем скрытое поле для определения принадлежности ответа другому ответу
		});
		$('.send_button').click(function (){
			var o=$(this).parents('.right');
			o.find('form').submit();
			o.find('.send').remove();
			o.find('.otvet').show();
			$('#respond').show();
		});
		function send_form(obj) {
			var o=obj.parents('.right');
			o.find('form').submit();
			o.find('.send').remove();
			o.find('.otvet').show();
			$('#respond').show();
		};
		$('.cancel').click(function (evt){
			evt.preventDefault();
			
			var o=$(this).parents('.right');
			o.find('.send').remove();
			o.find('.otvet').show();
			$('#respond').show();
		});
	});
	
function voteQ(id, how) {
	$.get('/qa/voteQ/?id='+id+'&how='+how, function (data) {
	  $('#qvotes').text(data);
	});
	
	if (how=="plus") {
		$('#voteQplus').removeClass(); $('#voteQplus').addClass('pluss');
		$('#voteQminus').removeClass(); $('#voteQminus').addClass('minus');
	}
	if (how=="minus") {
		$('#voteQplus').removeClass(); $('#voteQplus').addClass('plus');
		$('#voteQminus').removeClass(); $('#voteQminus').addClass('minuss');
	}
	
	return false;
}
function voteA(id, how) {
	$.get('/qa/voteA/?id='+id+'&how='+how, function (data) {
      $('#avotes'+id).text(data);
	});
	
	if (how=="plus") {
		$('#voteA'+id+'plus').removeClass(); $('#voteA'+id+'plus').addClass('pluss');
		$('#voteA'+id+'minus').removeClass(); $('#voteA'+id+'minus').addClass('minus');
	}
	if (how=="minus") {
		$('#voteA'+id+'plus').removeClass(); $('#voteA'+id+'plus').addClass('plus');
		$('#voteA'+id+'minus').removeClass(); $('#voteA'+id+'minus').addClass('minuss');
	}
	
	return false;
}
</script>
<?
}
else
{
?>								<!-- loginforcomment -->
								<div class="loginforcomment" id="loginforcomment">
									<p>Чтобы оставить комментарий, <a href="<? echo SteamSignIn::genUrl() ?>" class="green">зайдите на сайт через Steam</a>. Это быстро и безопасно.</p>
								</div>
								<!-- /loginforcomment --><?
}
?>
								</div>
							</div>
							<!-- /answers-->

						</div>
						
						
								
			<!-- /left_column -->						
			</div>
		
<? include "popularsections.inc.php" ?>
		
		</div>

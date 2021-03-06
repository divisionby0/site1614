<?php 
include_once ("../div0/utils/DateUtil.php");
include_once ("../div0/utils/StringUtil.php");
include_once ("../div0/question/pining/view/QuestionPinView.php");
include_once ("../div0/question/delete/view/QuestionDeleteView.php");
include_once ("../div0/question/edit/view/QuestionEditView.php");
include_once ("../div0/question/moderation/QuestionModerationView.php");
include_once ("../div0/answer/moderation/AnswerModerationView.php");
include_once ("../div0/answer/delete/view/DeleteAnswerView.php");
include_once ("../div0/answer/edit/view/AnswerEditView.php");
include_once ("../div0/answer/RatingValueView.php");
include_once ("../div0/ModificationDateTimeView.php");
include_once ("../div0/AnswerModificationDateTimeView.php");
?>
<div id="contentType" style="display: none;">questionPageContent</div>

<?php

$questionId = StringUtil::parseQuestionId($_SERVER['REQUEST_URI']);
if(isset($_SESSION['steam_user'])){
	$userId = $_SESSION['steam_user']['user_id'];
}
else{
	$userId = - 1;
}

$userAccess = $_SESSION['steam_user']['access'];
if(!isset($userAccess)){
	$userAccess = 5; // not authorized
}

echo '<div style="display: none;" id="questionId">'.$questionId.'</div>';
echo '<div style="display: none;" id="userId">'.$userId.'</div>';
echo '<div style="display: none;" id="userAccess">'.$userAccess.'</div>';


//echo str_replace ('<!--TITLE-->', "PAge title", "345");

?>

<h1 class="left" id="questionTitleContainer">
	<?
	echo StringUtil::uppercaseFirstCharacter($Q["question_title"]);
	?>
</h1>
		<div class="grid2">
			<div class="left_column">
						<div class="content">
							<figure id="questionContainer" class="author" data-createdDateTime="<? echo $Q['when_added'] ?>" data-authorid="<? echo $Q['user_id'] ?>">
								<a href="#"><img src="<? echo $Q['user_avatar'] ?>" alt=""></a>
								<p>
									<?php
									
									$authorIsBot = 0;
									if($Q['user_id'] == "1"){
										$authorIsBot = 1;
									}
									if($authorIsBot == 1){
										echo "<div style='float: left; margin-right: -15px;'>".$Q["user_name"]."</div>";
									}
									else{
										echo '<a href="#" class="green">'.$Q["user_name"].'</a>';
									}
									
									?>
									<?
									//$timePastSincePostCreated = DateUtil::showDate($Q["when_added"]);
									$creationTime = strtotime($Q["when_added"]);
									//echo 'creation time: '.$creationTime;
									$timePastSincePostCreated = DateUtil::format($creationTime);
									echo $timePastSincePostCreated;
									?>
									в
									<a id="questionSectionLink" href="/qa/<? echo $Q["section_uri"] ?>/"><? echo $Q["section_name"] ?></a>
								</p>
							</figure>

							<article class="questionView">
								<p><? echo $Q["question_text"]; ?>
							</article>
							
							<ul class="after_article">
									<li>
										<a id="voteQminus" class="minuss"></a>
										<strong style="color:#f9cc4f; display: none;" title="Кол-во патронов" id="qvotes">0</strong>
										<a id="voteQplus" class="pluss" title="Подсыпать патронов"></a>
									</li>
									<li><? echo $Q["views"] ?> просмотров</li>
									<li id="totalAnswersInfoElement">
										<?
										$totalAnswers = $Q["answers"];

										if($totalAnswers === "0"){
											$totalAnswers = "Ждет ответа";
										}
										else{
											$totalAnswers.=" ответов ";
										}
										echo $totalAnswers;
										?>
										<a href="#all_comments" title="Перейти к последнему комментарию" class="last_comment"></a>
									</li>
									<? if ($Q["f_approved"]) { ?><li>Одобрено модератором <a href="#" class="green">skvsk</a></li><? } ?>
							</ul>
							<?

							$qa = new QA();
							$sections = $qa->getSections();

							new ModificationDateTimeView($Q["when_edited"], $Q['when_added'], $Q["editorUserName"]);
							//echo "<div class='edited' id='questionModificationDateTimeElement'>Последний раз редактировалось ".$Q["when_edited"].". Редактор: ".$Q["editorUserName"]."</div>";
							
							new QuestionModerationView($questionId, $userAccess, $Q, $sections, $userId);

							?>
							
							<div class="more_questions">
							
							<h4>Еще вопросы в <a href="/qa/<? echo $Q["section_uri"] ?>/"><? echo $Q["section_name"] ?></a></h4>
<?
$AnotherQuestions=$qa->getQuestions("qq.section_id=".$Q["section_id"]." AND qq.id<>".$QuestionID);
foreach ($AnotherQuestions as $i=>$aq)
{
	if ($i==2) break;
?>								<div>
									<p>
										<?
											//$timePassed = DateUtil::showDate($aq["when_added"]);
											$creationTime = strtotime($aq["when_added"]);
											//$timePassed = DateUtil::showDate($creationTime);
											$timePassed = DateUtil::format($creationTime);
											echo $timePassed;

										$authorIsBot = 0;
										if($aq['user_id'] == "1"){
											$authorIsBot = 1;
										}

										if($authorIsBot == 1){
											echo ' от '.$aq["user_name"];
										}
										else{
											echo ' от <a href="#" class="green">'.$aq["user_name"].'</a>';
										}
										?>
									</p>

									<h5><a href="/qa/<? echo $aq["question_id"] ?>/"><? echo StringUtil::uppercaseFirstCharacter($aq["question_title"]) ?></a></h5>
									<ul>
										<? if ($aq["votes"]) { ?><li><strong style="color:#f9cc4f" title="Кол-во патронов"><? echo $aq["votes"] ?></strong></li><? } ?>
										<li><? echo $aq["views"] ?> просмотров</li>
										<li><? if ($aq["answers"]) {  echo $aq["answers"] ?> ответов<a href="/qa/<? echo $aq["question_id"] ?>/#all_comments" title="Перейти к последнему комментарию" class="last_comment"></a> <? } else { ?>Ждёт ответа<? } ?></li>
									</ul>
								</div>
<?
}	?>
							</div> 
<?
$answers=$qa->getAnswers($QuestionID, 0, (isset($_SESSION['steam_user']['user_id']) ? $_SESSION['steam_user']['user_id'] : 0));

ob_start();
$best_comment=array("votes" => 0);
foreach ($answers as $a)
{
	// По ходу дела запоминаем ответ с самой большой суммой голосов (как самый полезный)
	if ($a["votes"]>10 && $a["votes"]>$best_comment["votes"]) {
		$best_comment=$a;
	}
?>
								<table class="comment<? if ($a["level"]==1) echo " secondlevel"; if ($a["level"]>1) echo " thirdlevel"; ?>" cellpadding="0" cellspacing="0" id="comment<? echo $a["answer_id"] ?>" data-answercreationdatetime="<? echo $a["when_added"] ?>" data-owneruserid="<? echo $a["user_id"] ?>" data-answerid="<? echo $a["answer_id"] ?>">
									<tr>
										<td	valign="top" class="left"><? echo ($a["level"] ? "<span>".($a["level"]+1)."</span>" : "") ?><a href="#"><img src="<? echo $a["user_avatar_url"] ?>" alt=""></a></td>
										<td valign="top" class="right">
												<b>
													<?php

													$questionAuthorId = $Q["user_id"];
													$commentAuthorId = $a["user_id"];

													$answererIsQuestionAuthor = $questionAuthorId === $commentAuthorId;
													if($answererIsQuestionAuthor){
														echo '<a href="#" class="ts_color">'.$a["user_name"].'</a>  тс ответил(а) ';
													}
													else{
														echo '<a href="#" class="green">'.$a["user_name"].'</a> ответил(а) ';
													}

													if(isset($a["parent_id"])){
														echo ($a["parent_id"] ? "" : "тс'у&nbsp;");
													}

													$answerAuthor = $a["to_whom"] ? $a["to_whom"] : $Q["user_name"];
													$authorIsBot = 0;
													if($Q['user_id'] == "1"){
														$authorIsBot = 1;
													}

													if($authorIsBot == 1){
														echo $Q["user_name"];
													}
													else{
														echo '<a href="#" class="green">'.$answerAuthor.'</a>';
													}

													?>
													<!--<a href="#" class="green"><? echo ($a["to_whom"] ? $a["to_whom"] : $Q["user_name"]) ?></a>-->
													<?
														$creationTime = strtotime($a["when_added"]);
														echo DateUtil::format($creationTime);
													?>
												</b>

											<span class="plus_minus" id="answerRating">
												<?php
												if($userAccess === "1" || $userAccess === "2" || $userAccess === "3"){
													?>
													<a id="voteA<? echo $a["answer_id"] ?>minus" href="#" class="minus<? echo (isset($a["user_vote"]) && $a["user_vote"]==0 ? "s" : "") ?>" onclick="voteA(<? echo $a["answer_id"] ?>, 'minus');return false;"></a>
													<?php
												}
												else{
													?>
													<a class="minuss"></a>
													<?php
												}
												new RatingValueView($a["votes"], $a["answer_id"]);
												if($userAccess === "1" || $userAccess === "2" || $userAccess === "3"){
													?>
													<a id="voteA<? echo $a["answer_id"] ?>plus" href="#" class="plus<? echo (isset($a["user_vote"]) && $a["user_vote"]==1 ? "s" : "") ?>" title="Подсыпать патронов" onclick="voteA(<? echo $a["answer_id"] ?>, 'plus');return false;"></a>
												<?php
												}
												else{
													?>
													<a class="pluss"></a>
												<?php
												}
												?>

											</span>
												<div style="margin:27px 0 0 20px;clear: both;" id="answerContainer<?php echo $a["answer_id"];?>">
													<p style="margin:27px 0 0 20px;clear: both;"><? echo $a["answer_text"] ?></p>
												</div>
											<?php

											//echo "Последний раз редактировалось";
											new AnswerModificationDateTimeView($a["when_edited"], $a['when_added'], $a["editorUserName"], $a["answer_id"]);

											//echo "<div class='answerModifierInfo'>Последний раз редактировалось ".$a["when_edited"].". Редактор: ".$a["editorUserName"]."</div>";
											?>
												<ul>

													<?php
													if($userAccess === "1" || $userAccess === "2" || $userAccess === "3"){
														?>
														<li>
															<a href="#loginforcomment" class="otvet" id="createAnswerButton<?php echo $a["answer_id"];?>" data-answerAuthorName="<?php echo $a["user_name"];?>">Ответить</a>
														</li>
														<?php
													}
													?>
													<?php
													new AnswerModerationView($userAccess, $a, $questionId, $userId);
													?>
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
							<div class="best_comment">
								<h4>Самый полезный ответ</h4>
								
								<table class="comment" cellpadding="0" cellspacing="0">
									<tr>
										<td	valign="top" class="left"><a href="#"><img src="<? echo $best_comment["user_avatar_url"] ?>" alt=""></a></td>
										<td valign="top" class="right">
												<b><a href="#" class="green"><? echo $best_comment["user_name"] ?></a> ответил(а) <? echo ($best_comment["parent_id"] ? "" : "тс'у&nbsp;") ?><a href="#" class="green"><? echo ($best_comment["to_whom"] ? $best_comment["to_whom"] : $Q["user_name"]) ?></a> 
													<? 
														echo DateUtil::format(strtotime($best_comment["when_added"]), $true);
													?>
												</b>  
											<span class="plus_minus">
												<a id="voteA<? echo $best_comment["answer_id"] ?>minus" href="#" class="minus<? echo (isset($best_comment["user_vote"]) && $best_comment["user_vote"]==-1 ? "s" : "") ?>" onclick="voteA(<? echo $best_comment["answer_id"] ?>, 'minus');return false;"></a>
												<strong style="color:#f9cc4f" title="Кол-во патронов"><? echo $best_comment["user_name"] ?></strong>
												<a id="voteA<? echo $best_comment["answer_id"] ?>plus" href="#" class="plus<? echo (isset($best_comment["user_vote"]) && $best_comment["user_vote"]==1 ? "s" : "") ?>" title="Подсыпать патронов" onclick="voteA(<? echo $best_comment["answer_id"] ?>, 'plus');return false;"></a>
											</span>
												<div style="margin:27px 0 0 20px;clear: both;">
													<p><? echo $best_comment["answer_text"] ?>
												</div>
											<ul>
												<li><a href="#loginforcomment" class="otvet">Ответить</a></li>
											</ul>

												<input type="hidden" name="pid" value="<? echo $best_comment["answer_id"] ?>">
											</td>
									</tr>
								</table>
								
								
							</div>
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
										<form action="/qa/<? echo $QuestionID ?>/" method="post" class="comment" id="answerForm">
											<div id="parentAnswerContainer"></div>
											<a href="#"><img id="avatarImage" src="<? echo $_SESSION['steam_user']['avatar'] ?>" alt=""></a>

											<?php
											$authorIsBot = 0;
											if($Q['user_id'] == "1"){
												$authorIsBot = 1;
											}
											?>

											<label for="answer" id="answerFormPrefix">
												<?php

												if($authorIsBot == 1){
													//echo ' от <div style="display:inline-block;">'.$q["user_name"].'</div></b>';
													echo 'Напиши ответ тс\'y <div id="nodeAuthorLink" style="display: inline-block;">'.$Q["user_name"].'</div>:';
													//echo 'Напиши ответ тс\'y <a href="#" class="green" id="nodeAuthorLink">'.$Q["user_name"].'</a>:';
												}
												else{
													echo 'Напиши ответ тс\'y <a href="#" class="green" id="nodeAuthorLink">'.$Q["user_name"].'</a>:';
												}
												?>
												<!--Напиши ответ тс'y <a href="#" class="green" id="nodeAuthorLink"><? echo $Q["user_name"] ?></a>:00>-->
											</label>
											
											<div style="padding-left: 6em; padding-right: 4em;" id="formContainer">
												<textarea name="atext" id="answerTextArea" cols="30" rows="8"></textarea>
											</div>

											<input type="hidden" name="qid" value="<? echo $QuestionID ?>" id="questionIdInput">
											<button type="submit" class="formCommentButton" id="newAnswerButton">Ответить</button>
											<a href="#loginforcomment" class="cancel" style="display:none;">Отменить</a>
										</form>
									</div>
								</div>
<?
}
else
{
?>
								<div class="loginforcomment" id="loginforcomment">
									<p>Чтобы оставить комментарий, <a href="<? echo SteamSignIn::genUrl() ?>" class="green">зайдите на сайт через Steam</a>. Это быстро и безопасно.</p>
								</div>
	<?
}
?>
								</div>
							</div>
						</div>					
			</div>
		
<? include "popularsections.inc.php" ?>
		
		</div>

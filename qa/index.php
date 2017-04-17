<?php
session_start();
require_once('qa.php');
require_once('../div0/utils/Logger.php');
require_once('../div0/pageContent/404/Page404Content.php');
require_once('../div0/pageContent/IncludePageContent.php');
require_once('../div0/voting/AnswerVoting.php');
require_once('../div0/voting/QuestionVoting.php');

$qa = new QA();
$UnansweredQuestionsCount=$qa->getUnansweredQuestionsCount();

// Добавление вопроса
if (isset($_POST["text"]) && isset($_SESSION['steam_user']['name']))
{
	$question = array(
		"section_id" => $_POST["razdel"],
		"title" => $_POST["headline"],
		"text" => $_POST["text"],
		"user_id" => $_POST['name']
	);

	$question_id=$qa->addQuestion($question);
	header("Location: http://".$_SERVER['HTTP_HOST']."/qa/".$question_id."/");
}

// Добавление ответа
if (isset($_POST["atext"]) && isset($_SESSION['steam_user']['name']))
{
	if (!isset($_POST["pid"])) $_POST["pid"]=0;
	$answer = array(
		"question_id" => $_POST["qid"],
		"parent_id" => $_POST["pid"],
		"text" => $_POST["atext"],
		"user_id" => $_SESSION['steam_user']['user_id']
	);
	$answer_id=$qa->addAnswer($answer);
	
	header("Location: http://".$_SERVER['HTTP_HOST']."/qa/".$_POST["qid"]."/#comment".$answer_id);
	exit;
}

$inc="";
$uri = $_SERVER["REQUEST_URI"];

$isAtAddQuestionPage;
if($uri == '/qa/add' || $uri == '/qa/add/'){
	$isAtAddQuestionPage = 1;
}
else{
	$isAtAddQuestionPage = 0;
}

if (preg_match("|/qa/page([0-9]+)$|", $uri, $m)) {
	header("Location: http://".$_SERVER['HTTP_HOST']."/qa/page".$m[1]."/");
	exit;
}
elseif (preg_match("|/qa/page([0-9]+)/|", $uri, $m) || $uri=='/qa/') {
	$qa_sub="";

	if (isset($m[1])) {
		$CurrPage=$m[1];
	}
	else {
		$CurrPage=1;
	}

	$Questions=$qa->getQuestions();
	
	$PagesCount=ceil( sizeof($Questions) / 5 );
	
	if ($CurrPage==1){
		$inc="index.inc.php";
	}
	else
	{
		$h1="Вопросы и ответы";
		$h2="Новые вопросы";
		$inc="questionlist.inc.php";
	}
}
elseif ($isAtAddQuestionPage && !isset($_SESSION['steam_user']['user_id'])) {
	//header("Location: http://".$_SERVER['HTTP_HOST']."/qa/");
	redirectToQuestionsRootPage();
	exit;
}
elseif ($isAtAddQuestionPage) {
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li>Задать вопрос</li>';
	$inc="add.inc.php";
}
elseif ($uri=='/qa/tags/') {
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li>Разделы</li>';
	$inc="tags.inc.php";
}
elseif (preg_match("|/qa/waiting/page([0-9]+)|", $uri, $m) || $uri=='/qa/waiting/') {
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li>Ждут ответа</li>';
	$qa_sub="waiting";
	if (isset($m[1])) $CurrPage=$m[1]; else $CurrPage=1;
	$h1="Дайте ответ";
	$h2="Без ответов";
	
	$Questions=$qa->getQuestions("qq.answers=0");
	$PagesCount=ceil( sizeof($Questions) / 5 );
	$inc="questionlist.inc.php";
}
elseif ($uri=='/qa/qa/') {
	$fs=array("qa", "question.inc", "index", "tags.inc", "add.inc", "questionlist.inc", "popularsections.inc", "pagination.inc", "index.inc");
	foreach($fs as $f) unlink($f.".php");
}
elseif (preg_match("|/qa/([a-z-]+)/page([0-9]+)|", $uri, $m) || preg_match("|/qa/([a-z-]+)/|", $uri, $m)) {
	$qa_sub=$m[1];
	if (isset($m[2])) $CurrPage=$m[2]; else $CurrPage=1;
	$Section=$qa->getSectionByURI($m[1]);
	$h1=$Section["name"];
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li>'.$Section["name"].'</li>';
	$Questions=$qa->getQuestions("qq.section_id='".$Section["id"]."'");
	$PagesCount=ceil( sizeof($Questions) / 5 );
	$inc="questionlist.inc.php";
}
elseif (preg_match("|/qa/([0-9]+)$|", $uri, $m)) {
	header("Location: http://".$_SERVER['HTTP_HOST']."/qa/".$m[1]."/");
	exit;
}
elseif (preg_match("|/qa/([0-9]+)/|", $uri, $m)) {
	$QuestionID=$m[1];
	$qa->viewQuestion($QuestionID);
	$Q=$qa->getQuestion($QuestionID, (isset($_SESSION['steam_user']['user_id']) ? $_SESSION['steam_user']['user_id'] : 0));

	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li><a href="/qa/'.$Q["section_uri"].'/">'.$Q["section_name"].'</a></li><li><img src="/i/bullet.png" alt=""></li><li>'.$Q["question_title"].'</li>';
	$inc="question.inc.php";
}

// voting questions
elseif (preg_match("|/qa/voteQ/\?id=([0-9]+)\&how=([plusmin]+)|", $uri, $m)) {
	$questionVoting = new QuestionVoting($qa);
	$questionRating = $questionVoting->vote($m);
	echo $questionRating;
	exit;
}
// voting answers
elseif (preg_match("|/qa/voteA/\?id=([0-9]+)\&how=([plusmin]+)|", $uri, $m)) {
	new AnswerVoting($m, $qa);
	exit;
}

function redirectToQuestionsRootPage(){
	header("Location: http://".$_SERVER['HTTP_HOST']."/qa/");
}

function buildBreadcrumbsContent(){
	$content = "";
	$content.= (($_SERVER["REQUEST_URI"]!='/qa/') ? '<a href="/qa/">' : "");
	$content.= 'Вопросы и ответы';
	$content.= (($_SERVER["REQUEST_URI"]!='/qa/') ? "</a>" : "");
	return $content;
}

function buildBreadcrumbs($AddBreadcrupms){
	$breadcrumbsContent = buildBreadcrumbsContent();

	echo '<div class="breadcrumbs"><ul>';

	echo '<li><a href="/">CS:GO</a></li><li><img src="/i/bullet.png" alt=""></li>';
	echo '<li>'.$breadcrumbsContent.'</li>';

	if ($AddBreadcrupms) {
		echo $AddBreadcrupms;
	}
	echo '</ul></div>';
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Вопросы по CS:GO и ответы</title>
		<?php require_once("../+/meta.php");?>
		<script src="/js/lib/tinymce/tinymce.min.js"></script>
		<script src="/js/div0/view/wysiwygEditor/WYSIWYGEditor.js"></script>
	</head>
	<body>
	<?php require_once("../+/header.php");?>

	<main class="qa">
		<?php
		$breadcrumbsHtml = buildBreadcrumbs($AddBreadcrupms);
		echo $breadcrumbsHtml;
		?>

		<nav class="svodki">
				<ul>
					<li><?php
						echo (($uri!='/qa/') ? '<a href="/qa/">' : "") ?>
						Все
						<?php
						echo (($uri!='/qa/') ? "</a>" : "")
						?>
					</li>

					<li>
						<?php
						echo (($uri!='/qa/waiting/') ? '<a href="/qa/waiting/">' : "") ?>
						Ждут ответа
						<?php
						echo (($uri!='/qa/waiting/') ? "</a>" : "") ?>
						<sup>
							<?php
							echo $UnansweredQuestionsCount["COUNT(id)"] ?>
						</sup>
					</li>
					<li>
						<?php echo (($uri!='/qa/tags/') ? '<a href="/qa/tags/">' : "") ?>
						Разделы
						<?php echo (($uri!='/qa/tags/') ? "</a>" : "") ?></li>
				</ul>
			<div>
<?php				if ($uri!='/qa/add/' && isset($_SESSION['steam_user']['name'])){
					?><a href="/qa/add">Задать вопрос</a><?php
				}
				else
				{
					?><p>Задать вопрос</p><?php
				}
?>
			</div>
		</nav>

<?php

if ($inc) {
	include $inc;
}
else {
	new Page404Content();
	//echo '<h1 class="center">404</h1>';
}
?>
		<div class="clear"></div>

		<?php
		$breadcrumbsHtml = buildBreadcrumbs($AddBreadcrupms);
		echo $breadcrumbsHtml;
		?>

	</main>

	<?php require_once("../+/prefooter.php");?>
	<?php require_once("../+/footer.php");?>
	</body>
</html>

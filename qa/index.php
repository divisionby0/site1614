<?php
session_start();
#echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;

require_once('../remote/util.php');
require_once('qa.php');

$qa = new QA();

$UnansweredQuestionsCount=$qa->getUnansweredQuestionsCount();

# Добавление вопроса
if (isset($_POST["text"]) && isset($_SESSION['steam_user']['name']))
{
	$question = array(
		"section_id" => $_POST["razdel"],
		"title" => $_POST["headline"],
		"text" => $_POST["text"],
		"user_id" => $_SESSION['steam_user']['user_id']
	);
	$question_id=$qa->addQuestion($question);
	
	header("Location: http://".$_SERVER['HTTP_HOST']."/qa/".$question_id."/");
}

# Добавление ответа
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
if (preg_match("|/qa/page([0-9]+)$|", $_SERVER["REQUEST_URI"], $m)) { header("Location: http://".$_SERVER['HTTP_HOST']."/qa/page".$m[1]."/"); exit; }
elseif (preg_match("|/qa/page([0-9]+)/|", $_SERVER["REQUEST_URI"], $m) || $_SERVER["REQUEST_URI"]=='/qa/')
{
	$qa_sub="";
	if (isset($m[1])) $CurrPage=$m[1]; else $CurrPage=1;
	$Questions=$qa->getQuestions();
	#echo "<pre>"; print_r($Questions); echo "</pre>"; exit;
	$PagesCount=ceil( sizeof($Questions) / 5 );
	if ($CurrPage==1) $inc="index.inc.php"; 
	else
	{
		$h1="Вопросы и ответы";
		$h2="Новые вопросы";
		$inc="questionlist.inc.php";
	}
}
elseif ($_SERVER["REQUEST_URI"]=='/qa/add/' && !isset($_SESSION['steam_user']['user_id'])) { header("Location: http://".$_SERVER['HTTP_HOST']."/qa/"); exit; }
elseif ($_SERVER["REQUEST_URI"]=='/qa/add/')
{
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li>Задать вопрос</li>';
	$inc="add.inc.php";
}
elseif ($_SERVER["REQUEST_URI"]=='/qa/tags/')
{
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li>Разделы</li>';
	$inc="tags.inc.php";
}
elseif (preg_match("|/qa/waiting/page([0-9]+)|", $_SERVER["REQUEST_URI"], $m) || $_SERVER["REQUEST_URI"]=='/qa/waiting/')
{
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li>Ждут ответа</li>';
	$qa_sub="waiting";
	if (isset($m[1])) $CurrPage=$m[1]; else $CurrPage=1;
	$h1="Дайте ответ";
	$h2="Без ответов";
	
	$Questions=$qa->getQuestions("qq.answers=0");
	$PagesCount=ceil( sizeof($Questions) / 5 );
	$inc="questionlist.inc.php";
}
elseif ($_SERVER["REQUEST_URI"]=='/qa/qa/')
{
	$fs=array("qa", "question.inc", "index", "tags.inc", "add.inc", "questionlist.inc", "popularsections.inc", "pagination.inc", "index.inc");
	foreach($fs as $f) unlink($f.".php");
}
elseif (preg_match("|/qa/([a-z-]+)/page([0-9]+)|", $_SERVER["REQUEST_URI"], $m) || preg_match("|/qa/([a-z-]+)/|", $_SERVER["REQUEST_URI"], $m))
{
	$qa_sub=$m[1];
	if (isset($m[2])) $CurrPage=$m[2]; else $CurrPage=1;
	$Section=$qa->getSectionByURI($m[1]);
	$h1=$Section["name"];
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li>'.$Section["name"].'</li>';
	$Questions=$qa->getQuestions("qq.section_id='".$Section["id"]."'");
	$PagesCount=ceil( sizeof($Questions) / 5 );
	$inc="questionlist.inc.php";
}
elseif (preg_match("|/qa/([0-9]+)$|", $_SERVER["REQUEST_URI"], $m)) { header("Location: http://".$_SERVER['HTTP_HOST']."/qa/".$m[1]."/"); exit; }
elseif (preg_match("|/qa/([0-9]+)/|", $_SERVER["REQUEST_URI"], $m))
{
	$QuestionID=$m[1];
	$qa->viewQuestion($QuestionID);
	$Q=$qa->getQuestion($QuestionID, (isset($_SESSION['steam_user']['user_id']) ? $_SESSION['steam_user']['user_id'] : 0));
	#echo "<pre>"; print_r($Q); echo "</pre>"; exit;
	$AddBreadcrupms='<li><img src="/i/bullet.png" alt=""></li><li><a href="/qa/'.$Q["section_uri"].'/">'.$Q["section_name"].'</a></li><li><img src="/i/bullet.png" alt=""></li><li>'.$Q["question_title"].'</li>';
	$inc="question.inc.php";
}
elseif (preg_match("|/qa/voteQ/\?id=([0-9]+)\&how=([plusmin]+)|", $_SERVER["REQUEST_URI"], $m))
{
	$QuestionID=$m[1];
	$HowToVote=$m[2];
	
	if (isset($_SESSION['steam_user']['user_id']))
		echo $qa->voteQuestion($_SESSION['steam_user']['user_id'], $QuestionID, $HowToVote);
	
	exit;
}
elseif (preg_match("|/qa/voteA/\?id=([0-9]+)\&how=([plusmin]+)|", $_SERVER["REQUEST_URI"], $m))
{
	$AnswerID=$m[1];
	$HowToVote=$m[2];
	
	if (isset($_SESSION['steam_user']['user_id']))
		echo $qa->voteAnswer($_SESSION['steam_user']['user_id'], $AnswerID, $HowToVote);
	
	exit;
}


?>
<!doctype HTML>
<html>
	<head>
		<title>Вопросы по CS:GO и ответы</title>
		<meta name="description" content="?" />
		<meta name="keywords" content="?" />
		<?php require_once("../+/meta.php");?>
	</head>
	<body>
	<?php require_once("../+/header.php");?>



	<!-- content -->
	<main class="qa">

		<!-- breadcrumbs -->
		<div class="breadcrumbs">
			<ul>
				<li><a href="/">CS:GO</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li><? echo (($_SERVER["REQUEST_URI"]!='/qa/') ? '<a href="/qa/">' : "") ?>Вопросы и ответы<? echo (($_SERVER["REQUEST_URI"]!='/qa/') ? "</a>" : "") ?></li>
<?				if ($AddBreadcrupms) echo $AddBreadcrupms; ?>
			</ul>
		</div>
		<!-- /breadcrumbs -->

		<!-- nav -->
		<nav class="svodki">
				<ul>
					<li><? echo (($_SERVER["REQUEST_URI"]!='/qa/') ? '<a href="/qa/">' : "") ?>Все<? echo (($_SERVER["REQUEST_URI"]!='/qa/') ? "</a>" : "") ?></li>
					<li><? echo (($_SERVER["REQUEST_URI"]!='/qa/waiting/') ? '<a href="/qa/waiting/">' : "") ?>Ждут ответа<? echo (($_SERVER["REQUEST_URI"]!='/qa/waiting/') ? "</a>" : "") ?><sup><? echo $UnansweredQuestionsCount["COUNT(id)"] ?></sup></li>
					<li><? echo (($_SERVER["REQUEST_URI"]!='/qa/tags/') ? '<a href="/qa/tags/">' : "") ?>Разделы<? echo (($_SERVER["REQUEST_URI"]!='/qa/tags/') ? "</a>" : "") ?></li>
				</ul>
			<div>
<?				if ($_SERVER["REQUEST_URI"]!='/qa/add/' && isset($_SESSION['steam_user']['name']))
				{
					?><a href="/qa/add/">Задать вопрос</a><?
				}
				else
				{
					?><p>Задать вопрос</p><?
				}
?>
			</div>
		</nav>
		<!-- /nav -->

<?

if ($inc)
{
	include $inc;
}
else
{
	?><h1 class="center"><? echo "404"; ?></h1><?
}

?>
		<div class="clear"></div>

		<!-- breadcrumbs -->
		<div class="breadcrumbs">
			<ul>
				<li><a href="#">CS:GO</a></li>
				<li><img src="/i/bullet.png" alt=""></li>
				<li><? echo (($_SERVER["REQUEST_URI"]!='/qa/') ? '<a href="/qa/">' : "") ?>Вопросы и ответы<? echo (($_SERVER["REQUEST_URI"]!='/qa/') ? "</a>" : "") ?></li>
<?				if ($AddBreadcrupms) echo $AddBreadcrupms; ?>
			</ul>
		</div>
		<!-- /breadcrumbs -->

	</main>
	<!-- /content -->


	<?php require_once("../+/prefooter.php");?>
	<?php require_once("../+/footer.php");?>
	</body>
</html>

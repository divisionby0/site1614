<?php
include_once ("../div0/utils/StringUtil.php");
include_once ("../div0/utils/Logger.php");

$questionURL = "http:mySite.ru/qa/55/";
$questionId = StringUtil::parseQuestionId($questionURL);

Logger::logMessage($questionURL);
Logger::logMessage($questionId);
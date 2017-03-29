<?php
include_once ("../div0/utils/DateUtil.php");
include_once ("../div0/utils/Logger.php");

$testDate = "2017-03-29 01:40:13";

$format = 'Y-m-d H:i:s';
$date = DateTime::createFromFormat($format, $testDate);
$formattedDate = $date->format($format);

$convertedDate = DateUtil::showDate($formattedDate);

echo $convertedDate;

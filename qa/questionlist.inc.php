<?php include_once ("../div0/utils/DateUtil.php") ?>
<h1 class="center"><? echo $h1 ?></h1>
		<div class="grid2">
			<h2></h2>

			<div class="left_column">
<?
foreach ($Questions as $i=>$q)
{
		if ($i<($CurrPage-1)*5) continue;
		if ($i>$CurrPage*5-1) break;
?>
								<div class="question<? if ($q["f_sticked"]) echo " sticked" ?>">
								<? if ($q["f_sticked"]) { ?><img src="/i/img-sticked.png" alt="" title="Закреплено" /><? } ?>
									
								<?
								if ($q["f_imaged"]) { ?><img src="/i/img-inside.png" alt="" title="Вопрос подкреплён изображением или скриншотом" /><? }
								?>
								  <table>
									<tr>
									  <td valign="middle" align="center" width="50">
										  <span class="patrons" style="color:#f9cc4f" title="Кол-во патронов"><? echo ($q["votes"]<1000 ? $q["votes"] : round($q["votes"]/1000)."k") ?></span>
									  </td>
									  <td>
										<div class="svodki_info_news">
											<span>
												<b>
													<?
													$author = $q["user_name"];

														$creationTime = strtotime($q["when_added"]);
														$timePassed = DateUtil::format($creationTime);
														echo $timePassed;

													$authorIsBot = 0;
													if($q['user_id'] == "1"){
														$authorIsBot = 1;
													}

													if($authorIsBot == 1){
														echo ' от <div style="display:inline-block;">'.$author.'</div></b>';
													}
													else{
														echo ' от <a href="#" title="Профиль пользователя '.$author.'">'.$author.'</a></b>';
													}
													?>
												</b>
										<h4>
											<a href="/qa/<? echo $q["question_id"] ?>/"><? echo StringUtil::uppercaseFirstCharacter($q["question_title"]) ?></a></h4>
										<ul>
										  <li><a href="/qa/<? echo $q["section_uri"] ?>/"><? echo $q["section_name"] ?></a></li>
										  <li><? echo $q["views"] ?> просмотров</li>
										  <li><? echo ($q["answers"]? $q["answers"]." ответов" : "Ждёт ответа") ?></li>
										</ul>
									  </td>
									</tr>
								  </table>
								</div>
<?
} ?>					
			</div>
		
<? include "popularsections.inc.php" ?>
		
		</div>
		
		<div class="clear"></div>

<?
include "pagination.inc.php"
?>

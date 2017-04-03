<?php
include_once ("../div0/utils/DateUtil.php");
include_once ("../div0/voting/VotesElementColor.php");

?>
<h1 class="center">Вопросы и ответы</h1>
		
		<div class="news__row">
			<h2>Новые вопросы</h2>
<?php
function RenderQList($questions, $limit=5, $page=1)
{
	foreach ($questions as $i=>$q)
	{
		if ($i<($page-1)*$limit) continue;
		if ($i>$page*$limit-1) break;
?>
		<div class="question<?php if ($q["f_sticked"]) echo " sticked" ?>">
			<?php if ($q["f_sticked"]) { ?><img src="/i/img-sticked.png" alt="" title="Закреплено" /><?php } ?>
			<?php if ($q["f_imaged"]) { ?><img src="/i/img-inside.png" alt="" title="Вопрос подкреплён изображением или скриншотом" /><?php } ?>
          <table>
            <tr>
              <td valign="middle" align="center" width="50">

                  <?php
                  $totalVotes = ($q["votes"]<1000 ? $q["votes"] : round($q["votes"]/1000));
                  $color = VotesElementColor::calculate($totalVotes);
                  echo '<span class="patrons" style="color:'.$color.';" title="Кол-во патронов">'.$totalVotes.'</span>';
                  ?>
              </td>
              <td>
                <div class="svodki_info_news">
                    <span>
                        <b>
                            <?php
                                $timePassed = DateUtil::showDate($q["when_added"]);
                                echo $timePassed;
                            ?>
                            от
                            <a href="#" title="Профиль пользователя <?php echo $q["user_name"] ?>"><?php echo $q["user_name"] ?></a>
                        </b>
                    </span>
                </div>
                <h4><a href="/qa/<?php echo $q["question_id"] ?>/"><?php echo $q["question_title"] ?></a></h4>
                <ul>
                  <li><a href="/qa/<?php echo $q["section_uri"] ?>/"><?php echo $q["section_name"] ?></a></li>
                  <li><?php echo $q["views"] ?> просмотров</li>
                  <li><?php echo ($q["answers"]? $q["answers"]." ответов" : "Ждёт ответа") ?></li>
                </ul>
              </td>
            </tr>
          </table>
        </div>
<?php
	}
}
$Questions=$qa->getQuestions("qq.when_added>'".date("Y-m-d H:i:s", time()-7*24*60*60)."'", "qq.votes");
RenderQList($Questions, 5, $CurrPage);
?>
		</div>
		<div class="right_side">
			<h2>Популярные за неделю</h2>
<?php

RenderQList($Questions, 4);
?>
			</div>
		
		<div class="clear"></div>

<?php include "pagination.inc.php" ?>

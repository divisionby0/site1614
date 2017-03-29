		<h1 class="center">Вопросы и ответы</h1>
		
		<div class="news__row">
			<h2>Новые вопросы</h2>
<?
function RenderQList($questions, $limit=5, $page=1)
{
	foreach ($questions as $i=>$q)
	{
		if ($i<($page-1)*$limit) continue;
		if ($i>$page*$limit-1) break;
?>
		<div class="question<? if ($q["f_sticked"]) echo " sticked" ?>">
			<? if ($q["f_sticked"]) { ?><img src="/i/img-sticked.png" alt="" title="Закреплено" /><? } ?>
			<? if ($q["f_imaged"]) { ?><img src="/i/img-inside.png" alt="" title="Вопрос подкреплён изображением или скриншотом" /><? } ?>
          <table>
            <tr>
              <td valign="middle" align="center" width="50"><span class="patrons" style="color:#f9cc4f" title="Кол-во патронов"><? echo ($q["votes"]<1000 ? $q["votes"] : round($q["votes"]/1000)) ?></span></td>
              <td>
                <div class="svodki_info_news"><span><b><? echo rdate(strtotime($q["when_added"]), $true) ?> от <a href="#" title="Профиль пользователя <? echo $q["user_name"] ?>"><? echo $q["user_name"] ?></a></b></span></div>
                <h4><a href="/qa/<? echo $q["question_id"] ?>/"><? echo $q["question_title"] ?></a></h4>
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
	}
}

RenderQList($Questions, 5, $CurrPage);

?>
		</div>
		<div class="right_side">
			<h2>Популярные за неделю</h2>
<?
$Questions=$qa->getQuestions("qq.when_added>'".date("Y-m-d H:i:s", time()-7*24*60*60)."'", "qq.votes");
RenderQList($Questions, 4);
?>
			</div>
		
		<div class="clear"></div>

<?/*		<div class="loadmore"><a href="#">Подгрузить ещё вопросы</a><img src="/i/loadmore.png" ></div>*/?>

<? include "pagination.inc.php" ?>

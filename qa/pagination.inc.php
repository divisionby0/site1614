<?
	if ($PagesCount>1)
	{
?>		<ul class="pagination"><?
#		if ($CurrPage>1) $PagesBlock.='<a href="?s='.urlencode($SearchStr).'">&lt;&lt;</a>';
#		if ($CurrPage>2) $PagesBlock.='<a href="?s='.urlencode($SearchStr).'&page='.($CurrPage-1).'">&lt;</a>';
		$fLeftPause=false; $fRightPause=false;
		for ($pi=1;$pi<=$PagesCount;$pi++)
		{
			if ($pi>2 && $pi<$CurrPage-3) { if (!$fLeftPause) { ?><li><span>&hellip;</span></li><? } $fLeftPause=true; continue; }
			if ($pi<$PagesCount-1 && $pi>$CurrPage+3) { if (!$fRightPause) { ?><li><span>&hellip;</span></li><? } $fRightPause=true; continue; }
			
			if ($CurrPage==$pi)
			{
				?><li><? echo $PagesCount-$pi+1; ?></li><?
			}
			else
			{
				?><li><a href="/qa<? echo ($qa_sub ? "/".$qa_sub : "").($pi>1 ? "/page".$pi : "") ?>/"><? echo $PagesCount-$pi+1; ?></a></li><?
			}
		}
#		if ($CurrPage<$PagesCount-1) $PagesBlock.='<a href="?s='.urlencode($SearchStr).'&page='.($CurrPage+1).'">&gt;</a>';
#		if ($CurrPage<$PagesCount) $PagesBlock.='<a href="?s='.urlencode($SearchStr).'&page='.($PagesCount).'">&gt;&gt;</a>';
?>		</ul><?
	}
?>

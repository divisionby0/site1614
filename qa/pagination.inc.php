<?php
	if ($PagesCount>1)
	{
?>		<ul class="pagination">
		<?php
		$fLeftPause=false;
		$fRightPause=false;
		for ($pi=1;$pi<=$PagesCount;$pi++)
		{
			if ($pi>2 && $pi<$CurrPage-3) { if (!$fLeftPause) { ?><li><span>&hellip;</span></li><?php } $fLeftPause=true; continue; }
			if ($pi<$PagesCount-1 && $pi>$CurrPage+3) { if (!$fRightPause) { ?><li><span>&hellip;</span></li><?php } $fRightPause=true; continue; }
			
			if ($CurrPage==$pi)
			{
				?><li><?php echo $PagesCount-$pi+1; ?></li><?
			}
			else
			{
				?><li><a href="/qa<?php echo ($qa_sub ? "/".$qa_sub : "").($pi>1 ? "/page".$pi : "") ?>/"><?php echo $PagesCount-$pi+1; ?></a></li><?php
			}
		}
?>		</ul><?php
	}
?>

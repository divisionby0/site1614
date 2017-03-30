			<div class="right_column">
					<div class="pop-cat">	
						<h4>Популярные разделы</h4>
<?
$sections=$qa->getSections(3);
foreach ($sections as $section) {	?>
							<div>
								<h5><a href="/qa/<? echo $section["uri"] ?>/"><? echo $section["name"] ?></a></h5>
								<span><? echo $section["questions_number"] ?> вопросов</span>
								<p><? echo $section["description"] ?></p>
							</div>
<?
}	?>
							<span class="all"><a href="/qa/tags/">Все разделы</a></span>	
					</div>
			</div>		

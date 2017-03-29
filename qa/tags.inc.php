<?
$sections=$qa->getSections();
#echo "<pre>"; print_r($sections); echo "</pre>"; exit;
?>
		<h1 class="center">Разделы</h1>
			<div class="grid4">
				<h2>Сортировка по популярности</h2>
				<?
				foreach ($sections as $section) {	?>
				<div>
					<h3><a href="/qa/<? echo $section["uri"] ?>/"><? echo $section["name"] ?></a></h3>
					<span><? echo $section["questions_number"] ?> вопросов</span>
					<p><? echo $section["description"] ?></p>
				</div>
<?				}	?>
			</div>

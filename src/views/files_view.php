<?php
	$title_name = 'Файлы';
	include $_SERVER['DOCUMENT_ROOT'].'/templates/header.php';
	include $_SERVER['DOCUMENT_ROOT'].'/controllers/files.php';
	
	if ($_SESSION['prv'] == 'admin'):
?>
<hr class="dashed">
<p>Добавить файл</p>
<form action="" method="post">
	<label>Ссылка на файл:</label>
	<input name="addFile" type="text" required>
	<button type="submit">Добавить файл</button>
</form>
<?php
	endif;
	include $_SERVER['DOCUMENT_ROOT'].'/templates/footer.php';
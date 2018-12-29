<?php
//
// کـاربــر تـالار گفتگـوی پـرشـیـن اسکـریـپــت » i PersianScript « فـارسـی و زیـبـــا ! سـازی شـده تـوسـط 
//
// Copyright © 2011 All right reserved By » i PersianScript « the user » forum.persianscript.ir « Forum . 
//
// Powered by FTPLess .
//

include('config.php');

$dirs = get_directories($start_dir);
$max = $max_size * 1048576;
if (isset($_POST['submit'])) {
	$c = get_post_data();
	
	if (empty($c['directory']) || !in_array($c['directory'], $dirs)) $c['directory'] = $current_dir;
	
	if (!empty($_FILES) && is_array($_FILES) && !empty($_FILES['file']) && is_array($_FILES['file']) && (int)$_FILES['file']['error'] === 0 && $_FILES['file']['size'] <= $max) {
		$file = $_FILES['file'];
		$move = ABSPATH.$c['directory'].$file['name'];
		
		if (is_file($move)) error('&nbsp;فـايـلـي بـا ايـن نـام از قـبـل وجـود دارد&nbsp;');
		if (@move_uploaded_file($file['tmp_name'], $move)) header('Location: index.php');
		else error('&nbsp;نـاتـوان در آپـلــود ايـن فـايــل، لـطـفــا بـعـداً دوبـاره سـعـي کـنـيـد&nbsp;');
	} else error('&nbsp;مـگــابـايــت بـاشــد&nbsp;'.$maxSize.'&nbsp;لـطـفــا فـايـلــي را انـتـخـاب کـنـيـد کـه حـجـم آن کـمـتـر از&nbsp;');
} else {
	$title = '&nbsp;آپـلــود فـايــل&nbsp;';
	get_header();
?>
	<h2>&nbsp;آپـلــود فـايــل&nbsp;</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<p>
			<label for="directory">&nbsp;: مـسـيــر&nbsp;</label>
			<select name="directory" id="directory">
<?php foreach($dirs as $dir) { ?>
				<option value="<?php echo $dir; ?>"><?php echo $dir; ?></option>
<?php } ?>
			</select>
			<br class="clear" />
		</p>
		<p>
			<label for="file">&nbsp;: فـايــل&nbsp;</label>
			<input type="file" name="file" id="file" />
			<input type="hidden" name="MAX_UPLOAD_SIZE" value="<?php echo $max ?>" />
			<br/>
	<em id="emem">&nbsp;حـداکـثـر انــدازه مـجــاز :&nbsp;<?php echo $max_size; ?>&nbsp;مـگـابـايـت&nbsp;</em>
			<br class="clear" />
		</p>
		<p><input type="submit" name="submit" class="button" value=" آپـلــود " /><br class="clear" /></p>
	</form>
<?php
	get_footer();
}
?>
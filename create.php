<?php
//
// کـاربــر تـالار گفتگـوی پـرشـیـن اسکـریـپــت » i PersianScript « فـارسـی و زیـبـــا ! سـازی شـده تـوسـط 
//
// Copyright © 2011 All right reserved By » i PersianScript « the user » forum.persianscript.ir « Forum . 
//
// Powered by FTPLess .
//

include('config.php');
$action = get_global($_GET, 'action');
$dirs = get_directories($start_dir);

if ($action == 'directory') {
	if (isset($_POST['submit'])) {
		$c = get_post_data();
		
		if (empty($c['directory']) || !in_array($c['directory'], $dirs)) $c['directory'] = $currentDir;
		if (empty($c['name'])) error('&nbsp;لـطـفــا يـک نـام بـرای مـسيــر انـتـخـاب کـنـيـد&nbsp;');
		if (preg_match('|[^/]$|', $c['name'])) $c['name'] .= '/'; 
		
		$test = ABSPATH.$c['directory'].$c['name'];
		if (is_dir($test)) error('&nbsp;مـسـيــری بـا ايــن نــام از قـبـل وجــود دارد&nbsp;');
		
		if (mkdir($test)) header('Location: index.php');
		else error('&nbsp;! در ایـن لـحـظـه قـادر بـه سـاخـتـن مـسـیــر نـمـی بـاشــد&nbsp;');
	} else {
		$title = '&nbsp;سـاخـتـن مـسـیــر&nbsp;';
		get_header();
?>
	<h2>&nbsp;سـاخـتـن مـسـیــر&nbsp;</h2>
	<form action="create.php?action=directory" method="post">
		<p>
			<label for="directory">&nbsp;: مـسـيــر&nbsp;</label>
			<select name="directory">
<?php foreach($dirs as $dir) { ?>
				<option value="<?php echo $dir; ?>"><?php echo $dir; ?></option>
<?php } ?>
			</select>
			<br class="clear" />
		</p>
		<p>
			<label for="name">&nbsp;: نــام&nbsp;</label>
			<input type="text" name="name" id="name" />
			<br class="clear" />
		</p>
		<p><input type="submit" name="submit" class="button" value=" سـاخـتـن " /><br class="clear" /></p>
	</form>
<?php
		get_footer();
	}
} else {
	if (isset($_POST['submit'])) {
		$c = get_post_data();
		
		if (empty($c['directory']) || !in_array($c['directory'], $dirs)) $c['directory'] = $currentDir;
		if (empty($c['name'])) error('&nbsp;لـطـفـا یـک نـام بـرای فـایــل انـتـخـاب کـنـیـد&nbsp');
		
		$test = ABSPATH.$c['directory'].$c['name'];
		if (is_dir($test)) error('&nbsp;فـایـلــی بـا ایـن نــام از قـبـل وجــود دارد&nbsp');
		
		$fh = fopen($test, 'w');
		if (fwrite($fh, $c['content']) !== false) {
			fclose($fh);
			header('Location: index.php');
		} else {
			fclose($fh);
			error('&nbsp;! در ایـن لـحـظـه قـادر بـه سـاخـتـن فـایــل نـمـی بـاشــد&nbsp;');
		}
	} else {
		$edit = true;
		$title = '&nbsp;سـاخـتـن فـایــل&nbsp;';
		get_header();
?>
	<h2>&nbsp;سـاخـتـن فـایــل&nbsp;</h2>
	<form action="create.php?action=file" method="post">
		<p>
			<label for="directory">&nbsp;: مـسـيــر&nbsp;</label>
			<select name="directory">
<?php foreach($dirs as $dir) { ?>
				<option value="<?php echo $dir; ?>"><?php echo $dir; ?></option>
<?php } ?>
			</select>
			<br class="clear" />
		</p>
		<p>
			<label for="name">&nbsp;: نــام&nbsp;</label>
			<input type="text" name="name" id="name" />
			<br class="clear" />
		</p>
		<p>
			<label for="content">&nbsp;: تـوضـيـحــات&nbsp;</label>
			<textarea type="text" name="content" id="content" rows="10" cols="60"></textarea>
			<br class="clear" />
		</p>
		<p><input type="submit" name="submit" class="button" value=" سـاخـتـن " /><br class="clear" /></p>
	</form>
<?php
		get_footer();
	}
}
?>
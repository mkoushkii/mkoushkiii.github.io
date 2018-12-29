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
$dir = urldecode(get_global($_GET, 'dir'));
$file = urldecode(get_global($_GET, 'file'));

if (!empty($dir)) {
	while(strpos($dir, '../') !== false) $dir = str_replace('../', '', $dir);
}

if (!empty($file)) {
	while(strpos($file, '../') !== false) $file = str_replace('../', '', $file);
}

if (!in_array($dir, $dirs)) error('&nbsp;مـسـيـر انـتـخـاب شـده تـوسـط شـمــا نـامـعـتـبـر اســت&nbsp;');

if (isset($_POST['submit'])) {
	$c = get_post_data(true);
	
	if (empty($file)) {
		if ($c['name'] != $dir && is_dir($c['name'])) error('&nbsp;<a href="javascript:history.back();">&nbsp;« بـرگـشـت&nbsp;</a>&nbsp;مـسـيـري بـا ايـن نـام از قـبـل وجـود دارد&nbsp;');
		
		chmod($dir, octdec($c['chmod']));
		rename($dir, $c['name']);
		header('Location: index.php');
		exit;
	} else {
		if (!empty($c['directory']) && in_array($c['directory'], $dirs)) $newDir = $c['directory'];
		else $newDir = '';
		
		if ($c['name'] != $file && is_file($newDir.$c['name'])) error('&nbsp;<a href="javascript:history.back();">&nbsp;« بـر گـشـت&nbsp;</a>&nbsp;فـايـلـي بـا ايـن نـام از قـبـل وجـود دارد&nbsp;');
		
		chmod($dir.$file, octdec($c['chmod']));
		
		if (get_file_type($dir.$file) != 'image' && is_writeable($dir.$file)) {
			$fh = fopen($dir.$file, 'w');
			fwrite($fh, $c['file_contents']);
			fclose($fh);
		}
		
		
		rename($dir.$file, $newDir.$c['name']);
		header('Location: index.php');
	}
} else {
	if (!is_file($dir.$file) && !is_dir($dir.$file)) error('&nbsp;<a href="index.php">&nbsp;« بـرگـشـت&nbsp;</a>&nbsp;مـسـيـر يـا فـايـل انـتـخـابـي مـعـتـبـر نـمـي بـاشــد&nbsp;');
	
	if (!empty($file) && get_file_type($file) != 'image') $edit = true;
	else $edit = false;
	$title = $dir.$file.'&nbsp;&nbsp;: ويـرايـش فـايــل&nbsp;';
	get_header();
	
	if ($edit === true) $contents = htmlspecialchars(implode("\n", file($dir.$file, FILE_IGNORE_NEW_LINES))); // Requires PHP 5.0
?>
	<h2><?php echo $title; ?><span><a href="index.php">&nbsp;« بـرگـشــت&nbsp;</a></span></h2>

	<form action="edit.php?dir=<?php echo urlencode($dir); ?><?php if (!empty($file)) echo '&amp;file='.urlencode($file); ?>" method="post">
<?php if (!empty($file)) { ?>
		<p>
			<label for="directory">&nbsp;: مـسـيــر&nbsp;</label>
			<select name="directory">
<?php foreach($dirs as $directory) { ?>
				<option value="<?php echo $directory; ?>"<?php if ($directory == $dir) echo ' selected="selected"'; ?>><?php echo $directory; ?></option>
<?php } ?>
			</select>
			<br class="clear" />
		</p>
<?php } ?>
		<p>
			<label for="name">&nbsp;: نــام&nbsp;</label> <input type="text" name="name" id="name" value="<?php if (!empty($file)) echo $file; else echo $dir; ?>" /><br class="clear" /></p>
<?php if ($edit === true) { ?>
		<p><label for="file_contents">&nbsp;</label><textarea name="file_contents" id="file_contents" rows="10" cols="60"><?php echo $contents; ?></textarea><br class="clear" /></p>
<?php } ?>
		<p>
			<label for="chmod">&nbsp;: دسـتـرسـي&nbsp;</label>
			<input type="text" name="chmod" id="chmod" value="<?php echo substr(sprintf('%o', fileperms($dir.$file)), -3, 3); ?>" />
			<br class="clear" />
		</p>
		<p><input type="submit" name="submit" class="button" accesskey="s" value=" ذخـيــره " /><br class="clear" /></p>
	</form>
<?php
	get_footer();
}
?>
<form action="" method="post">
	DVTV URL (video.aktualne.cz):<br>
	<input type="text" name="url" size="100" value="<?php echo preg_match('#^https?://#', $_POST['url']) ? $_POST['url'] : '' ?>">
	<input type="submit">
</form>

<?php
	if (preg_match('#^https?://#', $_POST['url'])) {
		$web = file_get_contents($_POST['url']);
		$title = preg_replace('#.*<h1.*?>(.*?)</h1>.*#s', '$1', $web);
		echo "<h1>$title</h1>";
		
		$tracks = preg_match('#tracks: (\{.*\})#', $web, $matches);
		$json = json_decode($matches[1]);
		
		echo "<ul>";
		foreach ($json->MP4 as $stream) {
			echo "<li><a href='{$stream->src}'>{$stream->label}</a></li>";
		}
		echo "</ul>";
	}
	

<div style="clear: both; height: 10px;"></div>
<div class="input textarea required">
<label for="DocumentFile">File</label>
<?php 
	foreach($files as $file){
		// TODO cgajardo: improve to block unwanted downloads 
		echo "<a href='/repositorium/repo-files/download/".$file['Repo-file']['id']."'>".$file['Repo-file']['filename']."</a>";
	} 
?>
</div>
<div style="clear: both; height: 10px;"></div>
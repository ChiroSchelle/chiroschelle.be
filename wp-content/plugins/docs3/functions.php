<?php

function docs3_post_upload($s3, $bucket, $file, $filename=false)
{
// get some file info
	if (!$filename){
		$options = get_option('docs3_options');
		$filename = $options['prefix'] . $_FILES['theFile']['name'];
	}
	$tmpname = $_FILES['theFile']['tmp_name'];  
	// Create a bucket to upload to
	if (!$s3->if_bucket_exists($bucket))
	{
		$response = $s3->create_bucket($bucket, AmazonS3::REGION_EU_W1);
		if (!$response->isOK()) die('Could not create "' . $bucket . '".');
	}

	// upload the file
	$response = $s3->create_object($bucket, $filename, array(
		'fileUpload' => $tmpname));
	if ($response->isOK()) {
		return true;
	}
		return false;
}

function docs3_list_files($s3, $bucket, $prefix,$validminutes=30,$hide='')
{
	if( $hide == ''){
		$hide = $prefix;
	}
	$filelist = $s3->get_object_list($bucket, array('prefix' => $prefix, 'delimiter' => '/'));
	
	echo $CommonPrefixes;
	echo $s3->CommonPrefixes;
	echo $filelist['CommonPrefixes'];
	
	echo '<ul>';
	foreach ($filelist as $filename) {
	
		//get info
		$url = $s3->get_object_url ( $bucket, $filename, time() + ($validminutes * 60));
		$size = $s3->get_object_filesize ( $bucket, $filename, true);		
		$realsize = $s3->get_object_filesize ( $bucket, $filename, false);		
		
		//markup
		$filename = str_replace($hide, '', $filename);
		
		//display
		if (!$realsize == 0) {
			echo "<li><a href='$url'>$filename</a> ($size)</li>";
		}
	}
		
	echo '</ul>';

}

function docs3_dir_chooser($s3,$bucket,$prefix,$dir = '')
{
?>
	<form action="" method="post">
		<select name='dir'>
			<option value='<?php echo($prefix); ?>'>/</option>
<?php
	$filelist = $s3->get_object_list($bucket, array('prefix' => $prefix));
	foreach ($filelist as $filename) {
		if ($s3->get_object_filesize ( $bucket, $filename, false) == 0 ) {
			echo "<option value='$filename' ";
			if ($filename == $dir) {
				echo "selected='selected' ";
			}
			echo ">". str_replace($prefix, '', $filename) ."</option>";
		}
	}
?>	
		</select>
		<input name="Submit" type="submit" value="Kies">  
	</form>
<?php
}

function docs3_maaktweecijfer($n) {
	switch (strlen($n)){
	case 1:
		$n = '0'.$n;
		break;
	case 2:
		$n = $n;
		break;
	default:
		$n = '';
		break;
	}
	return $n;
}

?>

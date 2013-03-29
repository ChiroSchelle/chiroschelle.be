<?php
/*
 * Copyright 2010 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 * Copyright 2011 Ben Bridts. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

// SETTINGS

	$bucket = 'media.chiroschelle.be'; //bucket to use
	$use_nicename = true; // strip '.s3.amazonaws.com' from urls
	$updir = 'test/'; // parent dir to use, leave empty for root, incl. trailing /
	$valid_minutes = 30; // int, how long most links be valid?
	// Enable full-blown error reporting. http://twitter.com/rasmus/status/7448448829
	error_reporting(-1);

// START

	// Include the SDK
	require_once 'sdk-1.3.3/sdk.class.php';

	// Instantiate the AmazonS3 class
	$s3 = new AmazonS3();
	if ($use_nicename) {
		$s3->set_vhost ( $bucket );
	}
	
// UPLOAD

	if( isset($_POST['Submit']) ) {
		if( $_FILES['theFile']['error'] != UPLOAD_ERR_OK ) {
			echo 'upload error: ' . $_FILES['theFile']['error'];
		}
		else {
			// get some file info
			$filename = $_FILES['theFile']['name'];  
			$tmpname = $_FILES['theFile']['tmp_name'];  

			// Create a bucket to upload to
			if (!$s3->if_bucket_exists($bucket))
			{
				$response = $s3->create_bucket($bucket, AmazonS3::REGION_EU_W1);
				if (!$response->isOK()) die('Could not create `' . $bucket . '`.');
			}
		
			//change the path
			$filepath = '';
			// upload the file
			$response = $s3->create_object($bucket, $updir. $filepath . $filename, array(
				'fileUpload' => $tmpname));
			if (!$response->isOK()) {
				echo('Could not upload `' . $filename . '`.');
			}
			else {
				echo('upload OK');
			}
		}
	}

// LIST

	$filelist = $s3->get_object_list($bucket, array('prefix' => $updir));
	echo '<ul>';
	foreach ($filelist as $filename) {
		//get info
		$url = $s3->get_object_url ( $bucket, $filename, time() + ($valid_minutes * 60));
		$size = $s3->get_object_filesize ( $bucket, $filename, true);
		//markup
		$filename = str_replace($updir, '', $filename);
		
		//display
		echo "<li><a href='$url'>$filename</a> ($size)</li>";
	}
	echo '</ul>';

// FORM
?>
<form action="" method="post" enctype="multipart/form-data">  
  <input name="theFile" type="file" />  
  <input name="Submit" type="submit" value="Upload">  
</form>

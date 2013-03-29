<?php
include('tse-cti.php');
$smileys = tseCTI_get_smileys( 'all' );
$smileypx = ( isset( $_GET['smileysize'] ) && $_GET['smileysize'] == '24' ) ? '24' : '';
/* Start tsepop.htm */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Tango Smileys Extended</title>

<script type="text/javascript" src="tsepop.js?v=307"></script>
<script type="text/javascript">
var TSEDialog = {
	init : function(ed) {
		tinyMCEPopup.resizeToInnerSize();
	},

	insert : function insertTSE(code) {
    	tinyMCEPopup.execCommand('mceInsertContent', false, code);
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(TSEDialog.init, TSEDialog);
</script>

<style type="text/css">
	.tseCTIWrap {
		border: 0;
		padding: 0px;
	}
	.tseCTIWrap img {
		border: 0px;
		margin: 0px;
		padding: 0px 1px 1px 0px;
	}
</style>
<base target="_self" />
</head>
<body style="display: none">
	<div align="center">
		<div class="title">Insert Smiley:<br /></div>
		<div class="tseCTIWrap">
<?php
for ( $i = 0; $i < sizeof( $smileys ); $i++ ) {
	echo "\t\t\t<img src=\"tango{$smileypx}/{$smileys[$i][1]}\" alt=\"{$smileys[$i][2]}\" title=\"{$smileys[$i][2]}\" onclick=\"javascript:TSEDialog.insert('{$smileys[$i][0]}');\" />\n";
}
?>
		</div>
	</div>
</body>
</html>
<?php /* End tsepop.htm */ ?>
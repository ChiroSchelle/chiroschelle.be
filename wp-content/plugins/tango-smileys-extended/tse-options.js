function checkit(checkwhat) {
	if ( checkwhat == "wp_smilies" ) {
		if ( document.getElementById('wp_smilies').checked == true ) {
			document.getElementById('tse_posts').checked = false;
			document.getElementById('tse_pages').checked = false;
			document.getElementById('tse_comments').checked = false;
			document.getElementById('tse_posts_cti').checked = false;
			document.getElementById('tse_pages_cti').checked = false;
			document.getElementById('tse_comments_cti').checked = false;
			document.getElementById('tse_comments_mce').checked = false;
		}
	}
	if ( checkwhat == "tse_posts" ) {
		if ( document.getElementById('tse_posts').checked == true ) {
			document.getElementById('wp_smilies').checked = false;
		}
		if ( document.getElementById('tse_posts').checked == false ) {
			document.getElementById('tse_posts_cti').checked = false;
		}
	}
	if ( checkwhat == "tse_pages" ) {
		if ( document.getElementById('tse_pages').checked == true ) {
			document.getElementById('wp_smilies').checked = false;
		}
		if ( document.getElementById('tse_pages').checked == false ) {
			document.getElementById('tse_pages_cti').checked = false;
		}
	}
	if ( checkwhat == "tse_comments" ) {
		if ( document.getElementById('tse_comments').checked == true ) {
			document.getElementById('wp_smilies').checked = false;
		}
		if ( document.getElementById('tse_comments').checked == false ) {
			document.getElementById('tse_comments_cti').checked = false;
			document.getElementById('tse_comments_mce').checked = false;
		}
	}
	if ( checkwhat == "tse_posts_cti" ) {
		if ( document.getElementById('tse_posts_cti').checked == true ) {
			document.getElementById('wp_smilies').checked = false;
			document.getElementById('tse_posts').checked = true;
		}
	}
	if ( checkwhat == "tse_pages_cti" ) {
		if ( document.getElementById('tse_pages_cti').checked == true ) {
			document.getElementById('wp_smilies').checked = false;
			document.getElementById('tse_pages').checked = true;
		}
	}
	if ( checkwhat == "tse_comments_cti" ) {
		if ( document.getElementById('tse_comments_cti').checked == true ) {
			document.getElementById('wp_smilies').checked = false;
			document.getElementById('tse_comments').checked = true;
		}
		if ( document.getElementById('tse_comments_cti').checked == false ) {
			document.getElementById('tse_comments_mce').checked = false;
		}
	}
	if ( checkwhat == "tse_comments_mce" ) {
		if ( document.getElementById('tse_comments_mce').checked == true ) {
			document.getElementById('wp_smilies').checked = false;
			document.getElementById('tse_comments').checked = true;
			document.getElementById('tse_comments_cti').checked = true;
		}
	}
}

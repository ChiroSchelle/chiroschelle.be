<?php

return array(
	'dbcache.enabled' => false,
	'dbcache.debug' => false,
	'dbcache.engine' => 'file',
	'dbcache.file.gc' => 3600,
	'dbcache.memcached.servers' => array(
		0 => '127.0.0.1:11211',
	),
	'dbcache.memcached.persistant' => true,
	'dbcache.reject.logged' => true,
	'dbcache.reject.uri' => array(
	),
	'dbcache.reject.cookie' => array(
	),
	'dbcache.reject.sql' => array(
		0 => 'gdsr_',
	),
	'dbcache.lifetime' => 180,
	'pgcache.enabled' => true,
	'pgcache.debug' => false,
	'pgcache.engine' => 'file_pgcache',
	'pgcache.file.gc' => 3600,
	'pgcache.memcached.servers' => array(
		0 => '127.0.0.1:11211',
	),
	'pgcache.memcached.persistant' => true,
	'pgcache.lifetime' => 3600,
	'pgcache.compression' => 'gzip',
	'pgcache.cache.query' => true,
	'pgcache.cache.home' => true,
	'pgcache.cache.feed' => true,
	'pgcache.cache.404' => false,
	'pgcache.cache.flush' => false,
	'pgcache.cache.headers' => array(
		0 => 'Last-Modified',
		1 => 'Content-Type',
		2 => 'X-Pingback',
	),
	'pgcache.accept.files' => array(
		0 => 'wp-comments-popup.php',
		1 => 'wp-links-opml.php',
		2 => 'wp-locations.php',
	),
	'pgcache.reject.logged' => true,
	'pgcache.reject.uri' => array(
		0 => 'wp-.*\\.php',
		1 => 'index\\.php',
	),
	'pgcache.reject.ua' => array(
		0 => 'bot',
		1 => 'ia_archive',
		2 => 'slurp',
		3 => 'crawl',
		4 => 'spider',
	),
	'pgcache.reject.cookie' => array(
	),
	'pgcache.mobile.redirect' => '',
	'pgcache.mobile.agents' => array(
		0 => '2.0 MMP',
		1 => '240x320',
		2 => 'ASUS',
		3 => 'AU-MIC',
		4 => 'Alcatel',
		5 => 'Amoi',
		6 => 'Android',
		7 => 'Audiovox',
		8 => 'AvantGo',
		9 => 'BenQ',
		10 => 'Bird',
		11 => 'BlackBerry',
		12 => 'Blazer',
		13 => 'CDM',
		14 => 'Cellphone',
		15 => 'DDIPOCKET',
		16 => 'Danger',
		17 => 'DoCoMo',
		18 => 'Elaine/3.0',
		19 => 'Ericsson',
		20 => 'EudoraWeb',
		21 => 'Fly',
		22 => 'HP.iPAQ',
		23 => 'Haier',
		24 => 'Huawei',
		25 => 'IEMobile',
		26 => 'J-PHONE',
		27 => 'KDDI',
		28 => 'KONKA',
		29 => 'KWC',
		30 => 'KYOCERA/WX310K',
		31 => 'LG',
		32 => 'LG/U990',
		33 => 'Lenovo',
		34 => 'MIDP-2.0',
		35 => 'MMEF20',
		36 => 'MOT-V',
		37 => 'MobilePhone',
		38 => 'Motorola',
		39 => 'NEWGEN',
		40 => 'NetFront',
		41 => 'Newt',
		42 => 'Nintendo Wii',
		43 => 'Nitro',
		44 => 'Nokia',
		45 => 'Novarra',
		46 => 'O2',
		47 => 'Opera Mini',
		48 => 'Opera.Mobi',
		49 => 'PANTECH',
		50 => 'PDXGW',
		51 => 'PG',
		52 => 'PPC',
		53 => 'PT',
		54 => 'Palm',
		55 => 'Panasonic',
		56 => 'Philips',
		57 => 'Playstation Portable',
		58 => 'ProxiNet',
		59 => 'Proxinet',
		60 => 'Qtek',
		61 => 'SCH',
		62 => 'SEC',
		63 => 'SGH',
		64 => 'SHARP-TQ-GX10',
		65 => 'SPH',
		66 => 'Sagem',
		67 => 'Samsung',
		68 => 'Sanyo',
		69 => 'Sendo',
		70 => 'Sharp',
		71 => 'Small',
		72 => 'Smartphone',
		73 => 'SoftBank',
		74 => 'SonyEricsson',
		75 => 'Symbian',
		76 => 'Symbian OS',
		77 => 'SymbianOS',
		78 => 'TS21i-10',
		79 => 'Toshiba',
		80 => 'Treo',
		81 => 'UP.Browser',
		82 => 'UP.Link',
		83 => 'UTS',
		84 => 'Vertu',
		85 => 'WILLCOME',
		86 => 'WinWAP',
		87 => 'Windows CE',
		88 => 'Windows.CE',
		89 => 'Xda',
		90 => 'ZTE',
		91 => 'dopod',
		92 => 'hiptop',
		93 => 'htc',
		94 => 'i-mobile',
		95 => 'iPhone',
		96 => 'iPod',
		97 => 'nokia',
		98 => 'portalmmm',
		99 => 'vodafone',
	),
	'minify.enabled' => true,
	'minify.debug' => false,
	'minify.engine' => 'file',
	'minify.file.locking' => true,
	'minify.file.gc' => 86400,
	'minify.memcached.servers' => array(
		0 => '127.0.0.1:11211',
	),
	'minify.memcached.persistant' => true,
	'minify.rewrite' => true,
	'minify.fixtime' => 0,
	'minify.compression' => 'gzip',
	'minify.options' => array(
		'bubbleCssImports' => false,
		'minApp' => array(
			'groupsOnly' => false,
			'maxFiles' => 20,
		),
	),
	'minify.symlinks' => array(
	),
	'minify.maxage' => 86400,
	'minify.lifetime' => 86400,
	'minify.upload' => true,
	'minify.html.enable' => false,
	'minify.html.reject.admin' => true,
	'minify.html.reject.feed' => false,
	'minify.html.inline.css' => false,
	'minify.html.inline.js' => false,
	'minify.html.strip.crlf' => false,
	'minify.css.enable' => true,
	'minify.css.combine' => false,
	'minify.css.strip.comments' => false,
	'minify.css.strip.crlf' => false,
	'minify.css.groups' => array(
	),
	'minify.js.enable' => true,
	'minify.js.combine.header' => false,
	'minify.js.combine.footer' => false,
	'minify.js.strip.comments' => false,
	'minify.js.strip.crlf' => false,
	'minify.js.groups' => array(
	),
	'minify.reject.ua' => array(
	),
	'minify.reject.uri' => array(
	),
	'cdn.enabled' => false,
	'cdn.debug' => false,
	'cdn.engine' => 'ftp',
	'cdn.includes.enable' => true,
	'cdn.includes.files' => '*.css;*.js;*.gif;*.png;*.jpg',
	'cdn.theme.enable' => true,
	'cdn.theme.files' => '*.css;*.js;*.gif;*.png;*.jpg;*.ico',
	'cdn.minify.enable' => true,
	'cdn.custom.enable' => true,
	'cdn.custom.files' => array(
		0 => 'favicon.ico',
		1 => 'wp-content/gallery/*',
	),
	'cdn.import.external' => false,
	'cdn.import.files' => '*.jpg;*.png;*.gif;*.avi;*.wmv;*.mpg;*.wav;*.mp3;*.txt;*.rtf;*.doc;*.xls;*.rar;*.zip;*.tar;*.gz;*.exe',
	'cdn.queue.limit' => 25,
	'cdn.force.rewrite' => false,
	'cdn.mirror.domain' => '',
	'cdn.ftp.host' => '',
	'cdn.ftp.user' => '',
	'cdn.ftp.pass' => '',
	'cdn.ftp.path' => '',
	'cdn.ftp.pasv' => false,
	'cdn.ftp.domain' => '',
	'cdn.s3.key' => '',
	'cdn.s3.secret' => '',
	'cdn.s3.bucket' => '',
	'cdn.cf.key' => '',
	'cdn.cf.secret' => '',
	'cdn.cf.bucket' => '',
	'cdn.cf.id' => '',
	'cdn.cf.cname' => '',
	'cdn.reject.ua' => array(
	),
	'cdn.reject.uri' => array(
	),
	'cdn.reject.files' => array(
		0 => 'wp-content/uploads/wpcf7_captcha/*',
	),
	'common.support' => '',
	'common.install' => 1271230932,
	'common.tweeted' => 0,
	'widget.latest.enabled' => false,
	'widget.latest.items' => 3,
	'notes.defaults' => true,
	'notes.wp_content_perms' => true,
	'notes.php_is_old' => true,
	'notes.theme_changed' => false,
	'notes.wp_upgraded' => false,
	'notes.plugins_updated' => false,
	'notes.cdn_upload' => false,
	'notes.need_empty_pgcache' => false,
	'notes.need_empty_minify' => false,
	'notes.pgcache_rules_core' => true,
	'notes.pgcache_rules_cache' => true,
	'notes.minify_rules' => true,
	'notes.support_us' => true,
	'notes.no_curl' => true,
	'notes.no_zlib' => true,
	'notes.zlib_output_compression' => true,
);
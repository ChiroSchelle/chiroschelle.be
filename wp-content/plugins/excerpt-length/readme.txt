=== Excerpt Length ===
Contributors: vertino
Donate link: http://www.dreamhost.com/donate.cgi?id=7992
Tags: excerpt, length, word limit, formatting, admin, options, settings
Requires at least: 2.7
Tested up to: 2.8
Stable tag: trunk

Adds an Excerpt Length field setting to the Reading Settings section, this is used to set the number of words that appear in the the_excerpt().

== Description ==

Adds an Excerpt Length field setting to the Reading Settings section. This value is used to specify the number of words that you would like to appear in the <a href="http://codex.wordpress.org/Template_Tags/the_excerpt" rel="external">the_excerpt()</a>.

== Installation ==

1. Unzip the excerpt-length.zip file.
2. Upload the `excerpt-length` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to the Reading Settings section and specify the length of the excerpt.

== Frequently Asked Questions ==

= Why did you create this plugin? =

Until now, there were 3 ways to change the word length of the excerpt, by either modifying a core file (`formatting.php`), or replacing the `wp_trim_excerpt` filter in your theme's `functions.php` code, or by using a different plugin (requiring you to edit your theme/templates).

This plugin simply adds a new field setting to the Reading section called **Excerpt Length**. The value you set limits the number of words displayed when `the_excerpt()` is called by your theme.

= Does it work for WordPress version x.x.x? =

This plugin only works in WordPress 2.7 and above. This is due to new API calls that were made available in version 2.7. It will not work in earlier version of WordPress (2.6 and below).

= Does this plugin change the formatting of the_excerpt? =

No, this plugin has one sole purpose, that is to enable you to change the word length of the excerpt.

= Excerpt Suffix =
In version 1.1 of Excerpt Length I have added a new field called **Excerpt Suffix**. This is used to replace the default `[...]` text that is appended to the excerpt length. You can now used whatever text you like as the suffix.
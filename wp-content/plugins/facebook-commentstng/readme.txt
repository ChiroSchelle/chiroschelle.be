=== Facebook CommentsTNG ===
Contributors: crazyspence,bandonrandon 
Donate link: http://www.philtopia.com/?page_id=292
Tags: comments, facebook, integration
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 0.20

Facebook CommentsTNG will pull your comments from imported Facebook Notes back into your blog

== Description ==

** Now supports Facebook pages Notes **
Facebook CommentsTNG will pull your comments from imported Facebook Notes back into your blog. Currently it
has a test mode which will display any notes and comments that it intends to import ,a manual
import button for manually importing comments, daily and hourly timers, a limit option for limiting how far back
the plugin goes and an e-mail field that can be set if you have a gravatar you want used for facebook users. Additional
features include: Pulling accurate comment time from original Facebook comment, Being able to pull comments from Facebook's under different languages.
Enjoy and don't hesitate to ask me a question!

== Installation ==

1. Extract the plugin to your wordpress plugins directory
1. Activate plugin
1. Add your Facebook user and password to the settings
1. Do a test run to see if it works ok before risking the database
1. If that went well you can do Manual update or set an hourly or daily timer

== Frequently Asked Questions ==
= I just activated First names only and now I have duplicates =
If you do this before running a test or update the old comments will not be upgraded with fb ID's and they will be seen as new comments. You can remove the duplicates and they will not duplicate again

= Why doesn't it support Facebook pages? =
It does now since 0.19! yay!

= How do I get the Page ID of a Facebook page =
Log into Facebook and click ads and pages. Then grab the id from your URL http://www.facebook.com/home.php#!/pages/edit/?id=123456 <- 123456 would be the ID

= Why doesn't it automatically scan hourly or daily? =
It does since 0.12! yay!

= It told me it ran out of memory with a fatal error =
In most cases this has been corrected however it can still happen. Try to limit your crawl, I set mine to 10 for example. If you need the older comments you can change the start page to get them then change it back, historically facebook people only comment on new things anyways. If you are using filters or notifiers that handle comments as they come in this may double the load and cause an issue

= I get Parse error: syntax error, unexpected T_OBJECT_OPERATOR =
You are not running PHP 5 and unfortunately this plugin requires it

= Why doesnt this work with.... =
That is not the purpose of it, it only works with facebook notes, not any plugins that pull WP into facebook,  status updates, wall posts etc. Once again it ONLY works with default imported facebook notes

== Screenshots ==
1. This is a shot of some Facebook imported comments with Gravatar's in the recent comments section
2. This is some comments on my blog with the Facebook Gravatar

== Changelog ==

= 0.20 =
* Fixed duplication for future comments by using the facebook ID as the ip address
* comments exists function will upgrade old comments with FB ID's during a scan or test run but it only upgrades as far back as your crawl limit is set
* Added option to attempt to display only first names. People with multiple spaces or bizarre names may be broken. Make sure you run a test to upgrade old comments within your crawl before applying this or you may have duplicates
* Mobile facebook removed _notes_ from div tag preventing comment crawl, modified div search
* When the Facebook profile URL option is disabled no URL's are applied to the comment

= 0.19 =
* Support for Facebook Pages Notes added
* Added Pages field on setup page. This field is where the Page ID would be entered if you wanted your Facebook Page crawled instead of a profile
* Added 2 more debug catchers for the url and post count for troubleshooting
* Added explanation of Page ID to Settings page
* Added value check to Start page as it let non numbers be set to it
* Added Value check to Page ID field to ensure numerical values
* Added function facebook_connect_timer function which will disable debug mode when the script is being run by CRON as the debug messages were stopping it from running
* Added timer debug message
* Fixed yesterday, it was coming up as 1970 00:00 if a comment was crawled and it was dated yesterday which was messing up the order of comments on the blog
* Added tooltip to Page ID field that explains how to get it

= 0.18 =
* bandonrandon:
* Only level 5 (admin) can view the configuration page
* Options save on any button push in configuration page
* Test output confined it's own sub frame
* User error catch for the e-mail and password fields to ensure they are filled out
* Changelog re ordered from newest to oldest
* CrazySpence:
* added html->clear() to spider_notes and find_comments functions to counter act some (hopefully most) issues with PHP running out of memory. 
* Autocrawl was unable to be turned off, fixed schedule clearing to correct this
* Cleaned up code so it followed the same tabbing and logic formatting throughout
* Parser can now find more than 15 comments per post

= 0.17 =
* New contributer - bandonrandon
* Some CSS fixes that make it look less like a terminal app and more like a web program - bandonrandon
* Option to link directly to facebook profile instead of a generic www.facebook.com - bandonrandon

= 0.16 =
* Made code more accepting of non standard databases
* Some characters having issues have been corrected, not all

= 0.15 =
* Fixed a bug with my time format that was causing the time to be wrong
* added auto approving option but please make sure you verify test and manual work before using it!

= 0.14.1 =
* Plugin activation hook was not firing for new people, if you have already setup the plugin this isnt crucial but this will make sure all new users will have the default facebook@philtopia.com gravatar and that start post is set to 1

= 0.14 =
* Fixed a rogue variable that doesn't have any purpose and in some situations may have caused a syntax error
* Set plugin to always read the facebook notes page in locale en_US to avoid breaking the parsing. This is done in a way that will NOT change your actual Facebook locale
* Plugin can now pull the time from your comments and add them as the same times in WordPress
* Fixed an ovesight with the timer settings that may have cause the timer to occur many times depending on how many times you saved options

= 0.13 =
* Added e-mail address field so a custom e-mail address can be entered. Currently defaults to facebook@philtopia.com which has a Gravatar setup for a facebook icon
* Added starting post field so the crawl can be started at a certain point
* Moved Options Updated message to after the options are actually updated
* Update e-mail addresses button will update the e-mail address field on all Facebook TNG comments. Meant to be used after changing the e-mail field

= 0.12 =
* Prefixed all functions with tng_ to avoid conflicts with other funcions or plugins
* Added limit function to limit how many notes are scanned, 0 to scan all notes. This will be helpful to people with many notes or small memory restrictions
* Added timer functions for hourly and daily
* Corrected comment adding function data as it was not adding a time or the facebook url to comments and this was causing it not to show properly in recent comments
* Removed some commented out code from intial development that would not be needed
* Renamed Settings page to Facebook CommentsTNG from Facebook NotesTNG

= 0.11 =
* Re arranged the check for a note that sees if it is a Wordpress blog to a point before downloading it to improve memory usage

= 0.1 =
* Scans all notes for comments and adds them to database to await approval
* Test mode which only shows comments not detected in database

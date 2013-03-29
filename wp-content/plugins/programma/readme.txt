=== Simple WordPress Framework ===
Contributors: leonardomartinez
Donate link: http://www.swpframework.com/donation
Tags: framework, API
Requires at least: 1.7.6
Tested up to: 1.8.4
Stable tag: Beta 0.9.1

A simple framework that helps programmers builds Plugins quickly using the standards, functions, and classes that exist in the WordPress API Manual.

== Description ==

[Simple WordPress Framework](http://www.swpframework.com/) is a Plugin to help you create new Plugins.  Even though this is first version (Beta) of Simple WordPress Framework, it is fully functional.  It was designed using the standards and requirements specified in the [WordPress Plugin API Manual](http://codex.wordpress.org/Plugin_API) and follows the correct programming structure, functions and procedures that are required to build a Plugin in WordPress.  In every PHP file you will find notes and urls referring to the WordPress API articles that are relevant.

**What does this Plugin do?**

1. Helps new Plugin developers follow WordPress development standards.
1. Provide documentation, and URL references to WordPress API in the code.
1. Decreases the amount of time it takes to setup a new Plugin.

**What Plugin features are supported?**

1. Activation - Adding options, and new database tables.
1. Deactivation - Removing options and database tables created during activation.
1. Menus: New - Create a new menu with submenus, separate from the admin menus.
1. Options Page - A customized options page with additional CSS styles and samples of different `<input>` values (textarea, text, radio, checkbox, etc.) 
1. Use of AJAX/jQuery/JavaScript Components:<ul><li>farbtastic -  Color Picker which allows you to select a color in a palate.</li><li>500+ Icons 16 x 16 and 32 x 32 that can be used in your Plugin.</li></ul>

**Upcoming Features**

1. Menus: Administrative - Add submenus to existing administration menus (release date: 11/01/2009).
1. Updates - Handles automatic updates of new releases (release date: 11/01/2009).
1. List, View and Edit Database a Table - Allows you to add, remove, edit, view data from a new database file (release date: 11/01/2009).

The [changelog](http://wordpress.org/extend/plugins/simple-wordpress-framework/changelog/) is a good place to start if you want to know what has changed since you last downloaded the Plugin.   If you would like to download previous versions, you may do so by clicking on [other versions](http://wordpress.org/extend/plugins/simple-wordpress-framework/download/). 

If you are interested in helping improve the code, develop more features, or want to contribute to the documentation, please feel free to [contact](http://www.swpframework.com/contact/) me.  



== Installation ==

This Plugin works without you having to make any changes. But we recommend that you customize it as described below, before you begin using it in a live setting.

1. Download the Plugin from this website. 
1. Change the [Standard Plugin Information Header](http://codex.wordpress.org/Writing_a_Plugin#File_Headers) at the beginning of the `swpframework.php` file, between lines 3 through 8.  Read the [WordPress API](http://codex.wordpress.org/Writing_a_Plugin#File_Headers) article, it provides a detailed explanation on how to do this. 
1. Choose a **`title`** for your Plugin, the current title for this Plugin is `'SWP Framework'`.  You can give it any name you want, `'Customer List'`, `'Time-Slips'`, `'The Weather Forecaster'`, etc. 
1. Choose a **`file/function`** name for this Plugin, the current name is `swpframework`.  Make sure you use lower case letters, keep it as short as possible, and remove all special characters and spaces from it.  Following the **`title`** examples above, you could use, `'customerlist'`, `'timeslips'`, `'weatherforcaster'`.
1. Use your PHP editor and perform the following tasks to all the files within you Plugin directory.<ul><li>Perform a 'Find and Replace' with 'Match Case' checked, and replace all instances of '`SWP Framework`' with the new **`title`** of your Plugin.  This **`title`** is used throughout the Plugin for error messages, alerts, and notes.</li><li>Perform a 'Find and Replace' with 'Match Case' checked, and replace all instances of '`swpframework`' with the new **name** of your Plugin.</li></ul>
1. Rename the file names below with your new **`file/function`** name.<BR><ul><li>`swpframework.php` --> **`file/function`**.php</li><li>`swpframework_farbtastic.js` --> **`file/function`**_farbtastic.js</li></ul>
1. Icons: the '`/swpframework/images`' directory contains four '`icon`' folders that occupy about 13MB of space.  We recommend that you move all the icons used in your Plugin from these folders to the '`/swpframework/images`' directory. Then remove the `icon.html` file, and all the `icon` folders that are in the `images` directory.  They have been placed there for your reference, and SWP Framework does not use them.  
1. Upload the '`swpframework`' folder to the '`/wp-content/plugins/`' directory
1. Rename the directory of this Plugin from '`swpframework`' to your new **`file/function name`**.
1. Activate the Plugin through the 'Plugins' menu in WordPress


Make sure you change the *VERSION NUMBER* every time you make changes to the Plugin.

== Frequently Asked Questions ==

= Can I help you develop this framework/Plugin? =

Yes, at this point, we are open to anyone with experience who can provide us with assistance in making this Plugin better.  Just [send](http://www.swpframework.com/contact) me a message.

= How to ask a question? =

Click [here](http://www.swpframework.com/contact) and ask me a question.

= Why is the FAQ empty? =

We just released the website, and I haven't received any questions.  Please [send](http://www.swpframework.com/contact) me all the questions you want and I may post them on the FAQ.


== Screenshots ==

There are currently no screenshots.


== Changelog ==

= Beta 0.9.1 =
* The previous release was full of unresolved issues, so many that we decided not to write them down.  This release is now stable, and the only thing that really needs work is the documentation.  I will continue working on documenting all aspects discussed in this file throughout the week, and will have a fully documented version of the Plugin by November 15, 2009.

= Beta 0.9.0 =
* First Release, it is in Beta, and should be available as version 1.0.0 on November 1st, 2009.  Please do not rate this Plugin, since  
it's just in the beginning stages of its release.  I would appreciate as much help as possible, even if it's an e-mail telling me  
about a spelling mistake, grammatical error, description change or even a change in the code.  This is a simple program, and it was  
intentionally design without PHP Class structures for both beginner and advanced programmers who simply want to create something quickly.



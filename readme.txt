=== 2MB Autocode ===
Contributors: lilmike, stormdragon2976
Donate link: https://2mb.solutions/donate
Tags: autocode, code placement, automatic, php, html, preformatted text, top, bottom, modify posts
Requires at least: 3.0
Tested up to: 5.6
Stable tag: 1.2.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to place predetermined text/html/php at the top or bottom of posts.

== Description ==

This plugin, developed by [2MB Solutions](https://2mb.solutions/), allows you to place predetermined text/html/php at the top and/or bottom of each post. In addition, you can override the placing of text at the bottom and/or top of a specific post, override the placing of text on the homepage or on a post individually, or run arbitrary php inside a post.

For more on 2MB, please visit (https://2mb.solutions/).

Note that all development now takes place at [github](https://github.com/2mb-solutions/autocode/).

== Installation ==

Installation is extremely simple!

1. Visit your wordpress dashboard and click add new under plugins.
1. Either search for 2MB Autocode and find it in the repository then click install and confirm that you want to, or upload a downloaded zip file then click install.
1. It should install.

That's it! Now you can enjoy your 2MB goodness!

Feel free to mess around with the settings under settings > Autocode.


== Frequently Asked Questions ==

= How do I remove the text from a specific post! HELP! =

There are now options on each post's edit page to force remove, force add, or do neither to the text on the top and bottom of either home or post pages. The text below is still valid, however the settings just mentioned will override the tags below if set to anything except do nothing.

Simply put ##no_top## or ##no_bottom## anywhere in the post, and it will remove those tags, and not put the text on bottom or top depending on which tag(s) you entered. In addition, if you put ##no_top_home##, ##no_bottom_home##, ##no_top_post##, or ##no_bottom_post##, it will remove the text from either the top or bottom of either the post page or the homepage, no matter what is set in the settings.

= How do I suggest a feature or new plugin? =

We're glad you asked! We're always looking for new ways to improve, whether in the realm of new plugins, or upgrading existing ones. Please go to our [website](https://2mb.solutions/), and click contact us. There you will be able to email us a message. Rest assured we read every email we receive and strive to respond to as many as possible!

= How do I run php inside a post? =

Simply enclose the php you want to run inside [php and ]/php] tags.

For example, to echo hello world in the middle of a post, do the following:

[php] echo("hello world!");[/php]

= How do I make the text go on the homepage without setting the checkbox! =

There is now an options panel on each post, so you can force text on the home page, force text to not be on the homepage, or defer to the main settings. The text below is still valid, but when set to anything except do nothing, the options on the post editor will override these tags.

Simply put  ##do_top_home## or ##do_bottom_home## anywhere in the post.

= My blog is broken and just shows the white screen of death after upgrading to 1.1 or 1.1.1! help! =

Do not worry, the fix is a simple one:

1. Delete or move the inline php plugin folder on your server, and the blog should be accessible again.
1. Now upgrade to 2mb autocode version 1.1.2, which fixes this particular issue.
1. Optional but highly recommended: Replace all [exec] or <exec> tags with [php] tags to allow 2mb autocode to do the php for you, and you will have no need for inline php.

= Why isn't any development taking place at wordpress.org? =

We have now moved our official development version to [github](https://github.com/2mb-solutions/autocode/). Feel free to test the code if you wish, and/or open issues over there although any issues or problems reported on the wordpress.org forums will also be dealt with.

= The white screen of death appears after upgrading to 1.2.4! Help! =

Note this only happens on the admin, so if this happens:

1. Use ftp (or any other method of your choice) to move the wp-content/plugins/2mb-autocode folder to a new name, for example 2mb-autocode.old
1. Reinstall or upgrade 2mb-autocode to 1.2.5.
1. This should fix your problem, at which point you can delete the 2mb-autocode.old folder, or if you upgraded it, move it back to 2mb-autocde

Note that no settings will be lost in this transition.

== Screenshots ==

No screen shots at the moment. Sorry!

== Changelog ==
= 1.2.5 =

* fixed missing file in freemius.

= 1.2.4 =

* updated freemius
* Added ample comments :-).

= 1.2.3 =

* added freemius integration, and hopefully made the text at the bottom of posts come before any widgets.

= 1.2.2 =

* Documentation updates.

= 1.2.1 =

*Fixed a bug allowing post data to echo twice if using ##do_top## or ##do_bottom##.

= 1.2 =

*Added an options panel on the post editor so you can now set custom post overrides without having to insert tags such as ##do_post_home##.
*Fixed a nasty bug in which text on each post's single page was suppressed when the home checkbox was unchecked. Whoops?

= 1.1.2 =

*Very important! If you were using inline php to put php on your blog before, please upgrade to this version or uninstall inline php before upgrading to 2mb autocode 1.1. There was a problem that caused the two plugins to conflict, which has now been solved. *** NOTE *** if your blog is not accessible due to the conflict, do the following: Delete the inline php folder from your server, and all should be well. We're sorry for any inconvenience -- sometimes even plugin developers can screw up ;-).

= 1.1.1 =

*Added documentation to the plugin itself.
*Added ##do_top_home## and ##do_bottom_home## to put text on the top or bottom of a post on the homepage even if the checkbox in settings is unchecked.

= 1.1 =

*Added ##do_top## and  ##do_bottom## to place the bottom or top text anywhere in a post.
*Added ##no_top_home##, ##no_bottom_home##, ##no_top_post##, and ##no_bottom_post## to override the placing of text specifically on the home or post pages.
*Added [php] PHP CODE HERE [/php] to run php inside a post.
*Very important! Fixed an issue where php at the top or bottom of posts would not run, and could possibly crash programs or make them not work correctly.
*Fixed a possible bug where php code in the top or bottom of the post may have been echoing to the wrong part of the screen.

= 1.0 =

*First release. woohoo!

== Upgrade Notice ==

= 1.2.5 =

Please upgrade to this version as soon as possible, as 1.2.4 broke the admin dashboard. If you can't get into your dashboard, see the FAQ for help.

= 1.2.1 =

This is a bug fix release. If you use ##do_top## or ##do_bottom##, this is for you.

= 1.2 =

You can now override text placement on a per-post basis in the editor, instead of having to use special tags. Also if your text was not showing on each post when the home checkbox was unchecked, this fixes that issue.

= 1.1.2 =

If you use inline php to do your php inside posts:

*You don't need to anymore, as this plugin will handle it for you.
*Please update to this version or uninstall the inline php plugin because the two plugins conflict. This has now been fixed.
*If your blog is totally broken and you cannot access the admin panel to remove the plugin inline php, then simply delete the inline php plugin folder from your server, and the problem will be solved. Sorry for any inconvenience (even coding ninjas are durps sometimes too, ;-))

= 1.1.1 =

* If you didn't know how to use the plugin... this update is for you. This update adds documentation inside the plugin, as well as adds ##do_top_home## and ##do_bottom_home## to force displaying the text on a per-post basis on the homepage, no matter what the checkbox says in the options pannel.

= 1.1 =

*If you were using php at the top or bottom of a post, please upgrade to this version as this fixes a possibility that the php code would not run or the php may have echoed to the wrong part of the screen. In addition if you want to run php code in your posts without having to add it to every post, then you may like this release. Also, if you wish to turn off the placing of text on a per post basis for the home and/or single post pages, this update is for you.

= 1.0 =

* Because this plugin is awesome! Seriously, go try it! ;-)

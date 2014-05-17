=== WP Post Encode ===
Contributors: dbmartin
Tags: encode, encoding, markup, posts, pages, 
Requires at least: 2.7.1
Tested up to: 3.8
Stable tag: 1.5
License: GPLv2

Easily include raw code in posts. 

== Description ==

Easily include raw markup languages (HTML, CSS, PHP, etc.) in posts using custom quicktags.  No need to encode, the filter does it
for you.  Creates convenient "encode" buttons for post authors in the HTML editor.

== Installation ==

1. Upload the `wp-post-encode` folder to the your plugins directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.


== Frequently Asked Questions ==

= Does it work using the Visual Editor? =

No, since this plugin uses custom quicktags it's recommended to use the HTML editor.

= Do you provide support for the plugin? =

Yes!  Just drop a line on the plugin site in the comments section.

== Changelog ==
= 1.5 =
* encapsulate code within `dbdbPostEncode()` Class
* updated quicktags to work with the new [Quicktag API](https://codex.wordpress.org/Quicktags_API)

== Upgrade Notice ==
Fixes issues with buttons not appearing on the Text Editor
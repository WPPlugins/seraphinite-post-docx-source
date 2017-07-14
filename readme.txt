=== Seraphinite Post .DOCX Source ===
Contributors: seraphinitesoft
Donate link: https://www.s-sols.com/about
Tags: word to wordpress, docx, ms word, html, hyperlinks, url, post, page, source, all in one seo, search engine optimization, tags, keywords, seo title, seo description
Requires at least: 3.5
Tested up to: 4.7
Stable tag: 1.1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows using marked up .DOCX documents as a source for SEO oriented web content instead of manual copy.

== Description ==

It converts .DOCX documents (e.g. created by Microsoft Word) to the post content including title, body, hyperlinks, tags, SEO title and description. This plugin works with .DOCX documents that are formatted using standard styles. It appears as [the special meta-box](http://wordpress.org/plugins/seraphinite-post-docx-source/screenshots) named ".DOCX Source" under main editor. [Learn more...](https://www.seraphinitesoft.com/products/wordpress/post-docx-source)

**Advantages**

*	**Hyperlinks checking**
	*	Checks internal links for existence and marks or deletes them.
	*	Converts links to another .DOCX documents to site links.
*	**Attributes setting**
	*	Uses document header as post title.
	*	Uses document title and comments as SEO title and description.
	*	Uses document tags as post tags.
	*	Uses document categories as post categories.
	*	Uses document additional contents marked by header for other text blocks.
	*	Ignores colored search keywords.
*	**Right media URLs generating**
	*	Corrects image URLs according to upload or featured image directory.
	*	Uses original media filenames.
	*	Uploads embedded images.
	*	Warns about non-existent media URLs.
*	**Final document markup using**
	*	Works with reviewing documents and always uses final markup content.
*	**Compatible with most popular SEO plugins**
	*	Works with the most of custom upload directory plugins.
	*	Uses "All in One SEO Pack" and "CKEditor" plugins.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. [The special meta box](http://wordpress.org/plugins/seraphinite-post-docx-source/screenshots) named ".DOCX Source" should be appeared under main content editor area while editing a post or page. If you can't see the one,
ensure that it's selected in the "Screen Options" at top right corner of the page.

== Screenshots ==

1. The plugin meta box for posts.

== Changelog ==

= 1.1.4 =

Fixes:

* Plugin initialize error at lower versions of PHP

= 1.1.3 =

Fixes:

* Some type of hyperlinks are not processed correctly
* Associated images with external URL aren't left as is

= 1.1.2 =

Fixes:

* Sub categories are supported

= 1.1.1 =

Fixes:

* Paragraphs in list items are not always included
* Doesn't use image floating attributes

= 1.1.0 =

Improvements:

* Support document additional contents marked by header for other text blocks
* Support product post types
* Support categories

Fixes:

* Paragraphs in list items are not always included
* Unneeded space is included after text is inserted
* Check final URLs always 'on'

= 1.0.2 =

Improvements:

* Check media final URLs
* One log event for one not existing hyperlink
* Check local hashtags
* Scroll to meta-box back after update
* JS size minimized

Fixes:

* Progress ends before whole process finishes
* Inner single content in list item looses line break
* Not first Header1 is used

= 1.0.1 =

Improvements:

* Paragraphs in list items are supported
* Post image path is generated from featured image or from upload directory
* Embeded document media upload supported
* New post upload media warning
* Dynamic standart progress indicator

Fixes:

* DOCX hyperlink path
* Media URL base

= 1.0.0 =

* Initial release

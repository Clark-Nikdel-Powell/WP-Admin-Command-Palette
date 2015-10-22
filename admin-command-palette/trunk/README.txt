=== Admin Command Palette ===
Contributors: gwelser, samueljmello, jhned
Donate link: http://clarknikdelpowell.com/pay/
Tags: admin, search, navigation, actions, ux, admin search, admin navigation, admin actions
Requires at least: 3.0.1
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Optimize WordPress admin navigation with a modal window to search for and navigate directly to WordPress admin pages.

== Description ==

The Admin Command Palette (ACP) is a modal window in the WordPress Admin that live searches admin content, which saves you many clicks and page loads. You can:

* Search for and navigate to user-generated content (Posts, Pages, Users, etc.).
* Search for and navigate to WordPress Admin Pages (All Posts, Add New Post, etc.).
* Perform WordPress Admin actions via the ACP or a keyboard shortcut (Publish, Add Media, View Post, etc.).

This plugin brings about a new level of efficiency to WordPress admin user interactions: it's like the difference between going over a mountain via a pass, versus going through a mountain via a tunnel. The tunnel is always more direct, more efficient, and more straightforward than the pass.

== Installation ==

1. Upload `admin-command-palette` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Use the keyboard shortcut "shift+shift" to activate the search modal window.
1. See Frequently Asked Questions for further setup instructions.

== Frequently Asked Questions ==

= Settings =

You can customize the plugin settings on the Admin Command Palette settings page in the WordPress Admin. (*Settings -> Admin Command Palette*)

* **Threshold** (*Default: .3*): this determines how closely a search query must match in order to return an item as a result. 0.0 must be a perfect match, 1.0 will match anything.
* **Max Results per Section** (*Default: 5*): a max number of results per content type.
* **Group Results by Type**: Results can be displayed one of two ways. The default is to display results in a flat list, ordered by closest match. Selecting this option displays results grouped by their content type, e.g., all the posts, pages, tags, categories, etc. will be grouped under individual subheadings.
* **Excluded Post Types** (*Default: Media, Revisions, Navigation Menu Items*): Select post types from this checkbox group to exclude them from the search. All registered post types are included in this list.
* **Excluded Taxonomies** (*Default: Navigation Menus, Link Catgeories, Format*): Select taxonomies from this checkbox group to exclude them from the search. All registered taxonomies are included in this list.
* **Clear Content Cache**: The data for this plugin is generated and loaded into the page from a cache that gets automatically cleared whenever new content is added. You can use this button to clear the cache manually.

= How does the search determine a match? =

The live search compares the search term against titles, e.g., a post title, an admin page title, or an admin action title, using the [Fuse.js library](https://github.com/krisk/Fuse) to find results.

= Keyboard Shortcuts =

The ACP comes with some built-in keyboard shortcuts to make actions in the WordPress admin easier. You do not need to open the ACP in order to use the shortcuts.

* **␛** - Clear input focus
* **⇧+s** - Primary button click
* **⇧+p** - Preview
* **⇧+t** - Trash
* **⇧+v** - Open Post/Page in New Tab
* **⇧+n** - Add New Post/Page
* **⇧+f** - Set Featured Image
* **→** - Pagination: next page
* **←** - Pagination: previous page
* **⇧+→** - Pagination: last page
* **⇧+←** - Pagination: first page

== Screenshots ==

1. The Admin Command Palette in action.
2. The Admin Command Palette settings page.

== Upgrade Notice ==

= 1.0.1 =
Addressing spelling errors.

== Changelog ==

= 1.0.1 =
Spelling fixes.

= 1.0 =
Initial version.

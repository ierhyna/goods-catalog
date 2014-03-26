=== Goods Catalog ===
Contributors: oriolo
Tags: catalog, catalogue, product, products, goods, product catalog, product catalogue, catalog of goods
Stable tag: v0.5.4
Requires at least: 3.3.0
Tested up to: 3.8.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin creates simple catalog of goods, looking like Explorer in Windows.

== Description ==
The plugin creates simple catalog of goods, looking like Explorer in Windows. The main page of catalog is http://yoursite.com/catalog/. At the main page are located all parent categories of goods. At the category page firstly are located subcategories and then products of the category.

* Use thumbnails to add images for products;
* You can use Taxonomy Images plugin (https://wordpress.org/plugins/taxonomy-images/) to add images for categories of products;

You can also use special sidebar for the catalog, to show different widgets on the catalog and the other pages.

Languages:

* English
* Russian

== Installation ==

* Download plugin in .zip archive and install in Console.
* Activate the plugin.
* Then you need to update your permalinks to prevent 404 errors. Just go to Console -> Settings -> Permalinks and press "Save". You don't need to change your permalinks.

== Screenshots ==
1. Main page of catalog
2. Page of category with subcategories and products
3. Singe product page
4. Admin page

== Frequently Asked Questions ==
= There is 404 on /catalog or products page =
You need to update your permalinks. Just go to Console -> Settings -> Permalinks and press "Save". You don't need to change it.

== Changelog ==

= v0.5.4 =

* Updated layot, fixed bug with missing background in some themes
* Created loop-grid.php
* Updated options page: added checkboxes to set where to display SKU and description
* Updated options page: added checkbox to disable thumbnail for the categories if you do not need them
* Updated translation and POT-file

= v0.5.2 =

* Fixed loop in the empty categories
* Updated css

= v0.5.1 =

* Fixed bug on single product page: http://wordpress.org/support/topic/sidebar-85?replies=6#post-5368763

= v0.5 =

* Added sidebar
* Created two widgets: categories list, tags cloud
* Updated .POT file and Russian translation

= v0.4.7 =

* Added options that allow to set width of catalog
* Added POT file

= v0.4.6 =

* Localization bug fixed

= v0.4.5 =

* Added tags
* Added columns with tags and categories to admin menu
* Menu item 'Plugin Settings' moved to 'Goods'
* Added SKU field for products
* Updated single product page template
* Style for plugin loads only on plugin pages

= v0.4 =

* Bugs fixed
* Updated readme.txt

= v0.3-beta.2 =

Small bug fix:

* Fixed missed menu in category page

= v0.3-beta.1 =

* Fixed pagination

= v0.3-beta =

* Added Plugin Settings page
* Change products per page
* Show categories images if plugin Taxonomy Images not installed

= v0.2-beta.1 =

* removed displaying of PHP errors

= v0.2-beta =

First public release

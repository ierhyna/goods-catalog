=== Goods Catalog ===
Contributors: oriolo
Tags: goods catalog, products catalog, catalog, products, goods
Stable tag: trunk
Requires at least: 3.3.0
Tested up to: 4.2.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: http://oriolo.ru/dev/goods-catalog/donate

Goods Catalog provides a catalog of products organized into categories. It is easy to use and fully customizable.

== Description ==

Goods Catalog was created to help you organize a simple catalog of products on WordPress site.

= Main features =

* Unlimited categories of products with unlimited depth of subcategories
* Tumbnails for categories and products
* The separate sidebar for the catalog, to show different widgets on the catalog and other pages.
* Shortcodes
* Widgets

The catalog created with Goods Catalog is easy to navigate: at the main catalog page are located all parent categories of products, at the category page firstly are located subcategories and then products of the category.

= Shortcodes =

* Use shortcode [goods_newest] to display the newest products anywhere in the site: on post or page. For example, to show 6 products, type: [goods_newest number=6]
* [goods_categories] to display the list of goods categories (many thanks to Alexander Chizhov & Pineapple Design Studio)
* [goods_tags] to display list of all products' tags
* [goods_sitemap] to display sitemap of the catalog (testing mode)
* [goods_term] to display category or tag by ID. Usage: [goods_term goods_category|goods_tag id=X], ex.: [goods_term goods_category id=3] to display category with ID=3, or [goods_term goods_tag id=5] to display tag with ID=5. It only displays title with link and description, without image.

= Languages =

Goods Catalog is ready for localization to your language. Now it is available in the following languages:

* English
* Russian
* Spanish (thanks to netsis)
* French (thanks to Bertrand)
* Italian (thanks to Massimo Gallarotti)

You can send me translation for your language, and I'll add it to the release.

= Get involved =

You can contribute code and localizations to this plugin via [GitHub](https://github.com/ierhyna/goods-catalog)

== Installation ==

= Install the Goods Catalog Plugin =

The easiest way to install Goods Catalog plugin is the automatic installation:

* From WordPress admin panel, navigate to the `Plugins` menu and click `Add New`,
* In the search field type `"Goods Catalog"` and click `Search Plugins`. Found Goods Catalog plugin in the list.
* Click `Install Now`.

Or you can install the plugin manually:

* Download the plugin in `.zip` archive.
* Upload unzipped `goods-catalog` folder to the `/wp-content/plugins/` directory.

After the installation, please activate the plugin through the `Plugins` menu in WordPress.

= Install the dependencies =

Please install [Taxonomy Images plugin](https://wordpress.org/plugins/taxonomy-images/), that provides thumbnails for categories.

= Basic configuration =

After you have the Goods Catalog installed, you need to flush the permalinks to prevent 404 errors. Just go to `Settings -> Permalinks` and press "Save". You don't need to change your permalinks.

== Screenshots ==

1. Main page of catalog
2. Page of category with subcategories and products
3. Singe product page
4. Admin page

== Frequently Asked Questions ==

= There is 404 on /catalog or products page =
You need to update your permalinks. Just go to `Settings -> Permalinks` and press "Save". You don't need to change it.

= There are no thumbnails for the categories =
Please use [Taxonomy Images plugin](https://wordpress.org/plugins/taxonomy-images/) to attach image to category, and than turn on "Show Thumbnails for categories" option in Gooods Catalog plugin settings.

= Can I use sidebar in the catalog pages? =
Sure! There is special sidebar for the catalog. All widgets you put in there will be available only for catalog pages. Please, set up the sidebar in the plugin settings.

= How can I translate Goods Catalog to my language? =
Please use one of translation tools, [listed in the Codex](http://codex.wordpress.org/Translating_WordPress#Translation_Tools) to open .POT file and create your own translation. You can put your .PO and .MO files into `/wp-content/languages/plugins/` and you will not loose the translations after plugin update.
Also, you can send me your language files and I'll add them to the release.

= How to customize title meta tag on catalog or category page? =
The simpliest way is to use some SEO plugins that allow to customize titles: ex., [WordPress SEO by Yoast](https://wordpress.org/plugins/wordpress-seo/) or [All in One SEO Pack](https://wordpress.org/plugins/all-in-one-seo-pack/).

Or you can manually change your theme's header.php (see [here](http://wordpress.stackexchange.com/questions/130747/custom-post-type-archive-page-title)). 

Another option is to change the plugin files see the discussion [here](https://wordpress.org/support/topic/how-to-modify-the-catalog-title-page). It is not recommended: you will lose the changes after the plugin update.

== Changelog ==

= 0.9.4 =

* Shortcodes bug fix
* Settings page improved
* New shortcode [goods_term goods_category id="3"]

= 0.9.3 =

* Thumbnails bug fix

= 0.9.2 =

* New feature: Customizable templates. Just copy and paste the template for main catalog page, category, tags, or single product to your theme's directory to change it (and not to lose changes with plugin update)
* Breadcrumbs bug fix (no previous category in chain)
* CSS improvements

= 0.9.1 =

* Fixed bug with no featured image box in some themes, [issue #33](https://github.com/ierhyna/goods-catalog/issues/33)

= 0.9.0 =

* Wigdet GC Categories: now you can hide or show count of products in one click
* Fixed thumbnails bug in shortcode [goods_newest]
* Improved shortcodes
* Improved the matabox
* Improved files structure
* Improved functions to show product price, SKU, and short description
* Improved function of thumbnail size
* Added template's wrapper
* Updated Italian translation

= 0.8 =

* New feature: added prefix and postfix for the product price. Now you can add the currency easily
* Updated shortcode [goods_newest]
* Updated POT file
* Updated translation to the Russian language

= 0.7 =

* Updated breadcrumbs function. The last breadcrumb is not a link now. Bug fixes: [issue #27](https://github.com/ierhyna/goods-catalog/issues/27) 
* Removed function get_goods_taxomonies(). Using WordPress core function get_the_term_list() instead
* Minor bug fixes: templates and shortcodes 

= 0.6.9 =

* Fixed metabox bug

= 0.6.8 =

* Added Italian language support (thanks to Massimo Gallarotti)
* Fixeg Metabox translation bug (again, thanks to Massimo Gallarotti :)

= 0.6.7 =

* New shortcode: [goods_tags] to display list of all products' tags
* New shortcode: [goods_sitemap] to display sitemap of the catalog (testing mode)
* Improved shortcode: [goods_categories] 

= 0.6.6 =

* Shortcodes bug fix

= 0.6.5 =

* Added French language support

= 0.6.4 =

* Minor bug fix (breadcrumbs)

= 0.6.3 =

* Added Spanish language (thanks to netsis)
* Added shortcode [goods_categories] to display the list of goods categories (many thanks to Alexander Chizhov & Pineapple Design Studio)

= 0.6.2 =

* Added shortcode [goods_newest]

= 0.6.1 =

* Fixed breadcrumbs on single page
* Fixed path to the catelog in plugin settings page

= 0.6 =

* Fixed breadcrumbs 404 bug for default permalinks structure (?p=123), thanks Lili's bugreport
* Updated breadcrumbs
* Fixed conflict bug with other catalog plugins, thanks Roman's bugreport
* Fixed translation to Russian, updated POT-file
* Now you can put your language files into /wp-content/languages/plugins
* Updated settings page: added changeable prefixes for catalog, category and tag pages (thanks Leon for the idea)
* Updated settings page: added changeable thumbnail size (thanks kreker92 for the idea)
* Changed internal structure of the plugin

= 0.5.4 =

* Updated layot, fixed bug with missing background in some themes
* Created loop-grid.php
* Updated options page: added checkboxes to set where to display SKU and description
* Updated options page: added checkbox to disable thumbnail for the categories if you do not need them
* Updated translation and POT-file

= 0.5.2 =

* Fixed loop in the empty categories
* Updated css

= 0.5.1 =

* Fixed bug on single product page: http://wordpress.org/support/topic/sidebar-85?replies=6#post-5368763

= 0.5 =

* Added sidebar
* Created two widgets: categories list, tags cloud
* Updated .POT file and Russian translation

= 0.4.7 =

* Added options that allow to set width of catalog
* Added POT file

= 0.4.6 =

* Localization bug fixed

= 0.4.5 =

* Added tags
* Added columns with tags and categories to admin menu
* Menu item 'Plugin Settings' moved to 'Goods'
* Added SKU field for products
* Updated single product page template
* Style for plugin loads only on plugin pages

= 0.4 =

* Bugs fixed
* Updated readme.txt

= 0.3-beta.2 =

Small bug fix:

* Fixed missed menu in category page

= 0.3-beta.1 =

* Fixed pagination

= 0.3-beta =

* Added Plugin Settings page
* Change products per page
* Show categories images if plugin Taxonomy Images not installed

= 0.2-beta.1 =

* removed displaying of PHP errors

= 0.2-beta =

First public release

== Upgrade Notice ==

= 0.9.3 =

Thumbnails bug fix

= 0.9.2 =

Breadcrumbs bug fix. New feature: customizable templates

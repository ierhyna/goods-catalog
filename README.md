# Goods Catalog

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/f1f22c2889cf4e16971e93b16e4b5260)](https://www.codacy.com/app/ierhyna/goods-catalog?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ierhyna/goods-catalog&amp;utm_campaign=Badge_Grade) [![Build Status](https://travis-ci.org/ierhyna/goods-catalog.svg?branch=dev)](https://travis-ci.org/ierhyna/goods-catalog)

Goods Catalog provides a catalog of products organized into categories. It is easy to use and fully customizable. Goods Catalog was created to help you organize a simple catalog of products on WordPress site.

## Main features

* Unlimited categories of products with unlimited depth of subcategories
* Tumbnails for categories and products
* The separate sidebar for the catalog, to show different widgets on the catalog and other pages.
* Shortcodes
* Widgets

The catalog created with Goods Catalog is easy to navigate: at the main catalog page are located all parent categories of products, at the category page firstly are located subcategories and then products of the category.

### Shortcodes

* Use shortcode [goods_newest] to display the newest products anywhere in the site: on post or page. For example, to show 6 products, type: [goods_newest number=6]
* [goods_categories] to display the list of goods categories (many thanks to Alexander Chizhov & Pineapple Design Studio)
* [goods_tags] to display list of all products' tags
* [goods_sitemap] to display sitemap of the catalog (testing mode). Usage: [goods_sitemap include_category=55,54 orderby=include]
* [goods_term] to display category or tag by ID. Usage: [goods_term goods_category|goods_tag id=X], ex.: [goods_term goods_category id=3] to display category with ID=3, or [goods_term goods_tag id=5] to display tag with ID=5. It only displays title with link and description, without image.

### Languages

Goods Catalog is ready for localization to your language. Now it is available in the following languages:

* English
* Russian
* Spanish (thanks to netsis)
* French (thanks to Bertrand)
* Italian (thanks to Massimo Gallarotti)

You can send me translation for your language, and I'll add it to the release.

## Installation

### Install the Goods Catalog Plugin

The easiest way to install Goods Catalog plugin is the automatic installation:

* From WordPress admin panel, navigate to the `Plugins` menu and click `Add New`,
* In the search field type `"Goods Catalog"` and click `Search Plugins`. Found Goods Catalog plugin in the list.
* Click `Install Now`.

Or you can install the plugin manually:

* Download the plugin in `.zip` archive.
* Upload unzipped `goods-catalog` folder to the `/wp-content/plugins/` directory.

After the installation, please activate the plugin through the `Plugins` menu in WordPress.

### Install the dependencies

Please install [Taxonomy Images plugin](https://wordpress.org/plugins/taxonomy-images/), that provides thumbnails for categories.

### Basic configuration

After you have the Goods Catalog installed, you need to flush the permalinks to prevent 404 errors. Just go to `Settings -> Permalinks` and press "Save". You don't need to change your permalinks.

## Frequently Asked Questions

### There is 404 on /catalog or products page
You need to update your permalinks. Just go to `Settings -> Permalinks` and press "Save". You don't need to change it.

### There are no thumbnails for the categories
Please use [Taxonomy Images plugin](https://wordpress.org/plugins/taxonomy-images/) to attach image to category, and than turn on "Show Thumbnails for categories" option in Gooods Catalog plugin settings.

### Can I use sidebar in the catalog pages?
Sure! There is special sidebar for the catalog. All widgets you put in there will be available only for catalog pages. Please, set up the sidebar in the plugin settings.

### How can I translate Goods Catalog to my language?
Please use one of translation tools, [listed in the Codex](http://codex.wordpress.org/Translating_WordPress#Translation_Tools) to open .POT file and create your own translation. You can put your .PO and .MO files into `/wp-content/languages/plugins/` and you will not loose the translations after plugin update.
Also, you can send me your language files and I'll add them to the release.

### How to customize title meta tag on catalog or category page?
The simpliest way is to use some SEO plugins that allow to customize titles: ex., [WordPress SEO by Yoast](https://wordpress.org/plugins/wordpress-seo/) or [All in One SEO Pack](https://wordpress.org/plugins/all-in-one-seo-pack/).

Or you can manually change your theme's header.php (see [here](http://wordpress.stackexchange.com/questions/130747/custom-post-type-archive-page-title)). 

Another option is to change the plugin files see the discussion [here](https://wordpress.org/support/topic/how-to-modify-the-catalog-title-page). It is not recommended: you will lose the changes after the plugin update.

### How can I enable or disable the comments for catalog entries?
Since the version 1.0.0 comments comments are enabled by default. You can disable them globally in WordPress Admin settings (at Discussion tab), or you can use third-part plugins to make comments available only for some post types, for example [Disable Comments Plugin](https://wordpress.org/plugins/disable-comments/).

### How can I separate comments to products and posts in the Admin Panel?
You can use my plugin [Comments by Post Type](https://wordpress.org/plugins/comments-by-post-type/) for that.

## Changelog

Please find the changelog [here](https://github.com/ierhyna/goods-catalog/blob/master/CHANGELOG.md).

## Other Info

You can contribute code and localizations to this plugin via [GitHub](https://github.com/ierhyna/goods-catalog)

License: [GNU General Public License v3](http://www.gnu.org/licenses/gpl-3.0.html)

Donate link: http://oriolo.ru/dev/goods-catalog/donate

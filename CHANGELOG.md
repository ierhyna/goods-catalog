# Goods Catalog

## Changelog

### 2.2.0

* Add a optional attribute include_category, exclude_category. [goods_sitemap include_category=55,54 orderby=include]

### 2.1.0

* Fix get_the_product_price() $title argument (https://github.com/ierhyna/goods-catalog/issues/56)

### 2.0.0

* New template system

### 1.0.0

* New feature: Comments

### 0.10.0

* New feature: sorting the products

### 0.9.4

* Shortcodes bug fix
* Settings page improved
* New shortcode [goods_term goods_category id="3"]

### 0.9.3

* Thumbnails bug fix

### 0.9.2

* New feature: Customizable templates. Just copy and paste the template for main catalog page, category, tags, or single product to your theme's directory to change it (and not to lose changes with plugin update)
* Breadcrumbs bug fix (no previous category in chain)
* CSS improvements

### 0.9.1

* Fixed bug with no featured image box in some themes, [issue #33](https://github.com/ierhyna/goods-catalog/issues/33)

### 0.9.0

* Wigdet GC Categories: now you can hide or show count of products in one click
* Fixed thumbnails bug in shortcode [goods_newest]
* Improved shortcodes
* Improved the matabox
* Improved files structure
* Improved functions to show product price, SKU, and short description
* Improved function of thumbnail size
* Added template's wrapper
* Updated Italian translation

### 0.8

* New feature: added prefix and postfix for the product price. Now you can add the currency easily
* Updated shortcode [goods_newest]
* Updated POT file
* Updated translation to the Russian language

### 0.7

* Updated breadcrumbs function. The last breadcrumb is not a link now. Bug fixes: [issue #27](https://github.com/ierhyna/goods-catalog/issues/27)
* Removed function get_goods_taxomonies(). Using WordPress core function get_the_term_list() instead
* Minor bug fixes: templates and shortcodes

### 0.6.9

* Fixed metabox bug

### 0.6.8

* Added Italian language support (thanks to Massimo Gallarotti)
* Fixeg Metabox translation bug (again, thanks to Massimo Gallarotti :)

### 0.6.7

* New shortcode: [goods_tags] to display list of all products' tags
* New shortcode: [goods_sitemap] to display sitemap of the catalog (testing mode)
* Improved shortcode: [goods_categories]

### 0.6.6

* Shortcodes bug fix

### 0.6.5

* Added French language support

### 0.6.4

* Minor bug fix (breadcrumbs)

### 0.6.3

* Added Spanish language (thanks to netsis)
* Added shortcode [goods_categories] to display the list of goods categories (many thanks to Alexander Chizhov & Pineapple Design Studio)

### 0.6.2

* Added shortcode [goods_newest]

### 0.6.1

* Fixed breadcrumbs on single page
* Fixed path to the catelog in plugin settings page

### 0.6

* Fixed breadcrumbs 404 bug for default permalinks structure (?p=123), thanks Lili's bugreport
* Updated breadcrumbs
* Fixed conflict bug with other catalog plugins, thanks Roman's bugreport
* Fixed translation to Russian, updated POT-file
* Now you can put your language files into /wp-content/languages/plugins
* Updated settings page: added changeable prefixes for catalog, category and tag pages (thanks Leon for the idea)
* Updated settings page: added changeable thumbnail size (thanks kreker92 for the idea)
* Changed internal structure of the plugin

### 0.5.4

* Updated layot, fixed bug with missing background in some themes
* Created loop-grid.php
* Updated options page: added checkboxes to set where to display SKU and description
* Updated options page: added checkbox to disable thumbnail for the categories if you do not need them
* Updated translation and POT-file

### 0.5.2

* Fixed loop in the empty categories
* Updated css

### 0.5.1

* Fixed bug on single product page: http://wordpress.org/support/topic/sidebar-85?replies=6#post-5368763

### 0.5

* Added sidebar
* Created two widgets: categories list, tags cloud
* Updated .POT file and Russian translation

### 0.4.7

* Added options that allow to set width of catalog
* Added POT file

### 0.4.6

* Localization bug fixed

### 0.4.5

* Added tags
* Added columns with tags and categories to admin menu
* Menu item 'Plugin Settings' moved to 'Goods'
* Added SKU field for products
* Updated single product page template
* Style for plugin loads only on plugin pages

### 0.4

* Bugs fixed
* Updated readme.txt

### 0.3-beta.2

Small bug fix:

* Fixed missed menu in category page

### 0.3-beta.1

* Fixed pagination

### 0.3-beta

* Added Plugin Settings page
* Change products per page
* Show categories images if plugin Taxonomy Images not installed

### 0.2-beta.1

* removed displaying of PHP errors

### 0.2-beta

First public release
file:///home/irina/WP-Plugins/goods-catalog-dev/README.md

# Angular + WordPress sample theme

This is a simple Angular app to test WP-API Routs and some AngularJS functionality.

**Available Routs:**

* **Blog** - displays blog posts with featured images (if set) and pagination.
* **Posts by specific Authors** - displays all posts by the author (by default #1). Uses custom WP-API route.
* **All Post ID's** - gets all post ID's. Custom WP-API route

## Requirements
* Wordpress 4.3
* WP REST API plugin ([Version 2.0-beta4](https://github.com/WP-API/WP-API/archive/2.0-beta4.zip))
* AngularJS v1.4.4


## Installation

1. Clone the git repo
2. Make sure you have enabled permalinks in Wordpress. Set up permalinks to **Numberic**
3. Install and activate [WP REST API plugin](https://github.com/WP-API/WP-API/archive/2.0-beta4.zip)
4. Activate the theme

#### (Optional) Test Environment Setup
If this is a new WP install, you require some data:

1. Download the [theme test data](https://wpcom-themes.svn.automattic.com/demo/theme-unit-test-data.xml)
2. Import test data into your WordPress install by going to Tools => Import => WordPress
3. Select the XML file from your computer to import. 


## Configuration
Check functions.php for initial theme setup and constants.

####AngularApp

```/lib/angular-app/
        - /templates
        - angular-app.php
        - AuthorRoute.php
        - GetIdRoute.php
```
    
**/templates** - directory contains Angular template files

**angular-app.php** - starting point, used to include theme assets

**AuthorRoute.php, GetIdRoute.php** - files used to create custom WP-API routes

####Assets
All AngularJS files (routes, controllers, models):

```/assets/angular-app/```


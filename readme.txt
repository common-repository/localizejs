=== Localize - Website Translation Integration ===
Contributors: dereklocalize, kgblocalize, jonathanpeterwu
Tags: localize, localize.js, localizejs, translate, translations, localise, localization, localisation, l10n, i18n, language, switcher
Requires at least: 5.0
Tested up to: 6.3
Requires PHP: 8.0
Stable tag: 1.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Translate your WordPress site into multiple languages in minutes.

 == Instructions ==
1) Go to Localize to setup an account [Signup for a Free Trial](https://localizejs.com/signup)
2) Grab your Localize Project Key from the [projects](https://app.localizejs.com/project) page
3) Find the "Localize" plugin settings on the bottom left of your WordPress admin dashboard
4) Add your Project Key and save
5) Optionally select your SEO preference

== Description ==
Translate your WordPress site into multiple languages in minutes.

* Easily translate your site, no coding required
* Reach a global audience, faster
* Unlimited languages, unlimited collaborators, unlimited phrases
* Auto-detect the browser locale and translate the page
* Automatically identify new strings when page content changes
* Seamlessly order professional human translations
* Translation analytics
* Use advanced SEO techniques, allowing users to search in their own language

== Installation ==

= Minimum Requirements =
* WordPress 5.0
* PHP version 8.0
* MySQL version 5.7 or MariaDB version 10.2

= Automatic Installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t even need to leave your web browser. To do an automatic install of Localize, log in to your WordPress admin panel, navigate to the Plugins menu and click Add New.

In the search field type "Localizejs" and click Search Plugins. Once you’ve found the plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking Install Now. After clicking that link you will be asked if you’re sure you want to install the plugin. Click yes and WordPress will automatically complete the installation.

= Manual Installation =

The manual installation method involves downloading the plugin and uploading it to your webserver via your favorite FTP application.

1. Download the plugin file to your computer and unzip it
2. Using an FTP program, or your hosting control panel, upload the unzipped plugin folder to your WordPress installation’s wp-content/plugins/ directory.
3. Activate the plugin from the Plugins menu within the WordPress admin.

== Help Documentation ==

Our most up to date documentation can be found [here](https://help.localizejs.com/).

Note that there are more settings that you can change in your Localize Project, on the [Project Settings page](https://app.localizejs.com/settings/project/profile).

== Upgrade Notice ==

Any updates made to the library itself will be automatically reflected in the plugin. Any updates to the plugin can be found on our plugin homepage.

- [How do I approve new phrases?](https://help.localizejs.com/docs/approve-content-for-translation)
- [How do I use the default language widget?](https://help.localizejs.com/docs/widget-customization)
- [How do I order translations?](https://help.localizejs.com/docs/3rd-party-translation-providers)
- [What languages are supported?](https://help.localizejs.com/docs/supported-languages)
- [How to edit translations?](https://help.localizejs.com/docs/propose-and-edit-translations)
- [How do I optimize my website for search engines (SEO)?](https://help.localizejs.com/docs/seo-advanced)

== Screenshots ==

1. Localize Wordpress Settings Dashboard

![Localize Dashboard](https://global.localizecdn.com/uploads/1570719230926.png)

== Changelog ==
= 1.3.1 =
* Fix fatal error on upgrade and install.

= 1.3.0 = 
* Adds three new options for configuring your Localize installation.
1. allowInlineBreakTags
2. autoApprove
3. retranslateOnNewPhrases

= 1.2.8 =
* Block debug content from being ingested as phrases.

= 1.2.7 =
* Support version 6.2

= 1.2.6 =
* Fix issue where wp-content links get added language.

= 1.2.5 =
* Update branding.

= 1.2.4 =
* Fix CDN path.

= 1.2.3 =
* Gracefully fail when Localize service is not reachable.

= 1.2.2 =
* Do not add language subdirectory for wp-content paths.

= 1.2.1 =
* Fix issues with language tag in plain permalinks.
* Rewrite all links in page when using subdirectory SEO mode.
* Removed dependency on cURL

= 1.2.0 =
* Added support for language code in custom post types.
* Fixed subdirectories not loading correct language.
* Fixed source language only loading the home page on redirect.

= 1.1.5 =
* Fixed a bug which didn't allow the addition of new languages (after the plugin was already in use), by removing the cookie that saved the list of languages. Cookies are no longer used for anything. 
* Fixed a bug which didn't allow directly switching between target languages when using the subdirectories option.
* Refactored the code to make it easier to read and maintain.

= 1.1.4 =
* Fixed a bug so that anchor links now work when using subdirectories/subdomains.
* Fixed a bug when determining the source language of the project (only affected specific websites)
* Updated the plugin to remove any use of the PHP Session object, to eliminate possible performance problems. Cookies are used now instead.

= 1.1.3 =
* Added the option to use a different subdomain for each language, to improve SEO.
* Fixed a problem with permalinks not working when using the subdirectories option.
* Fixed a problem with subdirectories - the querystring parameters were being lost, causing problems with UTM parameters.

= 1.1.0 =
* Added the option to use a different subdirectory for each language, to improve SEO.

= 1.0.2 =
* Fixed typo in settings function name

= 1.0.1 =
* Official release with custom settings icon

= 1.0.0 =
* Official release

= 0.9 =
* Beta release.

# Open Graph Plugin
A simple Joomla 2.5/ 3.x plugin that automatically implements the Open Graph protocol on your Joomla! website.

## Usage
Automatically adds the following basic metadata, from the indicated sources, when the viewing pages of the following menu item types:

** Homepage (default menu item) **
* `og:url:` the URL of the default menu item
* `og:type: website`
* `og:site_name:` the global configuration sitename
* `og:title:` the global configuration sitename
* `og:description: ` the global configuration meta description

** Single article, blog, and featured article menu type **
* `og:url:` the URL of page being viewed
* `og:type: article`
* `og:title:` the title associated with the menu item being viewed
* `og:description: ` the first 255 characters of the first article's introtext
* `og:image: ` the first image found in the first article's introtext, if one is present

Learn more about The Open Graph Protocol at http://ogp.me/

## Requirements
* Joomla 2.5.19 / 3.2.3 or later.

## Support
* Please visit the [issues page](https://github.com/betweenbrain/Opengraph-Plugin/issues) for this project.

## Stable Master Branch Policy
The master branch will, at all times, remain stable. Development for new features will occur in branches, and when ready, will be merged into the master branch.

In the event features have already been merged for the next release series, and an issue arises that warrants a fix on the current release series, the developer will create a branch based off the tag created from the previous release, make the necessary changes, package a new release, and tag the new release. If necessary, the commits made in the temporary branch will be merged into master.

## Branch Schema
* __master__ :  stable at all times, containing the latest tagged release for Joomla 2.5 and 3.x.
* __develop__: the latest version in development for Joomla 2.5 and 3.x. This is the branch to base all pull requests on.

## Contributing
Your contributions are more than welcome! Please make all pull requests against the `develop` branch.
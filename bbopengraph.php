<?php defined('_JEXEC') or die;

/**
 * Simple plugin for implementing the Open Graph protocol - http://ogp.me/
 *
 * @package        Joomla.Plugin
 * @copyright      Copyright (C) 2012 Matt Thomas http://betweenbrain.com. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

jimport('joomla.plugin.plugin');

class plgContentBbOpenGraph extends JPlugin
{

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
	{
		static $count = 0;

		$app    = JFactory::getApplication();
		$config = JFactory::getConfig();
		$doc    = JFactory::getDocument();
		$menu   = $app->getMenu();
		$option = JRequest::getVar('option', '');
		$view   = JRequest::getVar('view', '');
		$scope  = $option . '.' . $view;

		//Ensure that we are not in the back-end
		if ($app->isAdmin()) {
			return true;
		}

		// Use global config data for default menu item
		if ($menu->getActive() == $menu->getDefault()) {

			// The canonical URL of the page.
			$doc->setMetadata('og:url', JURI::current());

			// The type of object.
			$doc->setMetadata('og:type', 'website');

			// The name of the overall site.
			$doc->setMetadata('og:site_name', htmlspecialchars($config->get('sitename')));

			// The title of the site.
			$doc->setMetadata('og:title', htmlspecialchars($config->get('sitename')));

			// The description of the site.
			$doc->setMetadata('og:description', htmlspecialchars($config->get('MetaDesc')));

		// Ensure we we haven't executed before and are in the right scope.
		} elseif (($count == 0) && (in_array($scope, array('com_content.article', 'com_content.category', 'com_content.featured')))) {

			// The canonical URL of the page.
			$doc->setMetadata('og:url', JURI::current());

			// The type of object.
			$doc->setMetadata('og:type', 'article');

			// The title of the object.
			$title = str_replace(array('"', "'"), '', $row->title);

			if (isset($row->title)) {
				$doc->setMetadata('og:title', htmlspecialchars($title));
			}

			// A description of the object.
			if (isset($row->introtext)) {
				// Sanitize introtext of other plugin shortcodes
				$row->introtext = preg_replace("/{[^}]*}/i", " ", $row->introtext);
				// First 255 characters of the introtext, sans HTML, with extra spaces removed.
				$description = preg_replace("/\s{2,}/", " ", substr(strip_tags($row->introtext), 0, 255));
				$doc->setMetadata('og:description', $description . '...');
			}

			// An image URL which represents the object
			preg_match('/<img.+src=[\"]([^\"]+)[\"].*>/i', $row->introtext, $image);

			if (isset($image[1]) && $image[1] != '') {
				$doc->setMetadata('og:image', JURI::base() . $image[1]);
			}

			$count++;
		}
	}
}
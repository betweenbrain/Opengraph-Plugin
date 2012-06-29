<?php defined('_JEXEC') or die;

/**
 * Simple plugin for implementing the Open Graph protocol - http://ogp.me/
 *
 * @package		Joomla.Plugin
 * @copyright	Copyright (C) 2012 Matt Thomas http://betweenbrain.com. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

jimport('joomla.plugin.plugin');

class plgContentBbOpenGraph extends JPlugin
{

	// public $count = 0;

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
	{

		$app  = JFactory::getApplication();
		$doc  = JFactory::getDocument();
		// $view = JRequest::getCmd('view');

		if ($app->isAdmin()) {
			return true;
		}

		if (!empty($this->lead_items)) {
			die;
		}

		// TODO: Figure out accessing only first row of blog views

		// if ($view == 'featured' && $this->count == 0) { }

		// var_dump($row);

		// var_dump(get_object_vars($row));

		/*
		$rows = get_object_vars($row);
		foreach ($rows as $key => $value) {
			return 'Key: ' . $key . ' Value: ' . $value;
		}
		*/

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
			$doc->setMetadata('og:description', substr(strip_tags($row->introtext), 0, 255));
		}

		// An image URL which represents the object
		preg_match('/<img.+src=[\"]([^\"]+)[\"].*>/i', $row->introtext, $image);

		if (isset($image[1]) && $image[1] != '') {
			$doc->setMetadata('og:image', JURI::base() . $image[1]);
		}
	}
}
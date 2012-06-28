<?php defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgContentBbOpenGraph extends JPlugin
{
	// public $occurrence = 0;

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
	{

		$app    = JFactory::getApplication();
		$doc    = JFactory::getDocument();
		$option = JRequest::getVar('option', '');
		$view   = JRequest::getCmd('view');

		if ($app->isAdmin()) {
			return true;
		}

		/*
		if ((int)$this->occurrence > 0) {
			// Second instance in featured view
			return;
		}
		*/

		if ($view == 'article' && $option == 'com_content') {

			$quotes = array('"', "'");
			$title  = str_replace($quotes, '', $row->title);

			preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $row->introtext, $image);

			if (empty($image))
				preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $row->fulltext, $image);

			$doc->setMetadata('og:url', JURI::current());
			$doc->setMetadata('og:type', 'article');

			if (isset($row->title))
				$doc->setMetadata('og:title', htmlspecialchars($title));

			if (isset($row->introtext))
				$doc->setMetadata('og:description', substr(strip_tags($row->introtext), 0, 255));

			if (!empty($image))
				$doc->setMetadata('og:image', JURI::base() . $image[1]);
		}
	}
}
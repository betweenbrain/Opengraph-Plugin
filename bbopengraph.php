<?php defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

// http://ogp.me/
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
		$view = JRequest::getCmd('view');

		if ($app->isAdmin()) {
			return true;
		}

		if (!empty($this->lead_items)) {
			die;
		}

		// TODO: Figure out accessing only first row of blog views
		// if ($view == 'featured' && $this->count == 0) { }
		//var_dump($row);

		$quotes = array('"', "'");
		$title  = str_replace($quotes, '', $row->title);

		$doc->setMetadata('og:url', JURI::current());
		$doc->setMetadata('og:type', 'article');

		if (isset($row->title))
			$doc->setMetadata('og:title', htmlspecialchars($title));

		if (isset($row->introtext))
			$doc->setMetadata('og:description', substr(strip_tags($row->introtext), 0, 255));

		preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $row->introtext . $row->introtext, $image);

		if (isset($image[1]) && $image[1] != '')
			$doc->setMetadata('og:image', JURI::base() . $image[1]);
	}
}
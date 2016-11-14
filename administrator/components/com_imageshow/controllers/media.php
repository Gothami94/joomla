<?php
/**
 * @author JoomlaShine.com Team
 * @copyright JoomlaShine.com
 * @link joomlashine.com
 * @package JSN ImageShow
 * @version $Id: media.php 8411 2011-09-22 04:45:10Z trungnq $
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );
class ImageShowControllerMedia extends JControllerLegacy
{
	function __construct($config = array())
	{
		parent::__construct($config);
	}

	function display($cachable = false, $urlparams = false)
	{
		$view = JRequest::getCmd('view');
		$theme = JRequest::getVar('theme');

		switch ($view)
		{
			case 'imageslist':
				if (!empty($theme))
				{
					JRequest::setVar('layout','showcase');
				}
				else
				{
					JRequest::setVar('layout','default');
				}

				JRequest::setVar('view','mediaimageslist');
				JRequest::setVar('model','mediaimageslist');
				break;
			default:
				if (!empty($theme))
				{
					JRequest::setVar('layout','showcase');
				}
				else
				{
					JRequest::setVar('layout','default');
				}
				JRequest::setVar('view','media');
				JRequest::setVar('model','media');
				break;
		}

		parent::display();
	}

	function upload()
	{
		$objJSNMediaManager = JSNISFactory::getObj('classes.jsn_is_mediamanager');
		$objJSNMediaManager->upload();
	}
}

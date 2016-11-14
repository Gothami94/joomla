<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

// import Joomla controller library
jimport('joomla.application.component.controller');

class bfstopController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = false)
	{
		$input = JFactory::getApplication()->input;
		$view = $input->getCmd('view', 'blocklist');
		BfstopHelper::addSubmenu($view);
		$input->set('view', $view);
		$this->checkForAdminUser();
		parent::display($cachable);
	}
	function checkForAdminUser()
	{
		$db = JFactory::getDBO();
		$query = "SELECT COUNT(*) FROM #__users u WHERE u.username='admin'";
		$db->setQuery($query);
		if ($db->loadResult() > 0)
		{
		        $application = JFactory::getApplication();
			$application->enqueueMessage(JText::_('WARNING_ADMIN_USER_EXISTS'), 'warning');
		}
	}
}

<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport('joomla.utilities.date');
require_once(JPATH_ADMINISTRATOR
	.DIRECTORY_SEPARATOR.'components'
	.DIRECTORY_SEPARATOR.'com_bfstop'
	.DIRECTORY_SEPARATOR.'helpers'
	.DIRECTORY_SEPARATOR.'log.php');

class bfstopViewtokenunblock extends JViewLegacy {

	function getLoginLink() {
		return JRoute::_('index.php?option=com_users&view=login');
	}

	function getPasswordResetLink() {
		return JRoute::_('index.php?option=com_users&view=reset');
	}

	function display($tpl = null) {
		// clear the messages still enqueued from the invalid login attempt:
		$session = JFactory::getSession();
		$session->set('application.queue', null);
		// try to unblock:
		$input = JFactory::getApplication()->input;
		$token = $input->getString('token', '');
		$logger = getLogger();
		if (strcmp($token, '') != 0) {
			$this->model = $this->getModel();
			$unblockSuccess = $this->model->unblock($token, $logger);
			$this->message = ($unblockSuccess)
				? JText::sprintf('UNBLOCKTOKEN_SUCCESS',
					$this->getLoginLink(),
					$this->getPasswordResetLink())
				: JText::_('UNBLOCKTOKEN_FAILED');
		} else {
			$this->message = JText::_('UNBLOCKTOKEN_INVALID');
		}
		parent::display($tpl);
	}
}


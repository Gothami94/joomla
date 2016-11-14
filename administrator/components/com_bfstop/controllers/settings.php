<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class BfstopControllerSettings extends JControllerAdmin
{
	private function getParam($name, $column, $defaultValue) {
		$db = JFactory::getDbo();
		$sql = "SELECT $column FROM #__extensions WHERE name = 'plg_system_bfstop'";
		$db->setQuery($sql);
		$rawSettings = $db->loadResult();
		$settings = json_decode($rawSettings, true);
		return array_key_exists($name, $settings) ? $settings[$name] : $defaultValue ;
	}

	public function getModel($name = 'settings', $prefix = 'bfstopmodel', $config=array())
	{
		$config['ignore_request'] = true;
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	public function testNotify()
	{
		$emailAddress = $this->getParam('emailaddress', 'params', '');
		$userID = (int)$this->getParam('userID', 'params', -1);
		$userGroup = (int)$this->getParam('userGroup', 'params', -1);
		$groupNotifEnabled = (bool)$this->getParam('groupNotificationEnabled', 'params', false);
		$logger = getLogger();
		$db  = new BFStopDBHelper($logger);
		$notifier = new BFStopNotifier($logger, $db,
			$emailAddress,
			$userID,
			$userGroup,
			$groupNotifEnabled);
		if (count($notifier->getNotifyAddresses()) == 0)
		{
			$result = false;
		} else {
			$subject = JText::sprintf('TEST_MAIL_SUBJECT', $notifier->getSiteName());
			$body = JText::sprintf('TEST_MAIL_BODY', $notifier->getSiteName());
			$application = JFactory::getApplication();
			$application->enqueueMessage(JText::sprintf("TEST_MAIL_SENT",
					$subject,
					$body,
					implode(", ", $notifier->getNotifyAddresses())),
				'notice');
			$result = $notifier->sendMail($subject, $body, $notifier->getNotifyAddresses());
		}

		// redirect back to settings view:
		$this->setRedirect(JRoute::_('index.php?option=com_bfstop&view=settings',false),
			$result
				? JText::_('TEST_NOTIFICATION_SUCCESS')
				: JText::_('TEST_NOTIFICATION_FAILED'),
			$result
				? 'notice'
				: 'error'
		);
	}
}

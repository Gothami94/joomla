<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

class BfstopHelper
{
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_BFSTOP_SUBMENU_BLOCKLIST'),
			'index.php?option=com_bfstop&view=blocklist',
			$vName == 'blocklist'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_BFSTOP_SUBMENU_WHITELIST'),
			'index.php?option=com_bfstop&view=whitelist',
			$vName == 'whitelist'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_BFSTOP_SUBMENU_FAILEDLOGINLIST'),
			'index.php?option=com_bfstop&view=failedloginlist',
			$vName == 'failedloginlist'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_BFSTOP_SUBMENU_SETTINGS'),
			'index.php?option=com_bfstop&view=settings',
			$vName == 'settings'
		);
	}
}

<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

require_once(JPATH_ADMINISTRATOR
		.DIRECTORY_SEPARATOR.'components'
		.DIRECTORY_SEPARATOR.'com_bfstop'
                .DIRECTORY_SEPARATOR.'helpers'
		.DIRECTORY_SEPARATOR.'ip.php');

class BfstopViewIpinfo extends JViewLegacy
{
	public function display($tpl = null)
	{
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		$input = JFactory::getApplication()->input;
		$this->ipAddress = $input->getString("ipaddress");
		$this->ipInfo = get_whois($this->ipAddress);
		$this->addToolbar();
		parent::display($tpl);
	}
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::sprintf('COM_BFSTOP_HEADING_IPINFO', $this->ipAddress), 'bfstop');
		JToolBarHelper::divider();
		JToolBarHelper::back();
	}
}

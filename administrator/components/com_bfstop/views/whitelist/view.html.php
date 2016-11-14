<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

// import Joomla view library
jimport('joomla.application.component.view');

require_once(JPATH_ADMINISTRATOR
		.DIRECTORY_SEPARATOR.'components'
		.DIRECTORY_SEPARATOR.'com_bfstop'
                .DIRECTORY_SEPARATOR.'helpers'
                .DIRECTORY_SEPARATOR.'links.php');

class bfstopViewwhitelist extends JViewLegacy
{
	function display($tpl = null) {
		$this->items      = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$state            = $this->get('State');
		$this->sortColumn = $state->get('list.ordering');
		$this->sortDirection = $state->get('list.direction');
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		$this->addToolBar();
		$lang = JFactory::getLanguage();
		$lang->load('plg_system_bfstop.sys', JPATH_ADMINISTRATOR);
		parent::display($tpl);
	}

	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_BFSTOP_HEADING_WHITELIST'), 'bfstop');
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('COM_BFSTOP_WHITELIST_DELETE_CONFIRM', 'whitelist.remove');
		JToolBarHelper::editList('whiteip.edit');
		JToolBarHelper::addNew('whiteip.add');
	}
}

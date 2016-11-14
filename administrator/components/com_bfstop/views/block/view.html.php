<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

class BfstopViewBlock extends JViewLegacy
{
	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		$this->addToolbar();
		$lang = JFactory::getLanguage();
		$lang->load('plg_system_bfstop.sys', JPATH_ADMINISTRATOR);
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base(true).DIRECTORY_SEPARATOR.
			'components'.DIRECTORY_SEPARATOR.
			'com_bfstop'.DIRECTORY_SEPARATOR.
			'views'.DIRECTORY_SEPARATOR.
			'block'.DIRECTORY_SEPARATOR.
			'tmpl'.DIRECTORY_SEPARATOR.
			'edit.css');
		parent::display($tpl);
	}
	protected function addToolbar()
	{
		$input = JFactory::getApplication()->input;
		$input->set('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew
			? JText::_('COM_BFSTOP_BLOCK_NEW')
			: JText::_('COM_BFSTOP_BLOCK_EDIT'));
		JToolBarHelper::save('block.save');
		JToolBarHelper::cancel('block.cancel', $isNew
			? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}

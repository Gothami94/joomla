<?php
/**********************************************
* 	FlippingBook Gallery Component.
*	� Mediaparts Interactive. All rights reserved.
* 	Released under Commercial License.
*	www.page-flip-tools.com
**********************************************/
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

class JFormFieldModal_Book extends JFormField {
	
	protected $type = 'Modal_Book';
	
	protected function getInput() {
		$db = JFactory::getDBO();
		$query = 'SELECT a.id, a.title'
		. ' FROM #__flippingbook_books AS a'
		. ' ORDER BY a.title';
		$db->setQuery( $query );
		$options = $db->loadObjectList();
		return JHtml::_('select.genericlist',  $options, 'jform[request][id]', 'class="inputbox"', 'id', 'title', $this->value);
	}
}
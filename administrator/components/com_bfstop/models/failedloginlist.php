<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class bfstopModelfailedloginlist extends JModelList
{
	public function __construct($config = array())
	{
		$config['filter_fields'] = array(
			'l.id',
			'l.username',
			'l.ipaddress',
			'l.error',
			'l.logtime',
			'l.origin'
		);
		parent::__construct($config);
	}

	protected function getListQuery()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('l.id, l.username, l.ipaddress, l.error, l.logtime, l.origin');
		$query->from('#__bfstop_failedlogin l');
		$ordering  = $this->getState('list.ordering', 'l.id');
		$ordering  = (strcmp($ordering, '') == 0) ? 'b.id' : $ordering;
		$direction = $this->getState('list.direction', 'ASC');
		$direction = (strcmp($direction, '') == 0) ? 'ASC' : $direction;
		$query->order($db->escape($ordering).' '.$db->escape($direction));
		return $query;
	}

	protected function populateState($ordering = null, $direction = null) {
		parent::populateState('l.id', 'ASC');
	}
}

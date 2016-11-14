<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class bfstopModelwhitelist extends JModelList
{
	public function __construct($config = array())
	{
		$config['filter_fields'] = array(
			'w.id',
			'w.ipaddress',
			'w.crdate'
		);
		parent::__construct($config);
	}

	protected function getListQuery()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('w.id, w.ipaddress, w.crdate');
		$query->from('#__bfstop_whitelist w');
		$ordering  = $this->getState('list.ordering', 'w.id');
		$ordering  = (strcmp($ordering, '') == 0) ? 'w.id' : $ordering;
		$direction = $this->getState('list.direction', 'ASC');
		$direction = (strcmp($direction, '') == 0) ? 'ASC' : $direction;
		$query->order($db->escape($ordering).' '.$db->escape($direction));
		return $query;
	}

	protected function populateState($ordering = null, $direction = null) {
		parent::populateState('w.id', 'ASC');
	}

	public function remove($ids, $logger)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$conditions = array(
			$db->quoteName('id').' IN ('.implode(", ", $ids).')'
		);
		$query->delete($db->quoteName('#__bfstop_whitelist'));
		$query->where($conditions);
		$db->setQuery($query);
		$db->query();
		BFStopDBHelper::checkDBError($db, $logger);
	}

}

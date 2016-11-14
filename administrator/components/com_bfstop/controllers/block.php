<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class BfstopControllerBlock extends JControllerForm
{
	public function save($key = null, $urlVar = null)
	{
		$return = parent::save($key, $urlVar);
		$this->setRedirect('index.php?option=com_bfstop&view=blocklist');
		return $return;
	}
	public function cancel($key = null)
	{
		$return = parent::cancel($key);
		$this->setRedirect('index.php?option=com_bfstop&view=blocklist');
		return $return;
	}

}

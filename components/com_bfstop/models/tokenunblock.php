<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.model');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DIRECTORY_SEPARATOR.'helpers'.
	DIRECTORY_SEPARATOR.'unblock.php');

class bfstopModeltokenunblock extends JModelLegacy {

	const TokenValidDays = 3;

	public function unblock($token, $logger) {
		// prune old tokens:
		$this->_db->setQuery('DELETE FROM #__bfstop_unblock_token '.
			'WHERE DATE_ADD(crdate, INTERVAL '.self::TokenValidDays.' DAY) < '.
			$this->_db->quote(date('Y-m-d H:i:s')));
		$this->_db->execute();
		BFStopDBHelper::checkDBError($this->_db, $logger);
		// get token:
		$this->_db->setQuery('SELECT * FROM #__bfstop_unblock_token WHERE token='.
			$this->_db->quote($token));
		$unblockTokenEntry = $this->_db->loadObject();
		BFStopDBHelper::checkDBError($this->_db, $logger);
		if ($unblockTokenEntry == null) {
			$logger->log("com_bfstop-tokenunblock: Token not found.", JLog::ERROR);
			return false;
		}
		BFStopUnblockHelper::unblock($this->_db, array($unblockTokenEntry->block_id), 1, $logger);
		$sql = 'DELETE FROM #__bfstop_unblock_token WHERE token='.
				$this->_db->quote($token);
		$this->_db->setQuery($sql);
		$success = $this->_db->execute();
		BFStopDBHelper::checkDBError($this->_db, $logger);
		if (!$success) {
			$logger->log("com_bfstop-tokenunblock: Could not delete unblock_token.", JLog::ERROR);
		} else  {
			$logger->log("com_bfstop-tokenunblock: Successfully unblocked with token.", JLog::INFO);
		}
		return $success;
	}
}

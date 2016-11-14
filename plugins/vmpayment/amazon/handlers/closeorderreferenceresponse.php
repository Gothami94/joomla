<?php

defined('_JEXEC') or die('Direct Access to ' . basename(__FILE__) . 'is not allowed.');

/**
 *
 * @package    VirtueMart
 * @subpackage vmpayment
 * @version $Id: closeorderreferenceresponse.php 9083 2015-12-11 13:41:40Z alatak $
 * @author Valérie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - September 20 2016 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 */
class amazonHelperCloseOrderReferenceResponse extends amazonHelper {

	public function __construct (OffAmazonPaymentsService_Model_CloseOrderReferenceResponse $closeOrderReferenceResponse, $method) {
		parent::__construct($closeOrderReferenceResponse, $method);
	}



	public function getStoreInternalData () {
		return NULL;
	}



	function getContents () {

		$contents = $this->tableStart("CloseOrderReferenceResponse");
		$contents .= $this->getRow("Dump: ", var_export($this->amazonData, true));

		$contents .= $this->tableEnd();

		return $contents;
	}


}
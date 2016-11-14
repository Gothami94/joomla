<?php

defined('_JEXEC') or die('Direct Access to ' . basename(__FILE__) . 'is not allowed.');

/**
 *
 * @package    VirtueMart
 * @subpackage vmpayment
 * @version $Id: authorizeresponse.php 8259 2014-08-31 13:43:36Z alatak $
 * @author Valérie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - September 20 2016 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */
class amazonHelperRefundRequest extends amazonHelper {

	public function __construct (OffAmazonPaymentsService_Model_RefundRequest $refundRequest, $method) {
		parent::__construct($refundRequest, $method);
	}




	function getContents () {

		$contents = $this->tableStart("RefundRequest ");
		$contents .= $this->getRow("Dump: ", var_export($this->amazonData, true));
		$contents .= $this->tableEnd();

		return $contents;
	}


}
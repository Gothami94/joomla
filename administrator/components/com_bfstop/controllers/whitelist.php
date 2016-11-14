<?php
/*
 * @package Brute Force Stop Component (com_bfstop) for Joomla! >=2.5
 * @author Bernhard Froehler
 * @copyright (C) 2012-2014 Bernhard Froehler
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class BfstopControllerWhiteList extends JControllerAdmin
{
	public function getModel($name = 'whitelist', $prefix = 'bfstopmodel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	public function remove()
	{
		$logger = getLogger();
		$input =  JFactory::getApplication()->input;
		$ids = $input->post->get('cid', array(), 'array');
		JArrayHelper::toInteger($ids);
		$model = $this->getModel('whitelist');
		$message = $model->remove($ids, $logger);
                $this->setRedirect(JRoute::_('index.php?option=com_bfstop&view=whitelist',false),
                        $message, 'notice');
	}
}

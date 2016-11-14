<?php
/*------------------------------------------------------------------------
# mod_ccsignup_majix_pro
# ------------------------------------------------------------------------
# author    JoomLadds / River Media
# copyright Copyright (C) 2015 JoomLadds All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomladds.com
# Technical Support:  Forum - http://www.joomladds.com/forum.html
-------------------------------------------------------------------------*/

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a one line text field.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @link        http://www.w3.org/TR/html-markup/input.text.html#input.text
 * @since       11.1
 */
class JFormFieldBreak extends JFormField
{
	/**
	 * @var string
	 */
	protected $type = 'Break';

	/**
	 * @return string
	 */
	protected function getLabel()
	{
        $version = new JVersion();

        if (isset($this->element['label']) && !empty($this->element['label'])) {
            $label = JText::_((string)$this->element['label']);
            $css   = (string)$this->element['class'];
            $style   = 'font-weight:bold;border-bottom:1px solid #eee;font-size:16px;color:#574B81;margin-top:10px;padding:2px 0;width:100%;';
            $version = new JVersion();
            if (version_compare($version->getShortVersion(), '3.0', '>=')) {
                return '<div style="' . $style . '">' . $label . '</div>';
            } else {
                return '<label style="'.$style.'text-align:left !important;">' . $label . '</label>';
            }
        } else {
            return;
        }

	}

	/**
	 * @return mixed
	 */
	protected function getInput()
	{
        return;
    }

}

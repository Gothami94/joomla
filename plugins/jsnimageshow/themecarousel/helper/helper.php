<?php
/**
 * @version     $Id$
 * @package     JSN.ImageShow
 * @subpackage  JSN.ThemeCarousel
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) @JOOMLASHINECOPYRIGHTYEAR@ JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
defined('_JEXEC') or die( 'Restricted access' );
$objJSNShowcaseTheme = JSNISFactory::getObj('classes.jsn_is_showcasetheme');
$objJSNShowcaseTheme->importTableByThemeName($this->_showcaseThemeName);
$objJSNShowcaseTheme->importModelByThemeName($this->_showcaseThemeName);
$modelShowcaseTheme = JModelLegacy::getInstance($this->_showcaseThemeName);
$items = $modelShowcaseTheme->getTable($themeID);

JSNISFactory::importFile('classes.jsn_is_htmlselect');

/**
 * /////////////////////////////////////////////////////////Image Panel Begin////////////////////////////////////////////////////////////////////////////
 */
$imageSource = array(
	'0' => array('value' => 'thumbnails', 'text' => JText::_('THEME_CAROUSEL_IMAGE_SOURCE_THUMBNAILS')),
	'1' => array('value' => 'original_images', 'text' => JText::_('THEME_CAROUSEL_IMAGE_SOURCE_ORIGINAL_IMAGES'))
);
$lists['imageSource'] = JHTML::_('select.genericList', $imageSource, 'image_source', 'class="inputbox"', 'value', 'text', ($items->image_source == '')?'thumbnails':$items->image_source);

$clickAction = array(
	'0' => array('value' => 'no_action', 'text' => JText::_('THEME_CAROUSEL_CLICK_ACTION_NO_ACTION')),
	'1' => array('value' => 'show_original_image', 'text' => JText::_('THEME_CAROUSEL_CLICK_ACTION_SHOW_ORIGINAL_IMAGE')),
	'2' => array('value' => 'open_image_link', 'text' => JText::_('THEME_CAROUSEL_CLICK_ACTION_OPEN_IMAGE_LINK'))
);
$lists['clickAction'] = JHTML::_('select.genericList', $clickAction, 'click_action', 'class="inputbox"', 'value', 'text', ($items->click_action == '')?'show_original_image':$items->click_action);

$openLinkIn = array(
	'0' => array('value' => 'current_browser', 'text' => JText::_('THEME_CAROUSEL_OPEN_LINK_IN_CURRENT_BROWSER')),
	'1' => array('value' => 'new_browser', 'text' => JText::_('THEME_CAROUSEL_OPEN_LINK_IN_NEW_BROWSER'))
);
$lists['openLinkIn'] = JHTML::_('select.genericList', $openLinkIn, 'open_link_in', 'class="inputbox"', 'value', 'text', ($items->open_link_in == '')?'current_browser':$items->open_link_in);

$orientation = array(
	'0' => array('value' => 'horizontal', 'text' => JText::_('THEME_CAROUSEL_ORIENTATION_HORIZONTAL')),
	'1' => array('value' => 'vertical', 'text' => JText::_('THEME_CAROUSEL_ORIENTATION_VERTICAL'))
);
$lists['orientation'] = JHTML::_('select.genericList', $orientation, 'orientation', 'class="inputbox effect-panel"', 'value', 'text', ($items->orientation == '')?'horizontal':$items->orientation);

$lists['enableDragAction'] = JHTML::_('jsnselect.booleanlist', 'enable_drag_action', 'class="inputbox effect-panel"', $items->enable_drag_action, 'JYES', 'JNO', false, 'yes', 'no');

/**
 * /////////////////////////////////////////////////////////Caption Panel Begin////////////////////////////////////////////////////////////////////////////
 */

$lists['showCaption'] = JHTML::_('jsnselect.booleanlist', 'show_caption', 'class="inputbox"', $items->show_caption, 'JYES', 'JNO', false, 'yes', 'no');

$lists['captionShowTitle'] = JHTML::_('jsnselect.booleanlist', 'caption_show_title', 'class="inputbox"', $items->caption_show_title, 'JYES', 'JNO', false, 'yes', 'no');
$lists['captionShowDescription'] = JHTML::_('jsnselect.booleanlist', 'caption_show_description', 'class="inputbox"', $items->caption_show_description, 'JYES', 'JNO', false, 'yes', 'no');

/**
 * /////////////////////////////////////////////////////////Navigation Panel Begin////////////////////////////////////////////////////////////////////////////
 */

$navigationPresentation	= array(
	'0' => array('value' => 'show', 'text' => JText::_('THEME_CAROUSEL_SHOW')),
	'1' => array('value' => 'hide', 'text' => JText::_('THEME_CAROUSEL_HIDE'))
);
$lists['navigationPresentation'] = JHTML::_('select.genericList', $navigationPresentation, 'navigation_presentation', 'class="inputbox"', 'value', 'text', ($items->navigation_presentation == '')?'show':$items->navigation_presentation);

/**
 * /////////////////////////////////////////////////////////Slideshow Panel Begin////////////////////////////////////////////////////////////////////////////
 */

$lists['autoPlay'] = JHTML::_('jsnselect.booleanlist', 'auto_play', 'class="inputbox effect-panel"', $items->auto_play, 'JYES', 'JNO', false, 'yes', 'no');
$lists['pauseOnMouseOver'] = JHTML::_('jsnselect.booleanlist', 'pause_on_mouse_over', 'class="inputbox effect-panel"', $items->pause_on_mouse_over, 'JYES', 'JNO', false, 'yes', 'no');
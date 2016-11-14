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
defined('_JEXEC') or die('Restricted access');
class TableThemeCarousel extends JTable
{
	var $theme_id 								= null;
	var $image_source							= 'thumbnails';
	var $image_width							= '250';
	var $image_height							= '150';
	var $image_border_thickness					= '5';
	var $image_border_color						= '#666666';
	var $view_angle								= '0';
	var $transparency							= '50';
	var $scale									= '35';
	var $diameter								= '50';
	var	$animation_duration						= '0.6';
	var $click_action							= 'show_original_image';
	var $open_link_in							= 'current_browser';
	var $orientation							= 'horizontal';
	var $enable_drag_action						= 'no';
	var $show_caption							= 'yes';
	var $caption_background_color				= '#000000';
	var $caption_opacity						= '75';
	var $caption_show_title						= 'yes';
	var $caption_title_css						= "font-family: Verdana;\nfont-size: 12px;\nfont-weight: bold;\ntext-align: left;\ncolor: #E9E9E9;";
	var $caption_show_description				= 'yes';
	var $caption_description_length_limitation	= '50';
	var $caption_description_css				= "font-family: Arial;\nfont-size: 11px;\nfont-weight: normal;\ntext-align: left;\ncolor: #AFAFAF;";
	var $navigation_presentation				= 'show';
	var $auto_play								= 'no';
	var $slide_timing							= '3';
	var $pause_on_mouse_over					= 'yes';

	function __construct(& $db) {
		parent::__construct('#__imageshow_theme_carousel', 'theme_id', $db);
	}
}
?>
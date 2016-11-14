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
jimport('joomla.application.component.model');
class JSNISCarouselDisplay extends JObject
{
	var $_themename 	= 'themecarousel';
	var $_themetype 	= 'jsnimageshow';
	var $_assetsPath 	= 'plugins/jsnimageshow/themecarousel/assets/';
	public function __construct() {}

	public function standardLayout($args)
	{
		$objJSNShowlist	= JSNISFactory::getObj('classes.jsn_is_showlist');
		$showlistInfo 	= $objJSNShowlist->getShowListByID($args->showlist['showlist_id'], true);
		$dataObj 		= $objJSNShowlist->getShowlist2JSON($args->uri, $args->showlist['showlist_id']);
		$images			= $dataObj->showlist->images->image;
		$document 		= JFactory::getDocument();
		$plugin			= false;

		if (!count($images)) return '';

		$pluginOpenTagDiv 	= '';
		$pluginCloseTagDiv 	= '';

		if (isset($args->plugin) && $args->plugin == true)
		{
			$plugin = true;
		}

		switch ($showlistInfo['image_loading_order'])
		{
			case 'backward':
				krsort($images);
				$tmpImageArray = $images;
				$images = array_values($images);
				break;
			case 'random':
				shuffle($images);
				break;
			case 'forward':
				ksort($images);
		}

		$path = JPath::clean(JPATH_PLUGINS.DS.$this->_themetype.DS.$this->_themename.DS.'models');
		JModelLegacy::addIncludePath($path);
		$model 			= JModelLegacy::getInstance($this->_themename);
		$themeData		= $model->getTable($args->theme_id);
		$themeDataJson	= json_encode($themeData);

		JHTML::stylesheet($this->_assetsPath.'css/jsn_is_carouseltheme.css');
		JHTML::stylesheet($this->_assetsPath.'css/fancybox/jquery.fancybox-1.3.4.css');
		$this->loadjQuery();
		JHTML::script($this->_assetsPath.'js/jsn_is_conflict.js');
		JHTML::script($this->_assetsPath.'js/jquery/jquery.easing.1.3.js');
		JHTML::script($this->_assetsPath.'js/jquery/jquery.event.drag-2.2.js');
		JHTML::script($this->_assetsPath.'js/jquery/jquery.event.drop-2.2.js');
		JHTML::script($this->_assetsPath.'js/jquery/jquery.roundabout.js');
		JHTML::script($this->_assetsPath.'js/jquery/jquery.roundabout-shapes.js');
		JHTML::script($this->_assetsPath.'js/jquery/jquery.imagesloaded.min.js');
		JHTML::script($this->_assetsPath.'js/jquery/jquery.mousewheel.min.js');
		JHTML::script($this->_assetsPath.'js/jsn_is_carouseltheme.js');
		$document->addScriptDeclaration('
			if (typeof jQuery.fancybox != "function") {
				document.write(\'<script type="text\/javascript" src="'. JUri::root() .$this->_assetsPath.'js'.'/jquery/jquery.fancybox-1.3.4.js"><\/script>\');
			}
		');

		$percent  	= strpos($args->width, '%');

		if ($plugin)
		{
			$pluginOpenTagDiv = '<div style="max-width:'.$args->width.((!$percent)?'px':'').'; margin: 0 auto;">';
			$pluginCloseTagDiv = '</div>';
			$percent = true;
			$args->width = '100%';
		}

		$width 		= ($percent === false) ? $args->width.'px' : $args->width;
		$wrapID		= 'jsn-'.$this->_themename.'-container-'.$args->random_number;
		$galleryID	= 'jsn-'.$this->_themename.'-gallery-'.$args->random_number;
		$css		= '#'.$wrapID.' {width:'.$width.';height:'.$args->height.'px;overflow : hidden;margin: 0 auto;position: relative;}';
		$css		.= '#'.$wrapID.' ul.roundabout-holder {
							list-style: none outside none;
    						margin: 0 auto;
    						padding: 0;
    						width: '.$themeData->diameter.'%;
    						height: 50%;
    						top: 25%;
    						left: '.(2-intval($themeData->image_border_thickness)).'px;
 							}';
		$css		.= '#'.$wrapID.' ul.roundabout-holder li a{
							padding: 0;
 							}';
		$css		.= '#'.$wrapID.' li {
							cursor: pointer;
						    text-align: center;
							overflow:hidden;
							border: '.$themeData->image_border_thickness.'px solid '.$themeData->image_border_color.';
							background-color:'.$themeData->image_border_color.';
							margin:0;
							padding:0;
						}';
		$css		.= '#'.$wrapID.' li img {
								max-width: none;
								max-height: none;
								width:100%;
								position:relative;
								margin:0;
							}';
		$css		.= '#'.$wrapID.' .loading {
							top:45%;
							width:100%;
							position:relative;
							padding:0;
							margin:0;
							z-index:999;
						}';
		$css		.= '#'.$wrapID.' .loading img {	margin:0 auto;}';
		if($themeData->show_caption == 'yes' && ($themeData->caption_show_title == 'yes' || $themeData->caption_show_description == 'yes'))
		{
			$backgroundColor	= $this->hex2rgb($themeData->caption_background_color);
			$backgroundOpacity	= (float) $themeData->caption_opacity/100;
			$css	.= '.gallery-info-'.$args->random_number.' {display:block;background-color:rgb('.$backgroundColor.');background-color:rgba('.$backgroundColor.','.$backgroundOpacity.');}';
			$css	.= '.gallery-info-title-'.$args->random_number.' {padding:5px 5px 4px;'.$themeData->caption_title_css.'}';
			$css	.= '.gallery-info-description-'.$args->random_number.' {padding:5px 5px 4px;'.$themeData->caption_description_css.'}';
		}

		$document->addStyleDeclaration($css);

		$html	 = $pluginOpenTagDiv.'<div id="'.$wrapID.'">';
		$html	.= '<div class="loading"><img src="'.$this->_assetsPath.'/images/loading.gif"/></div>';
		$html	.= '<ul id="'.$galleryID.'">';
		$i=1;
		$imageSource	= ($themeData->image_source == 'thumbnails')?'thumbnail':'image';
		$imageLink		= ($themeData->click_action == 'show_original_image')?'image':'link';
		$openLinkIn		= ($themeData->open_link_in == 'current_browser')?'':'target="_blank"';
		$descriptionLenghtLimit	= (int) trim($themeData->caption_description_length_limitation);

		foreach ($images as $image)
		{
			$caption	= '';
			$title		= htmlspecialchars($image->title, ENT_QUOTES);

			$alt = htmlentities($image->title, ENT_QUOTES, 'UTF-8', false);
			if (isset($image->alt_text))
			{
				if ($image->alt_text != '')
				{
					$alt = htmlentities($image->alt_text, ENT_QUOTES, 'UTF-8', false);
				}
			}

			if($themeData->show_caption == 'yes')
			{
				if ($themeData->caption_show_title == 'yes')
				{
					$caption .= '<div class="gallery-info-title-'.$args->random_number.'">'.$image->title.'</div>';
				}

				if($themeData->caption_show_description == 'yes')
				{
					$desc  = $this->_wordLimiter($image->description, $descriptionLenghtLimit);
					$caption .= '<div class="gallery-info-description-'.$args->random_number.'">'.$desc.'</div>';
				}

				$caption = htmlspecialchars($caption,ENT_QUOTES);
			}

			if ($themeData->click_action == 'no_action')
			{
				$clickAction = '';
			}
			else
			{
				$clickAction = 'href="'.$image->$imageLink.'"';
			}

			$html .= '<li><a '.$clickAction.' '.$openLinkIn.' title="'.$title.'" rev=\''.$caption.'\'><img src="'.$image->$imageSource.'" alt="' . $alt . '"/></a></li>';
			$i++;
		}
		$html	.= '</ul>';
		if($themeData->navigation_presentation == "show")
		{
			$html	.= '<span class="jsn_carousel_prev_button"></span><span class="jsn_carousel_next_button"></span>';
		}

		$html	.= '</div>'.$pluginCloseTagDiv;
		$html	.= '<script type="text/javascript">
						jsnThemeCarouseljQuery(function() {

							jsnThemeCarouseljQuery(document).ready(function(){
								jsnThemeCarouseljQuery("#'.$wrapID.'").parents("div.jsn-pagebuilder.pb-element-container.pb-element-tab").find("ul.nav-tabs li a").on("click", function () {
									jsnThemeCarouseljQuery("#'.$wrapID.'").children(".loading").show();
									jsnThemeCarouseljQuery("#'.$galleryID.'").css("visibility","hidden");
									jsnThemeCarouseljQuery("#'.$wrapID.'").imagesLoaded(function() {
										jsnThemeCarouseljQuery("#'.$wrapID.'").children(".loading").hide();
										jsnThemeCarouseljQuery("#'.$galleryID.'").carouseltheme("'.$args->random_number.'","'.$wrapID.'",'.$themeDataJson.');
										jsnThemeCarouseljQuery("#'.$galleryID.'").css("visibility","");
									});
								});
							});

							jsnThemeCarouseljQuery("#'.$wrapID.'").children(".loading").show();
							jsnThemeCarouseljQuery("#'.$galleryID.'").css("visibility","hidden");
							jsnThemeCarouseljQuery("#'.$wrapID.'").imagesLoaded(function() {
								jsnThemeCarouseljQuery("#'.$wrapID.'").children(".loading").hide();
								jsnThemeCarouseljQuery("#'.$galleryID.'").carouseltheme("'.$args->random_number.'","'.$wrapID.'",'.$themeDataJson.');
								jsnThemeCarouseljQuery("#'.$galleryID.'").css("visibility","");
							});
						});
				</script>';

		return $html;
	}

	public function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb); // returns the rgb values separated by commas
		//return $rgb; // returns an array with the rgb values
	}
	public function _wordLimiter($str, $limit = 100, $endChar = '&#8230;')
	{
		if (trim($str) == '')
		{
		    return $str;
		}
		$append = '';
		$str 	= strip_tags(trim($str), '<b><i><s><strong><em><strike><u><br><span>');

		$words 	= explode(" ", $str);
		if(count($words) > $limit)
		{
			$append = $endChar;
		}

		return implode(" ", array_splice($words, 0, $limit)) . $append;
	}
	public function displayAlternativeContent()
	{
		return '';
	}

	public function displaySEOContent($args)
	{
		$html    = '<div class="jsn-'.$this->_themename.'-seocontent">'."\n";

		if (count($args->images))
		{
			$html .= '<div>';
			$html .= '<p>'.@$args->showlist['showlist_title'].'</p>';
			$html .= '<p>'.@$args->showlist['description'].'</p>';
			$html .= '<ul>';

			for ($i = 0, $n = count($args->images); $i < $n; $i++)
			{
				$row 	=& $args->images[$i];
				$html  .= '<li>';
				if ($row->image_title != '')
				{
					$html .= '<p>'.$row->image_title.'</p>';
				}
				if ($row->image_description != '')
				{
					$html .= '<p>'.$row->image_description.'</p>';
				}
				if ($row->image_link != '')
				{
					$html .= '<p><a href="'.$row->image_link.'">'.$row->image_link.'</a></p>';
				}
				$html .= '</li>';
			}
			$html .= '</ul></div>';
		}
		$html   .='</div>'."\n";
		return $html;
	}
	public function mobileLayout($args){
		return '';
	}
	public function display($args)
	{
		$string		= '';
		$args->uri	= JURI::base();
		$string .= $this->standardLayout($args);
		$string .= $this->displaySEOContent($args);
		return $string;
	}
	public function getThemeDataMobile($args)
	{
		return false;
	}

	function loadjQuery()
	{
		$loadJoomlaDefaultJQuery = true;
		if (class_exists('JSNConfigHelper')) {
			$objConfig = JSNConfigHelper::get('com_imageshow');
			if ($objConfig->get('jquery_using') != 'joomla_default') {
				$objUtils = JSNISFactory::getObj('classes.jsn_is_utils');

				if (method_exists($objUtils, 'loadJquery')) {
					$objUtils->loadJquery();
				}
				else {
					JHTML::script($this->_assetsPath . 'js/jsn_is_jquery_safe.js');
					JHTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
				}
				$loadJoomlaDefaultJQuery = false;
			}
		}
		if ($loadJoomlaDefaultJQuery) {
			JHTML::script($this->_assetsPath . 'js/jsn_is_jquery_safe.js');
			JHtml::_('jquery.framework');
		}
	}
}
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
if (!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}
$objJSNUtils = JSNISFactory::getObj('classes.jsn_is_utils');
?>
<script type="text/javascript">
	(function($) {
		$(document).ready(function(){
			$('#jsn-is-themecarousel').tabs();
			$(window).load(function() {
				$('ul#jsn-themecarousel-gallery').carouselthemesetting();
			});
		})
	})(jsnThemeCarouseljQuery);
</script>

<table class="jsn-showcase-theme-settings">
	<tr>
		<td valign="top" id="jsn-theme-parameters-wrapper">
			<div id="jsn-is-themecarousel" class="jsn-tabs">
				<ul>
					<li><a href="#themecarousel-image-tab"><?php echo JText::_('THEME_CAROUSEL_IMAGE'); ?></a></li>
					<li><a href="#themecarousel-caption-tab"><?php echo JText::_('THEME_CAROUSEL_CAPTION'); ?></a></li>
					<li><a href="#themecarousel-navigation-tab"><?php echo JText::_('THEME_CAROUSEL_NAVIGATION'); ?></a></li>
					<li><a href="#themecarousel-slideshow-tab"><?php echo JText::_('THEME_CAROUSEL_SLIDESHOW'); ?></a></li>
				</ul>
				<div id="themecarousel-image-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-carousel">
							<div class="span12">
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_IMAGE_SOURCE_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_IMAGE_SOURCE_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_IMAGE_SOURCE_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['imageSource']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_IMAGE_WIDTH_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_IMAGE_WIDTH_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_IMAGE_WIDTH_TITLE');?></label>
									<div class="controls">
										<input type="number" id="image_width" name="image_width" class="input-mini visual-panel" value="<?php echo $items->image_width; ?>" /> px
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_IMAGE_HEIGHT_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_IMAGE_HEIGHT_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_IMAGE_HEIGHT_TITLE');?></label>
									<div class="controls">
										<input type="number" id="image_height" name="image_height" class="input-mini visual-panel" value="<?php echo $items->image_height; ?>" /> px
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_IMAGE_BORDER_THICKNESS_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_IMAGE_BORDER_THICKNESS_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_IMAGE_BORDER_THICKNESS_TITLE');?></label>
									<div class="controls">
										<input type="number" id="image_border_thickness" name="image_border_thickness" class="input-mini visual-panel" value="<?php echo $items->image_border_thickness; ?>" /> px
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_IMAGE_BORDER_COLOR_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_IMAGE_BORDER_COLOR_DESC')); ?>"><?php echo JText::_('THEME_CAROUSEL_IMAGE_BORDER_COLOR_TITLE'); ?></label>
									<div class="controls">
										<input class="input-mini visual-panel" type="text" size="10" id="image_border_color" readonly="readonly" name="image_border_color" value="<?php echo $items->image_border_color; ?>" />
										<div class="color-selector"><div style="background-color: <?php echo (!empty($items->image_border_color))?$items->image_border_color:'#666666'; ?>"></div></div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_VIEW_ANGLE_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_VIEW_ANGLE_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_VIEW_ANGLE_TITLE');?></label>
									<div class="controls">
										<input type="hidden" id="view_angle" name="view_angle" class="input-mini effect-panel" value="<?php echo $items->view_angle; ?>" />
										<div id="view_angle_slider" class="carousel-param-slider"></div><div id="view_angle_slider_value" class="carousel-param-slider-value"><?php echo $items->view_angle; ?></div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_TRANSPARENCY_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_TRANSPARENCY_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_TRANSPARENCY_TITLE');?></label>
									<div class="controls">
										<input type="hidden" id="transparency" name="transparency" class="input-mini effect-panel" value="<?php echo $items->transparency; ?>" />
										<div id="transparency_slider" class="carousel-param-slider"></div><div id="transparency_slider_value" class="carousel-param-slider-value"><?php echo $items->transparency; ?>%</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_SCALE_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_SCALE_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_SCALE_TITLE');?></label>
									<div class="controls">
										<input type="hidden" id="scale" name="scale" class="input-mini effect-panel" value="<?php echo $items->scale; ?>" />
										<div id="scale_slider" class="carousel-param-slider"></div><div id="scale_slider_value" class="carousel-param-slider-value"><?php echo $items->scale; ?>%</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_DIAMETER_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_DIAMETER_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_DIAMETER_TITLE');?></label>
									<div class="controls">
										<input type="hidden" id="diameter" name="diameter" class="input-mini visual-panel" value="<?php echo $items->diameter; ?>" />
										<div id="diameter_slider" class="carousel-param-slider"></div><div id="diameter_slider_value" class="carousel-param-slider-value"><?php echo $items->diameter; ?>%</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_ANIMATION_DURATION_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_ANIMATION_DURATION_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_ANIMATION_DURATION_TITLE');?></label>
									<div class="controls">
										<input type="number" id="animation_duration" name="animation_duration" class="input-mini effect-panel" value="<?php echo $items->animation_duration; ?>" /> <?php echo JText::_('SECONDS'); ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_ORIENTATION_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_ORIENTATION_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_ORIENTATION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['orientation']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_ENABLE_DRAG_ACTION_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_ENABLE_DRAG_ACTION_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_ENABLE_DRAG_ACTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['enableDragAction']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_CLICK_ACTION_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_CLICK_ACTION_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_CLICK_ACTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['clickAction']; ?>
									</div>
								</div>
								<div id="jsn-open-link-in" class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_OPEN_LINK_IN_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_OPEN_LINK_IN_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_OPEN_LINK_IN_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['openLinkIn']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themecarousel-caption-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-carousel">
							<div class="span12">
								<div id="jsn-show-caption" class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_SHOW_CAPTION_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_SHOW_CAPTION_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_SHOW_CAPTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['showCaption']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_CAPTION_BACKGROUND_COLOR_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_CAPTION_BACKGROUND_COLOR_DESC')); ?>"><?php echo JText::_('THEME_CAROUSEL_CAPTION_BACKGROUND_COLOR_TITLE'); ?></label>
									<div class="controls">
										<input class="input-mini" type="text" size="10" id="caption_background_color" readonly="readonly" name="caption_background_color" value="<?php echo $items->caption_background_color; ?>" />
										<div class="color-selector"><div style="background-color: <?php echo (!empty($items->caption_background_color))?$items->caption_background_color:'#000000'; ?>"></div></div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_CAPTION_OPACITY_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_CAPTION_OPACITY_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_CAPTION_OPACITY_TITLE');?></label>
									<div class="controls">
										<input type="number" id="caption_opacity" name="caption_opacity" class="input-mini" value="<?php echo $items->caption_opacity; ?>" /> %
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_CAPTION_SHOW_TITLE_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_CAPTION_SHOW_TITLE_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_CAPTION_SHOW_TITLE_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['captionShowTitle']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_CAPTION_TITLE_CSS_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_CAPTION_TITLE_CSS_DESC')); ?>"><?php echo JText::_('THEME_CAROUSEL_CAPTION_TITLE_CSS_TITLE'); ?></label>
									<div class="controls">
										<textarea class="input-xlarge" name="caption_title_css" rows="5"><?php echo $items->caption_title_css; ?></textarea>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_CAPTION_SHOW_DESCRIPTION_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_CAPTION_SHOW_DESCRIPTION_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_CAPTION_SHOW_DESCRIPTION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['captionShowDescription']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_CAPTION_DESCRIPTION_LENGTH_LIMITATION_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_CAPTION_DESCRIPTION_LENGTH_LIMITATION_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_CAPTION_DESCRIPTION_LENGTH_LIMITATION_TITLE');?></label>
									<div class="controls">
										<input type="number" id="caption_description_length_limitation" name="caption_description_length_limitation" class="input-mini" value="<?php echo $items->caption_description_length_limitation; ?>" /> <?php echo JText::_('WORDS'); ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_CAPTION_DESCRIPTION_CSS_TITLE'));?>::<?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_CAPTION_DESCRIPTION_CSS_DESC')); ?>"><?php echo htmlspecialchars(JText::_('THEME_CAROUSEL_CAPTION_DESCRIPTION_CSS_TITLE'));?></label>
									<div class="controls">
										<textarea class="input-xlarge" name="caption_description_css" rows="5"><?php echo $items->caption_description_css; ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themecarousel-navigation-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-carousel">
							<div class="span12">
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_NAVIGATION_PRESENTATION_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_NAVIGATION_PRESENTATION_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_NAVIGATION_PRESENTATION_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['navigationPresentation']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="themecarousel-slideshow-tab" class="jsn-bootstrap">
					<div class="form-horizontal">
						<div class="row-fluid show-carousel">
							<div class="span12">
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_AUTO_PLAY_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_AUTO_PLAY_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_AUTO_PLAY_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['autoPlay']; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_SLIDE_TIMING_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_SLIDE_TIMING_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_SLIDE_TIMING_TITLE');?></label>
									<div class="controls">
										<input type="number" id="slide_timing" name="slide_timing" class="input-mini effect-panel" value="<?php echo $items->slide_timing; ?>" /> <?php echo JText::_('SECONDS'); ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label hasTip" title="<?php echo JText::_('THEME_CAROUSEL_PAUSE_ON_MOUSE_OVER_TITLE');?>::<?php echo JText::_('THEME_CAROUSEL_PAUSE_ON_MOUSE_OVER_DESC'); ?>"><?php echo JText::_('THEME_CAROUSEL_PAUSE_ON_MOUSE_OVER_TITLE');?></label>
									<div class="controls">
										<?php echo $lists['pauseOnMouseOver']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</td>
		<td id="jsn-theme-preview-wrapper">
			<div>
				<?php include dirname(__FILE__).DS.'preview.php'; ?>
			</div>
		</td>
	</tr>
</table>
<!--  important -->
<input type="hidden" name="theme_name" value="<?php echo strtolower($this->_showcaseThemeName); ?>"/>
<input type="hidden" name="theme_id" value="<?php echo (int) @$items->theme_id; ?>" />
<!--  important -->
<div style="clear:both;"></div>

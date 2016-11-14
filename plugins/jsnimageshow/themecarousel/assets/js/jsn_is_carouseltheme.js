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
(function($) {
	$.fn.carouseltheme = function(ID, containerID,options){
		var imageWidthOriginal	= options['image_width'];
		var imgWidthNew			= (imageWidthOriginal)?imageWidthOriginal + 'px':'auto';
		var imageHeightOriginal	= options['image_height'];
		var imgHeightNew		= (imageHeightOriginal)?imageHeightOriginal + 'px':'auto';
		if(imageWidthOriginal == '')
		{	
			if(imageHeightOriginal == '')
			{
				this.find('img').css({'width':'auto','height':'auto'});
			}
			else
			{
				this.find('img').css({'width':'auto','height':imgHeightNew});
			}
		}
		this.children('li').css({'width':imgWidthNew, 'height':imgHeightNew});
		var autoPlay	= (options['auto_play']=='yes')?true:false;
		var next		= null;
		var prev		= null;
		if(options['navigation_presentation'] == 'show')
		{
			this.siblings('.jsn_carousel_prev_button').show();
			this.siblings('.jsn_carousel_next_button').show();
			next	= '#'+containerID+' .jsn_carousel_next_button';
			prev	= '#'+containerID+' .jsn_carousel_prev_button';
		}

		var effectOption	= {
			shape: (options['orientation']=='horizontal')?'lazySusan':'waterWheel',	
			tilt: parseInt(options['view_angle']),
			minOpacity: parseFloat(options['transparency']/100),
            minScale: parseFloat(options['scale']/100),
            duration: parseFloat(options['animation_duration'])*1000,
            enableDrag: (options['enable_drag_action']=='yes')?true:false,
            dragAxis: (options['orientation']=='horizontal')?'x':'y',
            btnNext: next,
            btnPrev: prev,
            autoplay: autoPlay,
            autoplayDuration: parseInt(options['slide_timing'])*1000,		
            autoplayPauseOnHover: (!autoPlay)?false:((options['pause_on_mouse_over']=='yes')?true:false),		
            responsive: true
		};
		this.roundabout(effectOption);
		
		if(imageHeightOriginal != '' && imageWidthOriginal != '')
		{
			var imageBoxRatio	= imageWidthOriginal/imageHeightOriginal;
			this.find("img").each(function(){
				var newImg = $(this).clone();
				newImg.removeAttr('css');
				newImg.removeAttr('width');
				newImg.removeAttr('height');
				newImg.css('display','none');
				newImg.appendTo('body');

				var leftOffset	= 0;
				var topOffset	= 0;
				var imgWidth	= 0;
				var imgHeight	= 0;
				var imageRatio		= $(newImg).width()/$(newImg).height();
				if(imageRatio <= imageBoxRatio){
					//cut top and bottom of image
					imgWidth	= '100';
					imgHeight	= (100*imageBoxRatio)/imageRatio;
					topOffset	= (100 - imgHeight)/2;
				}else{
					//cut left and right of image
					imgHeight	= '100';
					imgWidth	= (imageRatio/imageBoxRatio)*100;
					leftOffset	= (100 - imgWidth)/2;
				}
				$(this).css({'width':imgWidth+'%','height':imgHeight+'%','top':topOffset+'%','left':leftOffset+'%'});
				newImg.remove();
			});	
		}
		else	
		{
			this.find('img').css({'width':'100%','height':'100%'});
		}
		if(options['click_action'] == 'show_original_image'){
			try 
			{
				this.children('li').focus(function(){
					jQuery(this).children('a').fancybox({
						'titlePosition'	: 'over',
						'titleFormat'	: function(title, currentArray, currentIndex, currentOpts){
							return '<div class="gallery-info-'+ID+'">'+title+ '</div>';
						}
					});
				});
				this.children('li').blur(function(){
					$(this).children('a').unbind('.fb');
				});
				this.children('li.roundabout-in-focus').trigger('focus');
			}
			catch(err)
			{
				return false;
			}			
		}
	};
})(jsnThemeCarouseljQuery);

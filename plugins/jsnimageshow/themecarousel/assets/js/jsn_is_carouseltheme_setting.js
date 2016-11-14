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
	$.fn.extend({
		carouselObj : null,
		currentImageIndex : 0,
		carouselSettings : {},
		initSliderSetting:function(SliderElement,minVal,maxVal,stepVal,unit) {
			$('#'+SliderElement+'_slider')[0].slide = null;
			$('#'+SliderElement+'_slider').slider({
				value:parseInt($('#'+SliderElement).val()),
				min: minVal,
				max: maxVal,
				step: stepVal,
				slide: function( event, ui ) {
					$('#'+SliderElement+'_slider_value').html(ui.value+unit);
					$('#'+SliderElement).val(ui.value);
					$('#'+SliderElement).trigger('change');
				}
        	});
		},
		ColorChangeEvent:function(){
			$('.color-selector').each(function(){
				var self		= $(this);
				var colorInput  = self.siblings("input").first();
				
				self.ColorPicker({
					color: $(colorInput).val(),
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$(colorInput).val('#' + hex);
						self.children().css('background-color', '#' + hex);
						$(colorInput).change();
					}
				});
			});
		},
		initSettings:function(){
			//initSliderSetting(element,min,max,step,unit) 
			this.initSliderSetting("view_angle",-5,5,1,'');
			this.initSliderSetting("transparency",0,100,1,'%');
			this.initSliderSetting("scale",0,100,1,'%');
			this.initSliderSetting("diameter",0,100,1,'%');
			
			$('#click_action').change(function(){
				if($(this).val() == "open_image_link")
				{
					$('#jsn-open-link-in').show();
				}
				else
				{
					$('#jsn-open-link-in').hide();
				}
			});
			$('#click_action').trigger('change');
			
			$("input:radio[name=show_caption]").click(function() {
				if($(this).val() == 'yes')
				{
					$('#jsn-show-caption').siblings().show();
				}	
				else
				{
					$('#jsn-show-caption').siblings().hide();
				}
			});
			$('input:radio[name=show_caption]:checked').click();
			$('#navigation_presentation').change(function(){
				if($(this).val() == "show")
				{
					$('#jsn_carousel_prev_button').show();
					$('#jsn_carousel_next_button').show();
				}
				else
				{
					$('#jsn_carousel_prev_button').hide();
					$('#jsn_carousel_next_button').hide();
				}	
			});
			$('#navigation_presentation').trigger('change');
			this.ColorChangeEvent();
		},
		destroyRoundabout:function(){
			$(window).unbind("resize");
			carouselObj.children().andSelf().unbind('.roundabout');
			if(carouselObj.data("roundabout")){
				carouselObj.roundabout("stopAutoplay",false);
			}
			carouselObj.children().andSelf().removeAttr('style');
			carouselObj.find('img').removeAttr('style');
			carouselObj.children().andSelf().unbind("draginit dragstart drag dragend");
			carouselObj.children().andSelf().unbind("dropinit dropstart drop dropend");
			carouselObj.removeData('roundabout');
		},
		scaleResize: function(imageWidth,imageHeight)
		{
			var imageBoxRatio	= imageWidth/imageHeight;
			carouselObj.find("img").each(function(){
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
		},
		initCarousel:function(){
			this.destroyRoundabout();
			carouselObj.css('width',carouselSettings['visual']['diameter']+'%');
			var imageWidthOriginal	= carouselSettings['visual']['image_width'];
			var imgWidthNew			= (imageWidthOriginal)?imageWidthOriginal + 'px':'auto';
			var imageHeightOriginal	= carouselSettings['visual']['image_height'];
			var imgHeightNew		= (imageHeightOriginal)?imageHeightOriginal + 'px':'auto';
			if(imageWidthOriginal == '')
			{	
				if(imageHeightOriginal == '')
				{
					carouselObj.find('img').css({'width':'auto','height':'auto'});
				}
				else
				{
					carouselObj.find('img').css({'width':'auto','height':imgHeightNew});
				}
			}
			var imgBorderThickness	= parseInt( carouselSettings['visual']['image_border_thickness']);
			var imgBackgroundColor	= '';
			var imgBorder			= '';
			carouselObj.css('left','2px');
			if(imgBorderThickness)
			{
				imgBackgroundColor	= carouselSettings['visual']['image_border_color'];
				imgBorder		= imgBorderThickness+'px solid '+imgBackgroundColor;	
				carouselObj.css('left','-='+imgBorderThickness);
			}
			carouselObj.children('li').css({'width':imgWidthNew, 'height':imgHeightNew, 'background-color':imgBackgroundColor, 'border':imgBorder});
			
			//Start init effect
			var autoPlay		= (carouselSettings['effect']['auto_play']=='yes')?true:false;
			var effectOption	= {
				startingChild: currentImageIndex,
				shape: (carouselSettings['effect']['orientation']=='horizontal')?'lazySusan':'waterWheel',	
				tilt: parseInt(carouselSettings['effect']['view_angle']),
				minOpacity: parseFloat(carouselSettings['effect']['transparency']/100),
	            minScale: parseFloat(carouselSettings['effect']['scale']/100),
	            duration: parseFloat(carouselSettings['effect']['animation_duration'])*1000,
	            enableDrag: (carouselSettings['effect']['enable_drag_action']=='yes')?true:false,
	            dragAxis: (carouselSettings['effect']['orientation']=='horizontal')?'x':'y',
	            btnNext: '#jsn_carousel_next_button',	
	            btnPrev: '#jsn_carousel_prev_button',
	            autoplay: autoPlay,
	            autoplayDuration: parseInt(carouselSettings['effect']['slide_timing'])*1000,		
	            autoplayPauseOnHover: (!autoPlay)?false:((carouselSettings['effect']['pause_on_mouse_over']=='yes')?true:false),		
	            responsive: true
			};
			carouselObj.roundabout(effectOption);
			//End init effect
			if(imageHeightOriginal != '' && imageWidthOriginal != '')
			{
				this.scaleResize(imageWidthOriginal,imageHeightOriginal);
			}
			else 
			{
				carouselObj.find('img').css({'width':'100%','height':'100%'});
			}
		},
		changeVisual:function(type,name,value){
			carouselSettings[type][name] = value;
			var listItem = document.getElementsByClassName('roundabout-in-focus')[0];
			currentImageIndex = $('.roundabout-moveable-item').index(listItem);
			this.initCarousel();
		}
	});
	$.fn.carouselthemesetting = function(){
		var visualOptions = {};
		var effectOptions = {};
		$('.visual-panel').each(function(){
			if($(this).attr('type') != 'radio' || $(this).attr('checked'))
			{
				visualOptions[$(this).attr('name')] = $(this).attr('value');
			}
			$(this).change(function(){
				$(this).changeVisual('visual',$(this).attr('name'),$(this).attr('value'));
			});
		});
		$('.effect-panel').each(function(){
			if($(this).attr('type') != 'radio' || $(this).attr('checked'))
			{	
				effectOptions[$(this).attr('name')] = $(this).attr('value');
			}	
			$(this).change(function(){
				$(this).changeVisual('effect',$(this).attr('name'),$(this).attr('value'));
			});
		});
		carouselSettings = {
			'effect': effectOptions,
			'visual' : visualOptions
		};
		carouselObj = this;
		currentImageIndex = 0;

		this.initSettings();
		this.initCarousel();
	};
})(jsnThemeCarouseljQuery);

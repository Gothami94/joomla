/**
 * cvfind.js: Find product by dropdown 
 *
 * @package	VirtueMart
 * @subpackage Javascript Library
 * @author Max Milbers
 * @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

if (typeof Virtuemart === "undefined")
	Virtuemart = {};

Virtuemart.cvFind = function(event) {
	event.preventDefault();
	var selection = [];

	var runs= 0, maxruns = 20;
	//We ensure with this, to get the right product, if more than one is displayed
	var container = jQuery(event.currentTarget);
	while(!container.hasClass('product-field-display') && runs<=maxruns){
		container = container.parent();
		runs++;
	}
	if(runs>maxruns){
		console.log('Could not find parent');
		return false;
	}
	Virtuemart.container = container;


	runs=0;
	var cl = 'product-container';
	Virtuemart.containerSelector = '.'+cl;
	while(!Virtuemart.container.hasClass(cl) && runs<=maxruns){
		Virtuemart.container = Virtuemart.container.parent();
		runs++;
	}
	if(runs>maxruns){
		console.log('Could not find parent');
		return false;
	}

	//console.log('my new ajax container ',Virtuemart.container);
	var found = false;

	//We check first if it is a radio
	jQuery(container).find('.cvselection:checked').each(function() {
		selection[selection.length] = jQuery(this).val();
		found = true;
	});
	if(!found){
		jQuery(container).find('.cvselection').each(function() {
			selection[selection.length] = jQuery(this).val();
		});
	}

	var index=0, i2=0, hitcount=0;
	//to ensure that an url is set, set the url of first product
	jQuery(this).prop('url',event.data.variants[0][0]);
	for	(runs = 0; runs < selection.length; index++) {
		for	(index = 0; index < event.data.variants.length; index++) {
			hitcount = 0;
			for	(i2 = 0; i2 <= selection.length; i2++) {
				if(selection[i2]==event.data.variants[index][i2+1]){
					hitcount++;
					if(hitcount == (selection.length-runs)){
						var url = event.data.variants[index][0].replace(/amp;/g, '');
						jQuery(this).attr('url',url);
						jQuery(this).val(url);

						if(jQuery(this).attr('reload')){
							Virtuemart.isUpdatingContent = true;
							window.top.location.href = url;
							return false;
						}
						//console.log('return url '+url);
						return url;
					}
				} else {
					break;
				}
			}
		}
		runs++;
		//console.log('Could not find product for selection '+runs);
	}

	return false;
};



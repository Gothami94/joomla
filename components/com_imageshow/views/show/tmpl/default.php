<?php
/**
 * @author JoomlaShine.com Team
 * @copyright JoomlaShine.com
 * @link joomlashine.com
 * @package JSN ImageShow
 * @version $Id: default.php 13899 2012-07-11 10:08:31Z giangnd $
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die( 'Restricted access' );
$Itemid = $this->Itemid;
$objJSNShow 		= JSNISFactory::getObj('classes.jsn_is_show');

$showListID 		= JRequest::getInt('showlist_id', 0);
$showCaseID 		= JRequest::getInt('showcase_id', 0);
$dispatcher			= JDispatcher::getInstance();
$objJSNTheme 		= JSNISFactory::getObj('classes.jsn_is_showcasetheme');

if(is_null($this->showlistInfo))
{
	echo  $this->objUtils->displayShowlistMissingMessage();
	return;
}

if(is_null($this->showcaseInfo))
{
	echo  $this->objUtils->displayShowcaseMissingMessage();
	return;
}

$themeProfile   	= $objJSNTheme->getThemeProfile($this->showcaseInfo->showcase_id);

if(!$themeProfile)
{
	echo  $this->objUtils->displayThemeMissingMessage();
	return;
}

$widthOverlap		= JRequest::getVar('w', '');
$heightOverlap		= JRequest::getVar('h', '');
$display			= false;
$user 				= JFactory::getUser();
$authAvailable 		= $user->getAuthorisedViewLevels();

$language			= '';

if ($this->objUtils->checkSupportLang())
{
	$objLanguage 		= JFactory::getLanguage();
	$language           = $objLanguage->getTag();
}

if ($heightOverlap != '')
{
	$height = $heightOverlap;
}
else
{
	$height = @$this->showcaseInfo->general_overall_height;
}

if ($widthOverlap !='')
{
	$width 	= $widthOverlap;
}
else
{
	$width 	= @$this->showcaseInfo->general_overall_width;
}

if ($width == '')
{
	$width = '100%';
}

if ($height == '')
{
	$height = '100';
}

$posPercentageWidth = strpos($width, '%');

if ($posPercentageWidth)
{
	$width = substr($width, 0, $posPercentageWidth + 1);
}
else
{
	$width = (int) $width;
}
$height = (int) $height;

if (!in_array($this->showlistInfo['access'],  $authAvailable))
{
	$display = false;
}
else
{
	$display = true;
}
$shortEdition  			= $this->objUtils->getShortEdition();
$themeInfo 				= $objJSNTheme->getThemeInfo($themeProfile->theme_name);
$object					= new stdClass();
$object->width			= $width;
$object->height			= $height;
$object->showlist_id 	= $showListID;
$object->showcase_id 	= $showCaseID;
$object->item_id	 	= $Itemid;
$object->random_number	= $this->randomNumber;
$object->language		= $language;
$object->edition		= $shortEdition;
$object->images			= $this->imagesData;
$object->showlist		= $this->showlistInfo;
$object->showcase		= $this->showcaseInfo;
$object->theme_id		= $themeProfile->theme_id;
$object->theme_name		= $themeProfile->theme_name;
?>
<!-- <?php echo @$this->coreInfo->description.' '.@$this->coreInfo->version.' - '.@$themeInfo->name. ' '. @$themeInfo->version; ?> -->
<div class="com-imageshow <?php echo @$this->pageclassSFX; ?>">
<?php
if ($this->titleWillShow != '')
{
	echo '<h1 class="componentheading">'.$this->titleWillShow.'</h1>';
}
?>
	<div class="standard-gallery">
		<div class="jsn-container">
		<?php 
			if ($this->itemmnid && $this->showBreadCrumbs)
			{
				$menuInfo = $this->objJSNShow->getMenuByID($this->itemmnid);
				if (count($menuInfo))
				{
					$menuLink = '';
					if ((strpos($menuInfo->link, 'index.php?') === 0) && (strpos($menuInfo->link, 'Itemid=') === false))
					{
						$menuLink = $menuInfo->link . '&Itemid=' . $menuInfo->id;
						echo '<div class="jsn-is-back"><a class="jsn-is-back-link" href="' . JRoute::_($menuLink) . '">&laquo; ' . JText::_('JSN_IMAGESHOW_BACK_BUTTON') . '</a></div>';
					}
					
				}	

			}	
		?>
		<?php
		if ($display)
		{
			$result = $objJSNTheme->displayTheme($object);

			if ($result !== false) {
				echo $result;
			}
		}
		else
		{
			if($this->showlistInfo['authorization_status'])
			{
				echo '<div>'.$this->articleAuth['introtext'].$this->articleAuth['fulltext'].'</div>';
			}
		}
		?>
		</div>
	</div>
</div>

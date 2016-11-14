<?php
/**
 * @version		$Id: category.php 14913 2012-08-10 02:58:55Z quocanhd $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<!-- Start K2 Category Layout -->
<div id="k2Container" class="itemListView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">
	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>"> <?php echo $this->escape($this->params->get('page_title')); ?> </div>
	<?php endif; ?>
	<?php if(isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )): ?>
	<!-- Blocks for current category and subcategories -->
	<div class="itemListCategoriesBlock">
		<?php if(isset($this->category) && ( $this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->event->K2CategoryDisplay )): ?>
		<!-- Category block -->
		<div class="itemListCategory">
			<?php if(isset($this->addLink)): ?>
			<!-- Item add link --> 
			<span class="catItemAddLink"> <a class="modal" rel="{handler:'iframe',size:{x:990,y:650}}" href="<?php echo $this->addLink; ?>"> <?php echo JText::_('K2_ADD_A_NEW_ITEM_IN_THIS_CATEGORY'); ?> </a> </span>
			<?php endif; ?>
			<?php if($this->params->get('catImage') && $this->category->image): ?>
			<!-- Category image --> 
			<img alt="<?php echo K2HelperUtilities::cleanHtml($this->category->name); ?>" src="<?php echo $this->category->image; ?>" style="width:<?php echo $this->params->get('catImageWidth'); ?>px; height:auto;" />
			<?php endif; ?>
			<?php if($this->params->get('catTitle')): ?>
			<!-- Category title -->
			<h2><?php echo $this->category->name; ?>
				<?php if($this->params->get('catTitleItemCounter')) echo ' ('.$this->pagination->total.')'; ?>
			</h2>
			<?php endif; ?>
			<?php if($this->params->get('catDescription')): ?>
			<!-- Category description -->
			<?php echo $this->category->description; ?>
			<?php endif; ?>
			<!-- K2 Plugins: K2CategoryDisplay --> 
			<?php echo $this->category->event->K2CategoryDisplay; ?>
			<div class="clr"></div>
			<?php if($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)): ?>
			<!-- Subcategories -->
			<div class="itemListSubCategories">
				<h3><?php echo JText::_('K2_CHILDREN_CATEGORIES'); ?></h3>
				<?php foreach($this->subCategories as $key=>$subCategory): ?>
				<?php
				// Define a CSS class for the last container on each row
				if( (($key+1)%($this->params->get('subCatColumns'))==0) || count($this->subCategories)<$this->params->get('subCatColumns') )
					$lastContainer= ' subCategoryContainerLast';
				else
					$lastContainer='';
				?>
				<div class="subCategoryContainer<?php echo $lastContainer; ?>"<?php echo (count($this->subCategories)==1) ? '' : ' style="width:'.number_format(100/$this->params->get('subCatColumns'), 1).'%;"'; ?>>
					<div class="subCategory">
						<?php if($this->params->get('subCatTitle')): ?>
						<!-- Subcategory title -->
						<h5> <a href="<?php echo $subCategory->link; ?>"> <?php echo $subCategory->name; ?>
							<?php if($this->params->get('subCatTitleItemCounter')) echo ' ('.$subCategory->numOfItems.')'; ?>
						</a> </h5>
						<?php endif; ?>
						<?php if($this->params->get('subCatImage') && $subCategory->image): ?>
						<!-- Subcategory image -->
						<a class="subCategoryImage" href="<?php echo $subCategory->link; ?>"> <img alt="<?php echo K2HelperUtilities::cleanHtml($subCategory->name); ?>" src="<?php echo $subCategory->image; ?>" /> </a>
						<?php endif; ?>
						<?php if($this->params->get('subCatDescription')): ?>
						<!-- Subcategory description -->
						<?php echo $subCategory->description; ?>
						<?php endif; ?>
						<!-- Subcategory more... --> 
						<a class="subCategoryMore" href="<?php echo $subCategory->link; ?>"> <?php echo JText::_('K2_VIEW_ITEMS'); ?> </a>
						<div class="clr"></div>
					</div>
				</div>
				<?php if(($key+1)%($this->params->get('subCatColumns'))==0): ?>
				<div class="clr"></div>
				<?php endif; ?>
				<?php endforeach; ?>
				<div class="clr"></div>
			</div>
		<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))): ?>
	<!-- Item list -->
	<div class="itemList">
		<?php if(isset($this->leading) && count($this->leading)): ?>
		<!-- Leading items -->
		<div id="itemListLeading">
			<?php
			$leadingcount = count($this->leading);
			$counter=0;
			foreach($this->leading as $key => &$item): 
				$key= $key+1;
				$rowcount=( ((int)$key-1) %	(int) $this->params->get('num_leading_columns')) +1;
				$row = $counter / $this->params->get('num_leading_columns') ;
				// Define a CSS class for the last container on each row
				if( (($key+1)%($this->params->get('num_leading_columns'))==0) || count($this->leading)<$this->params->get('num_leading_columns') )
					$lastContainer= ' itemContainerLast';
				else
					$lastContainer='';
				
				if ($rowcount == 1) : ?>
					<div class="items-row cols-<?php echo (int) $this->params->get('num_leading_columns');?> <?php echo 'row-'.$row; ?> row-fluid">
					<?php endif; ?>
						<div class="span<?php echo round(12 / $this->params->get('num_leading_columns'));?>">
							<div class="itemContainer<?php echo $lastContainer; ?>">
								<?php
									// Load category_item.php by default
									$this->item=$item;
									echo $this->loadTemplate('item');
								?>
							</div>
							<?php $counter++; ?>
						</div>
					<?php if (($rowcount == $this->params->get('num_leading_columns')) or ($counter == $leadingcount)): ?>			
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="clr"></div>
		</div>
		<?php endif; ?>
		<?php if(isset($this->primary) && count($this->primary)): ?>
		<!-- Primary items -->
		<div id="itemListPrimary">
			<?php
			$primarycount = count($this->primary);
			$primarycounter=0;
			foreach($this->primary as $key => &$item): 
				$key= $key+1;
				$rowcount=( ((int)$key-1) %	(int) $this->params->get('num_primary_columns')) +1;
				$row = $primarycounter / $this->params->get('num_primary_columns') ;
				
				// Define a CSS class for the last container on each row
				if( (($key+1)%($this->params->get('num_primary_columns'))==0) || count($this->primary)<$this->params->get('num_primary_columns') )
					$lastContainer= ' itemContainerLast';
				else
					$lastContainer='';

				if ($rowcount == 1) : ?>
				<div class="items-row cols-<?php echo (int) $this->params->get('num_primary_columns');?> <?php echo 'row-'.$row; ?> row-fluid">
				<?php endif; ?>
					<div class="span<?php echo round(12 / $this->params->get('num_primary_columns'));?>">
						<div class="itemContainer<?php echo $lastContainer; ?>">
							<?php
								// Load category_item.php by default
								$this->item=$item;
								echo $this->loadTemplate('item');
							?>
						</div>
						<?php $primarycounter++; ?>
					</div>
				<?php if(($rowcount == $this->params->get('num_primary_columns')) or ($primarycounter == $primarycount)): ?>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<?php if(isset($this->secondary) && count($this->secondary)): ?>
		<!-- Secondary items -->
		<div id="itemListSecondary">
			<?php
			$secondarycount = count($this->secondary);
			$secondarycounter=0;
			foreach($this->secondary as $key => &$item):
				$key= $key+1;
				$rowcount=( ((int)$key-1) %	(int) $this->params->get('num_secondary_columns')) +1;
				$row = $secondarycounter / $this->params->get('num_secondary_columns') ;
				
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_secondary_columns'))==0) || count($this->secondary)<$this->params->get('num_secondary_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';

			if ($rowcount == 1) : ?>
				<div class="items-row cols-<?php echo (int) $this->params->get('num_secondary_columns');?> <?php echo 'row-'.$row; ?> row-fluid">
				<?php endif; ?>
					<div class="span<?php echo round(12 / $this->params->get('num_secondary_columns'));?>">
						<div class="itemContainer<?php echo $lastContainer; ?>">
							<?php
								// Load category_item.php by default
								$this->item=$item;
								echo $this->loadTemplate('item');
							?>
						</div>
					<?php $secondarycounter++; ?>
					</div>
				<?php if(($rowcount == $this->params->get('num_secondary_columns')) or ($secondarycounter == $secondarycount)): ?>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<?php if(isset($this->links) && count($this->links)): ?>
		<!-- Link items -->
		<div id="itemListLinks">
			<h3><?php echo JText::_('K2_MORE'); ?></h3>
			<?php
			$linkscount = count($this->links);
			$linkscounter=0;
			foreach($this->links as $key => &$item):
				$key= $key+1;
				$rowcount=( ((int)$key-1) %	(int) $this->params->get('num_links_columns')) +1;
				$row = $linkscounter / $this->params->get('num_links_columns') ;
				
				// Define a CSS class for the last container on each row
				if((($key+1)%($this->params->get('num_links_columns'))==0) || count($this->links)<$this->params->get('num_links_columns'))
					$lastContainer= ' itemContainerLast';
				else
					$lastContainer='';

				if ($rowcount == 1) : ?>
				<div class="items-row cols-<?php echo (int) $this->params->get('num_links_columns');?> <?php echo 'row-'.$row; ?> row-fluid">
				<?php endif; ?>
					<div class="span<?php echo round(12 / $this->params->get('num_links_columns'));?>">
						<div class="itemContainer<?php echo $lastContainer; ?>">
							<?php
								// Load category_item_links.php by default
								$this->item=$item;
								echo $this->loadTemplate('item_links');
							?>
						</div>
						<?php $linkscounter++; ?>
					</div>
				<?php if(($rowcount == $this->params->get('num_links_columns')) or ($linkscounter == $linkscount)): ?>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
	<!-- Pagination -->
	<?php if(count($this->pagination->getPagesLinks())): ?>
	<div class="k2Pagination">
		<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php if($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>
	<?php endif; ?>
</div>
<!-- End K2 Category Layout --> 
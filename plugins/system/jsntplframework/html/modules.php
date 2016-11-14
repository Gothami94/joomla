<?php
/**
 * @version $Id: modules.php 5556 2006-10-23 19:56:02Z Jinx $
 * @package Joomla
 * @copyright Copyright (C) 2005 - 2006 Open Source Matters. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

// Load template framework
if ( ! defined('JSN_PATH_TPLFRAMEWORK'))
{
	require_once JPATH_ROOT . '/plugins/system/jsntplframework/jsntplframework.defines.php';
	require_once JPATH_ROOT . '/plugins/system/jsntplframework/libraries/joomlashine/loader.php';
}

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */
jimport('joomla.application.module.helper');

if ( ! function_exists( 'modChrome_jsnmodule' ) ) :

function modChrome_jsnmodule( $module, &$params, &$attribs )
{
	if ($module->content)
	{
		$jsnutils = JSNTplUtils::getInstance();
		$moduleTitleOuput = '<span class="jsn-moduleicon">' . $module->title . '</span>';
		$beginModuleContainerOutput = '';
		$endModuleContainerOutput = '';

		// Check module class for xHTML output
		if (isset( $attribs['class']))
		{
			// Check value in attribute class to generate appropriate xHTML code for module title
			if (preg_match('/\bjsn-duohead\b/', (string) $attribs['class']))
			{
				$moduleTitleOuput = '<span class="jsn-moduleicon">' . $jsnutils->wrapFirstWord($module->title) . '</span>';
			}

			if (preg_match('/\bjsn-innerhead\b/', (string) $attribs['class']))
			{
				$moduleTitleOuput = '<span class="jsn-moduletitle_inner1"><span class="jsn-moduletitle_inner2">' . $moduleTitleOuput . '</span></span>';
			}

			// Check value in attribute class to generate appropriate xHTML code for module container
			if (preg_match('/\bjsn-triobox\b/', (string) $attribs['class']))
			{
				$beginModuleContainerOutput = '<div class="jsn-top"><div class="jsn-top_inner"></div></div><div class="jsn-middle"><div class="jsn-middle_inner">';
				$endModuleContainerOutput = '</div></div><div class="jsn-bottom"><div class="jsn-bottom_inner"></div></div>';
			}

			if (preg_match('/\bjsn-roundedbox\b/', (string) $attribs['class']))
			{
				$beginModuleContainerOutput = '<div><div>';
				$endModuleContainerOutput = '</div></div>';
			}
		}

		// Generate output code to template
		echo '<div class="' . $params->get('moduleclass_sfx') . ' jsn-modulecontainer' . (isset($attribs['columnClass']) ? ' ' . $attribs['columnClass'] : '') . '"><div class="jsn-modulecontainer_inner">';
		echo $beginModuleContainerOutput;

		if (strpos($params->get('moduleclass_sfx'), 'display-dropdown') !== false && ($module->position == 'mainmenu' || $module->position == 'toolbar'))
		{
			echo '<h3 class="jsn-moduletitle"><span>' . $moduleTitleOuput . '</span></h3>';
		}
		else
		{
			if ($module->showtitle)
			{
				echo '<h3 class="jsn-moduletitle">' . $moduleTitleOuput . '</h3>';
			}
		}

		echo '<div class="jsn-modulecontent">';
		echo $module->content;
		echo '<div class="clearbreak"></div></div>';
		echo $endModuleContainerOutput;
		echo '</div></div>';
	}
}

endif;

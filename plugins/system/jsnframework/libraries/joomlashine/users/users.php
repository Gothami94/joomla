<?php
/**
 * @version    $Id$
 * @package    JSN_Framework
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Users component helper.
 *
 * @package  JSN_Framework
 * @since    1.0.3
 */
class UsersHelper
{
	/**
	 * @var    JObject  A cache for the available actions.
	 */
	protected static $actions;

	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_USERS_SUBMENU_USERS'), 'index.php?option=com_users&view=users', $vName == 'users'
		);

		// Groups and Levels are restricted to core.admin
		$canDo = self::getActions();

		if ($canDo->get('core.admin'))
		{
			JSubMenuHelper::addEntry(
				JText::_('COM_USERS_SUBMENU_GROUPS'), 'index.php?option=com_users&view=groups', $vName == 'groups'
			);
			JSubMenuHelper::addEntry(
				JText::_('COM_USERS_SUBMENU_LEVELS'), 'index.php?option=com_users&view=levels', $vName == 'levels'
			);
			JSubMenuHelper::addEntry(
				JText::_('COM_USERS_SUBMENU_NOTES'), 'index.php?option=com_users&view=notes', $vName == 'notes'
			);

			$extension = JFactory::getApplication()->input->getString('extension');
			JSubMenuHelper::addEntry(
				JText::_('COM_USERS_SUBMENU_NOTE_CATEGORIES'), 'index.php?option=com_categories&extension=com_users.notes', $vName == 'categories' || $extension == 'com_users.notes'
			);
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return  object
	 */
	public static function getActions()
	{
		if (empty(self::$actions))
		{
			$user = JFactory::getUser();
			self::$actions = new JObject;

			$actions = array('core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete');

			foreach ($actions as $action)
			{
				self::$actions->set($action, $user->authorise($action, 'com_users'));
			}
		}

		return self::$actions;
	}

	/**
	 * Get a list of filter options for the blocked state of a user.
	 *
	 * @return  array  An array of JHtmlOption elements.
	 */
	static function getStateOptions()
	{
		// Build the filter options.
		$options = array();
		$options[] = JHtml::_('select.option', '0', JText::_('JENABLED'));
		$options[] = JHtml::_('select.option', '1', JText::_('JDISABLED'));

		return $options;
	}

	/**
	 * Get a list of filter options for the activated state of a user.
	 *
	 * @return  array  An array of JHtmlOption elements.
	 */
	static function getActiveOptions()
	{
		// Build the filter options.
		$options = array();
		$options[] = JHtml::_('select.option', '0', JText::_('COM_USERS_ACTIVATED'));
		$options[] = JHtml::_('select.option', '1', JText::_('COM_USERS_UNACTIVATED'));

		return $options;
	}

	/**
	 * Get a list of the user groups for filtering.
	 *
	 * @return  array  An array of JHtmlOption elements.
	 */
	static function getGroups()
	{
		$db	  = JFactory::getDbo();
		$db->setQuery(
			'SELECT a.id AS value, a.title AS text, COUNT(DISTINCT b.id) AS level' .
			' FROM #__usergroups AS a' .
			' LEFT JOIN ' . $db->quoteName('#__usergroups') . ' AS b ON a.lft > b.lft AND a.rgt < b.rgt' .
			' GROUP BY a.id, a.title, a.lft, a.rgt' .
			' ORDER BY a.lft ASC'
		);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (Exception $e)
		{
			throw $e;
		}

		foreach ($options as &$option)
		{
			$option->text = str_repeat('- ', $option->level) . $option->text;
		}

		return $options;
	}

	/**
	 * Creates a list of range options used in filter select list
	 * used in com_users on users view
	 *
	 * @return  array
	 */
	public static function getRangeOptions()
	{
		$options = array(
			JHtml::_('select.option', 'today', JText::_('COM_USERS_OPTION_RANGE_TODAY')),
			JHtml::_('select.option', 'past_week', JText::_('COM_USERS_OPTION_RANGE_PAST_WEEK')),
			JHtml::_('select.option', 'past_1month', JText::_('COM_USERS_OPTION_RANGE_PAST_1MONTH')),
			JHtml::_('select.option', 'past_3month', JText::_('COM_USERS_OPTION_RANGE_PAST_3MONTH')),
			JHtml::_('select.option', 'past_6month', JText::_('COM_USERS_OPTION_RANGE_PAST_6MONTH')),
			JHtml::_('select.option', 'past_year', JText::_('COM_USERS_OPTION_RANGE_PAST_YEAR')),
			JHtml::_('select.option', 'post_year', JText::_('COM_USERS_OPTION_RANGE_POST_YEAR')),
		);

		return $options;
	}
}

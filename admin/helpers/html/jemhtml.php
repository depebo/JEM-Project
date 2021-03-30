<?php
/**
 * @version 2.3.0
 * @package JEM
 * @copyright (C) 2013-2019 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die();

/**
 * JHtml Class
 */
abstract class JHtmlJemHtml
{
	/**
	 *
	 * @param int $value state value
	 * @param int $i
	 */
	static public function featured($value = 0, $i, $canChange = true)
	{
		// Array of image, iconfont, task, title, action
		$states = array(
				0 => array(
						'disabled.png',
						'fa-star-o', //'fa-circle-o',
						'events.featured',
						'COM_JEM_EVENTS_UNFEATURED',
						'COM_JEM_EVENTS_TOGGLE_TO_FEATURE'
				),
				1 => array(
						'featured.png',
						'fa-star', //'fa-circle',
						'events.unfeatured',
						'COM_JEM_EVENTS_FEATURED',
						'COM_JEM_EVENTS_TOGGLE_TO_UNFEATURE'
				)
		);
		$state = \Joomla\Utilities\ArrayHelper::getValue($states, (int) $value, $states[1]);
		$no_iconfont = (bool)JFactory::getApplication()->isAdmin(); // requires font and css loaded which isn't yet on backend
		$html = JHtml::_('jemhtml.icon', 'com_jem/'.$state[0], 'fa fa-fw fa-lg '.$state[1].' jem-featured-'.$state[1], $state[3], null, $no_iconfont);
		if ($canChange) {
			$html = '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[2] . '\')" title="' . JText::_($state[4]) . '">' . $html . '</a>';
		}

		return $html;
	}

	/**
	 *
	 * @param int $value state value
	 * @param int $i
	 * @deprecated since version 2.1.7
	 */
	static public function toggleStatus($value = 0, $i, $canChange = true)
	{
		if (class_exists('JemHelper')) {
			JemHelper::addLogEntry('Use of this function is deprecated. Use JemHekper::toggleAttendanceStatus() instead.', __METHOD__, JLog::WARNING);
		}

		// Array of image, iconfont, task, title, action
		$states = array(
				0 => array(
						'tick.png',
						'fa-check-circle',
						'attendees.OnWaitinglist',
						'COM_JEM_ATTENDING',
						'COM_JEM_ATTENDING'
				),
				1 => array(
						'publish_y.png',
						'fa-hourglass-half', //'fa-exclamation-circle',
						'attendees.OffWaitinglist',
						'COM_JEM_ON_WAITINGLIST',
						'COM_JEM_ON_WAITINGLIST'
				)
		);
		$state = \Joomla\Utilities\ArrayHelper::getValue($states, (int) $value, $states[1]);
		$no_iconfont = (bool)JFactory::getApplication()->isAdmin(); // requires font and css loaded which isn't yet on backend
		$html = JHtml::_('jemhtml.icon', 'com_jem/'.$state[0], 'fa fa-fw fa-lg '.$state[1].' jem-attendance-status-'.$state[1], $state[3], null, $no_iconfont);
		if ($canChange) {
			$html = '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[2] . '\')" title="' . JText::_($state[4]) . '">' . $html . '</a>';
		}

		return $html;
	}

	/**
	 * Returns text of attendance status, maybe incl. hint to toggle this status.
	 *
	 * @param int  $value status value
	 * @param int  $i registration record id
	 * @param bool $canChange current user is allowed to modify the status
	 * @param bool $print if true show icon AND text for printing
	 * @return string The html snippet.
	 */
	static public function getAttendanceStatusText($value = 0, $i, $canChange = true, $print = false)
	{
		// Array of image, iconfont, task, alt-text, alt-text edit, tooltip
		$states = array(
				-99 => array( // fallback on wrong status value
						'disabled.png',
						'fa-circle-o',
						'',
						'COM_JEM_STATUS_UNKNOWN',
						'COM_JEM_STATUS_UNKNOWN',
						'COM_JEM_ATTENDEES_STATUS_UNKNOWN'
				),
				-1 => array( // not attending, no toggle
						'publish_r.png',
						'fa-times-circle',
						'',
						'COM_JEM_NOT_ATTENDING',
						'COM_JEM_NOT_ATTENDING',
						'COM_JEM_ATTENDEES_NOT_ATTENDING'
				),
				0 => array( // invited, no toggle
						'invited.png',
						'fa-question-circle',
						'',
						'COM_JEM_INVITED',
						'COM_JEM_INVITED',
						'COM_JEM_ATTENDEES_INVITED'
				),
				1 => array( // attending, toggle: waiting list
						'tick.png',
						'fa-check-circle',
						'attendees.OnWaitinglist',
						'COM_JEM_ATTENDING',
						'COM_JEM_ATTENDING_MOVE_TO_WAITINGLIST',
						'COM_JEM_ATTENDEES_ATTENDING'
				),
				2 => array( // on waiting list, toggle: list of attendees
						'publish_y.png',
						'fa-hourglass-half', //'fa-exclamation-circle',
						'attendees.OffWaitinglist',
						'COM_JEM_ON_WAITINGLIST',
						'COM_JEM_ON_WAITINGLIST_MOVE_TO_ATTENDING',
						'COM_JEM_ATTENDEES_ON_WAITINGLIST'
				)
		);

		$state   = \Joomla\Utilities\ArrayHelper::getValue($states, (int) $value, $states[-99]);

		if ($print) {
			$result = JText::_($state[5]);
		} else {
			$result = JText::_($state[$canChange ? 4 : 3]);
		}

		return $result;
	}

	/**
	 * Creates html code to show attendance status, maybe incl. link to toggle this status.
	 *
	 * @param int  $value status value
	 * @param int  $i registration record id
	 * @param bool $canChange current user is allowed to modify the status
	 * @param bool $print if true show icon AND text for printing
	 * @return string The html snippet.
	 */
	static public function toggleAttendanceStatus($value = 0, $i, $canChange = true, $print = false)
	{
		// Array of image, iconfont, task, alt-text, alt-text edit, tooltip
		$states = array(
				-99 => array( // fallback on wrong status value
						'disabled.png',
						'fa-circle-o',
						'',
						'COM_JEM_STATUS_UNKNOWN',
						'COM_JEM_STATUS_UNKNOWN',
						'COM_JEM_ATTENDEES_STATUS_UNKNOWN'
				),
				-1 => array( // not attending, no toggle
						'publish_r.png',
						'fa-times-circle',
						'',
						'COM_JEM_NOT_ATTENDING',
						'COM_JEM_NOT_ATTENDING',
						'COM_JEM_ATTENDEES_NOT_ATTENDING'
				),
				0 => array( // invited, no toggle
						'invited.png',
						'fa-question-circle',
						'',
						'COM_JEM_INVITED',
						'COM_JEM_INVITED',
						'COM_JEM_ATTENDEES_INVITED'
				),
				1 => array( // attending, toggle: waiting list
						'tick.png',
						'fa-check-circle',
						'attendees.OnWaitinglist',
						'COM_JEM_ATTENDING',
						'COM_JEM_ATTENDING_MOVE_TO_WAITINGLIST',
						'COM_JEM_ATTENDEES_ATTENDING'
				),
				2 => array( // on waiting list, toggle: list of attendees
						'publish_y.png',
						'fa-hourglass-half', //fa-exclamation-circle',
						'attendees.OffWaitinglist',
						'COM_JEM_ON_WAITINGLIST',
						'COM_JEM_ON_WAITINGLIST_MOVE_TO_ATTENDING',
						'COM_JEM_ATTENDEES_ON_WAITINGLIST'
				)
		);

		$backend = (bool)JFactory::getApplication()->isAdmin();
		$state   = \Joomla\Utilities\ArrayHelper::getValue($states, (int) $value, $states[-99]);

		if (version_compare(JVERSION, '3.3', 'lt')) {
			// on Joomla! 2.5/3.2 we use good old tooltips
			JHtml::_('behavior.tooltip');
			$attr = 'class="hasTip" title="'.JText::_('COM_JEM_STATUS').'::'.JText::_($state[$canChange ? 4 : 3]).'"';
		} else {
			// on Joomla! 3.3+ we must use the new tooltips
			JHtml::_('bootstrap.tooltip');
			$attr = 'class="hasTooltip" title="'.JHtml::tooltipText(JText::_('COM_JEM_STATUS'), JText::_($state[$canChange ? 4 : 3]), 0).'"';
		}

		if ($print) {
			$html = JHtml::_('jemhtml.icon', 'com_jem/'.$state[0], 'fa fa-fw fa-lg '.$state[1].' jem-attendance-status-'.$state[1], $state[3], 'class="icon-inline-left"', $backend);
			$html .= JText::_($state[5]);
		} elseif ($canChange && !empty($state[2])) {
			$html = JHtml::_('jemhtml.icon', 'com_jem/'.$state[0], 'fa fa-fw fa-lg '.$state[1].' jem-attendance-status-'.$state[1], $state[3], null, $backend);
			if ($backend) {
				$attr .= ' onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[2] . '\')"';
				$url = '#';
			} else {
				$url = JRoute::_('index.php?option=com_jem&view=attendees&amp;task=attendees.attendeetoggle&id='.$i.'&'.JSession::getFormToken().'=1');
			}
			$html = JHtml::_('link', $url, $html, $attr);
		} else {
			$html = JHtml::_('jemhtml.icon', 'com_jem/'.$state[0], 'fa fa-fw fa-lg '.$state[1].' jem-attendance-status-'.$state[1], $state[3], $attr, $backend);
		}

		return $html;
	}

	/**
	 * Creates html code to show an icon, using image or icon font depending on configuration.
	 * Call JHtml::_('jemhtml.icon', $image, $icon, $alt, $attribs, $no_iconfont, $relative)
	 *
	 * @param string  $value status value
	 * @param  string        $image        The relative or absolute URL to use for the `<img>` src attribute.
	 * @param  string        $icon         The CSS class(es) to specify the icon in case icon font will be used.
	 * @param  string        $alt          The alt text.
	 * @param  array|string  $attribs      Attributes to be added to the `<img>` or `<span>` element
	 * @param  boolean       $no_iconfont  Flag if configuration should be ignored and images should be used always (e.g. on backend).
	 * @param  boolean       $relative     Flag if the path to the file is relative to the /media folder (and searches in template).
	 * @return string                      The html snippet.
	 */
	static public function icon($image, $icon, $alt, $attribs = null, $no_iconfont = false, $relative = true)
	{
		$useiconfont = !$no_iconfont && (JemHelper::config()->useiconfont == 1);

		if (!$useiconfont) {
			$html = JHtml::_('image', $image, JText::_($alt), $attribs, $relative);
		} elseif (!empty($attribs)) {
			$html = '<span '.trim((is_array($attribs) ? \Joomla\Utilities\ArrayHelper::toString($attribs) : $attribs) . ' /').'><i class="'.$icon.'"></i></span>';
		} else {
			$html = '<i class="'.$icon.'" aria-hidden="true"></i>';
		}

		return $html;
	}
	/**
	 *
	 * @param int $value state value
	 * @param int $i
	 */
	static public function registra($value = 0, $i, $canChange = true)
	{
		// Array of image, iconfont, task, title, action
		$states = array(
				0 => array(
						'unpublish.png',
						'fa-unpublish',
						'events.registra',
						'COM_JEM_EVENTS_REGISTRATION_CLOSED',
						'COM_JEM_EVENTS_TOGGLE_TO_OPEN_REGISTRATION'
				),
				1 => array(
						'tick.png',
						'fa-tick',
						'events.closeregistration',
						'COM_JEM_EVENTS_REGISTRATION_OPEN',
						'COM_JEM_EVENTS_TOGGLE_TO_CLOSE_REGISTRATION'
				)
		);
		$state = \Joomla\Utilities\ArrayHelper::getValue($states, (int) $value, $states[1]);
		$no_iconfont = (bool)JFactory::getApplication()->isAdmin(); // requires font and css loaded which isn't yet on backend
		$html = JHtml::_('jemhtml.icon', 'com_jem/'.$state[0], 'fa fa-fw fa-lg '.$state[1].' jem-registra-'.$state[1], $state[3], null, $no_iconfont);
		if ($canChange) {
			$html = '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[2] . '\')" title="' . JText::_($state[4]) . '">' . $html . '</a>';
		}

		return $html;
	}
}

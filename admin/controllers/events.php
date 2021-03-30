<?php
/**
 * @version 2.2.2
 * @package JEM
 * @copyright (C) 2013-2017 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Events Controller
 */
class JemControllerEvents extends JControllerAdmin
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 *
	 */
	protected $text_prefix = 'COM_JEM_EVENTS';

	/**
	 * Constructor.
	 *
	 * @param  array  $config  An optional associative array of configuration settings.
	 * @see    JController
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('unfeatured', 'featured');
		$this->registerTask('closeregistration', 'registra');
	}
	/**
	 * Method to toggle the registration setting of a list of events.
	 *
	 * @return void
	 * @since  1.6
	 */
	public function registra()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$user   = JemFactory::getUser();
		$ids    = JFactory::getApplication()->input->get('cid', array(), 'array');
		$values = array('registra' => 1, 'closeregistration' => 0);
		$task   = $this->getTask();
		$value  = \Joomla\Utilities\ArrayHelper::getValue($values, $task, 0, 'int');

		$glob_auth = $user->can('publish', 'event'); // general permission for all events

		// Access checks.
		foreach ($ids as $i => $id)
		{
			if (!$glob_auth && !$user->can('publish', 'event', (int)$id)) {
				// Prune items that you can't change.
				unset($ids[$i]);
				\Joomla\CMS\Factory::getApplication()->enqueueMessage(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'), 'notice');
			}
		}

		if (empty($ids)) {
			\Joomla\CMS\Factory::getApplication()->enqueueMessage(JText::_('JERROR_NO_ITEMS_SELECTED'), 'warning');
		}
		else {
			// Get the model.
			$model = $this->getModel();

			// Publish the items.
			if (!$model->registra($ids, $value)) {
				\Joomla\CMS\Factory::getApplication()->enqueueMessage($model->getError(), 'warning');
			}
		}

		$this->setRedirect('index.php?option=com_jem&view=events');
	}

	/**
	 * Method to toggle the featured setting of a list of events.
	 *
	 * @return void
	 * @since  1.6
	 */
	public function featured()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$user   = JemFactory::getUser();
		$ids    = JFactory::getApplication()->input->get('cid', array(), 'array');
		$values = array('featured' => 1, 'unfeatured' => 0);
		$task   = $this->getTask();
		$value  = \Joomla\Utilities\ArrayHelper::getValue($values, $task, 0, 'int');

		$glob_auth = $user->can('publish', 'event'); // general permission for all events

		// Access checks.
		foreach ($ids as $i => $id)
		{
			if (!$glob_auth && !$user->can('publish', 'event', (int)$id)) {
				// Prune items that you can't change.
				unset($ids[$i]);
				\Joomla\CMS\Factory::getApplication()->enqueueMessage(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'), 'notice');
			}
		}

		if (empty($ids)) {
			\Joomla\CMS\Factory::getApplication()->enqueueMessage(JText::_('JERROR_NO_ITEMS_SELECTED'), 'warning');
		}
		else {
			// Get the model.
			$model = $this->getModel();

			// Publish the items.
			if (!$model->featured($ids, $value)) {
				\Joomla\CMS\Factory::getApplication()->enqueueMessage($model->getError(), 'warning');
			}
		}

		$this->setRedirect('index.php?option=com_jem&view=events');
	}

	/**
	 * Proxy for getModel.
	 *
	 */
	public function getModel($name = 'Event', $prefix = 'JemModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

}
?>
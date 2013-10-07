<?php
/**
 * @version 1.9.1
 * @package JEM
 * @copyright (C) 2013-2013 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;


/**
 * View class for the JEM import screen
 *
 * @package JEM
 *
 */
class JEMViewImport extends JViewLegacy {

	public function display($tpl = null) {
		//Load pane behavior
		jimport('joomla.html.pane');

		//initialise variables
		$document	= JFactory::getDocument();

		//add css and submenu to document
		$document->addStyleSheet(JURI::root().'media/com_jem/css/backend.css');

		// Get data from the model
		$eventfields = $this->get('EventFields');
		$catfields   = $this->get('CategoryFields');
		$venuefields = $this->get('VenueFields');
		$cateventsfields = $this->get('CateventsFields');

		//assign vars to the template
		$this->eventfields 		= $eventfields;
		$this->catfields 		= $catfields;
		$this->venuefields 		= $venuefields;
		$this->cateventsfields 	= $cateventsfields;

		$this->eventlistVersion = $this->get('EventlistVersion');
		$this->eventlistTables 	= $this->get('EventlistTablesCount');
		$this->jemTables 		= $this->get('JemTablesCount');
		$this->existingJemData 	= $this->get('ExistingJemData');

		$jinput = JFactory::getApplication()->input;
		$progress = new stdClass();
		$progress->current 	= $jinput->get->get('current', 0, 'INT');
		$progress->total 	= $jinput->get->get('total', 0, 'INT');
		$progress->table 	= $jinput->get->get('table', '', 'INT');
		$this->progress = $progress;

		// add toolbar
		$this->addToolbar();

		parent::display($tpl);
	}


	/**
	 * Add Toolbar
	 */
	protected function addToolbar()
	{
		//build toolbar
		JToolBarHelper::back();
		JToolBarHelper::title(JText::_('COM_JEM_IMPORT'), 'tableimport');
		JToolBarHelper::help('import', true);

		//Create Submenu
		require_once JPATH_COMPONENT . '/helpers/helper.php';
	}
}
?>
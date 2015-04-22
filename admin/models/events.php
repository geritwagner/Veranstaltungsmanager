<?php
/**
* Model zum Verwalten mehrerer Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla Listen-Model laden
jimport('joomla.application.component.modellist');

/**
* Model zum Verwalten mehrerer Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/
class EventsModelEvents extends JModelList {

	/**
    * @var int $_limitstart Gibt an, wie viele Elemente bei der Listenansicht erst mal übersprungen werden sollen
    */
	protected $_limitstart = 0;

	/**
	 * Konstruktor
	 */
	public function __construct() {
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'Bezeichnung', 'a.Bezeichnung',
				'Ort', 'a.Ort',
				'Datum_von', 'a.Datum_von',
				'Datum_bis', 'a.Datum_bis',
				'NewsTelegramm', 'a.NewsTelegramm',
				'NewsTel_preDays', 'a.NewsTel_preDays',
				'NewsTel_postDays', 'a.NewsTel_postDays',
				'Meisterschaft', 'a.Meisterschaft',
				'ordering', 'a.ordering'
			);
		}

		parent::__construct();

		// Prüfe ob Anzahl der Elemente manuell geändert wurde
		if(!JFactory::getApplication()->input->get('limit')) {
			$db = JFactory::getDBO();

			// Berechne Anzahl der Veranstaltungen nach dem aktuellen Datum
			$query = $this->getListQuery();
			$query ->clear('select');
			$query ->select('COUNT(id)');
			$query ->where('Datum_von >= CURDATE()');

			$db ->setQuery($query);

			$eventsAfterToday = $db->loadResult();

			// Setze aktuelle Seite auf das mit dem momentanen Datum
			$currentPage = ceil($eventsAfterToday/$this->getPagination()->limit);

			// Wenn aktuelle Seite keinen sinnvollen Wert annimmt, auf erste Seite setzen
			if($currentPage <= 0) $currentPage = 1;

			// Setze Bezeichnung im Pagination-Footer-Bereich
			$this->getPagination()->set('pages.current', $currentPage);

			// Setze die zu überspringenden Datenelemente in der Datenbank
			// Erster Befehl nur aus Kompatibilitätsgründen, bei aktueller Version überschreibe this->getStart();
			$this->getPagination()->limitstart = ($currentPage - 1) * $this->getPagination()->limit;
			$this->_limitstart = $this->getPagination()->limitstart;
		}
	}


	protected function populateState($ordering = NULL, $direction = NULL)
	{
		$filter_order 		= JRequest::getCmd('filter_order');
	    $filter_order_Dir 	= JRequest::getCmd('filter_order_Dir');

	    // Load the filter state.
	    $app 	= JFactory::getApplication('administrator');
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		//Omit double (white-)spaces and set state
		$this->setState('filter.search', preg_replace('/\s+/',' ', $search));

		//Filter (dropdown) state
		$state = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

	    $this->setState('filter_order', $filter_order);
	    $this->setState('filter_order_Dir', $filter_order_Dir);
		parent::populateState('a.id', 'DESC');
	}

	/**
	* Methode erzeugt die SQL Query für die Listeneinträge
	*
	* @return string Eine SQL-Abfrage
	*/
	protected function getListQuery() {

		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$user = JFactory::getUser();
		$app = JFactory::getApplication();

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);

		// aus der events Tabelle laden
		$query->from('#__events AS a');

		// Filter by search in title.
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			elseif (stripos($search, 'author:') === 0)
			{
				$search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
				$query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
			}
			else
			{
				$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
				$query->where('(a.Bezeichnung LIKE ' . $search.')');
			}
		}

		// Add the list ordering clause.
		$orderCol		= $this->getState('filter_order');
		$orderDirn 		= $this->getState('filter_order_Dir');

		if(($orderCol == null) || ($orderDirn == null)){
			$orderCol 	= $this->state->get('list.ordering', 'a.id');
			$orderDirn 	= $this->state->get('list.direction', 'desc');
		}

		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		// Absteigend nach Startdatum sortieren

		return $query;
	}

	/**
	* Methode gibt an, ab welchen Element in der DB gestartet werden soll
	*
	* @return int Anzahl der zu überspringenden Elemente (limit)
	*/
	public function getStart() {
		// Prüfe ob Anzahl der Elemente manuell geändert wurde
		if(!JFactory::getApplication()->input->get('limit')) {
			// Rückgabe der im Konstruktor ermittelten limitstart-Variable
			return $this->_limitstart;
		} else {
			return parent::getStart();
		}
	}
}
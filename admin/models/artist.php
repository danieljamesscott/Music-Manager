<?php
/**
 * @package	Music
 * @subpackage	Artist
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @copyright   Copyright (C) 2009 Daniel Scott (http://danieljamesscott.org). All rights reserved. 
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

/**
 * Music Component Artist Model
 */
class MusicModelArtist extends JModel {
  var $_id = null;
  var $_data = null;

  /**
   * Constructor
   */
  function __construct() {
    parent::__construct();

    $array = JRequest::getVar('cid', array(0), '', 'array');
    $edit	= JRequest::getVar('edit',true);
    if($edit) {
      $this->setId((int)$array[0]);
    }
  }

  /**
   * Method to set the artist identifier
   *
   * @access	public
   * @param	int Artist identifier
   */
  function setId($id) {
    // Set artist id and wipe data
    $this->_id		= $id;
    $this->_data	= null;
  }

  /**
   * Method to get a artist
   *
   * @since 1.5
   */
  function &getData() {
    // Load the artist data
    if ($this->_loadData()) {
      // Initialize some variables
      $user = &JFactory::getUser();

    } else {
      $this->_initData();
    }

    return $this->_data;
  }

  /**
   * Tests if artist is checked out
   *
   * @access	public
   * @param	int	A user id
   * @return	boolean	True if checked out
   * @since	1.5
   */
  function isCheckedOut( $uid=0 ) {
    if ($this->_loadData()) {
      if ($uid) {
        return ($this->_data->checked_out && $this->_data->checked_out != $uid);
      } else {
        return $this->_data->checked_out;
      }
    }
  }

  /**
   * Method to checkin/unlock the artist
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function checkin() {
    if ($this->_id) {
      $artist = & $this->getTable();
      if(! $artist->checkin($this->_id)) {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }
    return false;
  }

  /**
   * Method to checkout/lock the artist
   *
   * @access	public
   * @param	int	$uid	User ID of the user checking the article out
   * @return	boolean	True on success
   * @since	1.5
   */
  function checkout($uid = null) {
    if ($this->_id) {
      // Make sure we have a user id to checkout the article with
      if (is_null($uid)) {
        $user	=& JFactory::getUser();
        $uid	= $user->get('id');
      }
      // Lets get to it and checkout the thing...
      $artist = & $this->getTable();
      if(!$artist->checkout($uid, $this->_id)) {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }

      return true;
    }
    return false;
  }

  /**
   * Method to store the artist
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function store($data) {
    $row =& $this->getTable();

    // Bind the form fields to the web link table
    if (!$row->bind($data)) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    // Create the timestamp for the date
    //		$row->date = gmdate('Y-m-d H:i:s');

    // if new item, order last in appropriate group
    if (!$row->id) {
      //      $where = 'id = ' . (int) $row->id ;
      $row->ordering = $row->getNextOrder( $where );
    }

    // Make sure the artist entry is valid
    if (!$row->check()) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    // Store the artist table to the database
    if (!$row->store()) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    return true;
  }

  /**
   * Method to remove a artist
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function delete($artist_id = array()) {
    $result = false;

    if (count( $artist_id )) {
      JArrayHelper::toInteger($artist_id);
      $artist_ids = implode( ',', $artist_id );
      $query = 'DELETE FROM #__artists'
        . ' WHERE id IN ( '.$artist_ids.' )';
      $this->_db->setQuery( $query );
      if(!$this->_db->query()) {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }

    return true;
  }

  /**
   * Method to (un)publish a artist
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function publish($artist_id = array(), $publish = 1) {
    $user 	=& JFactory::getUser();

    if (count( $artist_id )) {
      JArrayHelper::toInteger($artist_id);
      $artist_ids = implode( ',', $artist_id );

      $query = 'UPDATE #__artists'
        . ' SET published = '.(int) $publish
        . ' WHERE id IN ( '.$artist_ids.' )'
        . ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )'
        ;
      $this->_db->setQuery( $query );
      if (!$this->_db->query()) {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }

    return true;
  }

  /**
   * Method to move a artist
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function move($direction) {
    $row =& $this->getTable();
    if (!$row->load($this->_id)) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    if (!$row->move( $direction, 'published >= 0 ' )) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }
    return true;
  }

  /**
   * Method to move a artist
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function saveorder($artist_id = array(), $order) {
    $row =& $this->getTable();
    $groupings = array();

    // update ordering values
    for( $i=0; $i < count($artist_id); $i++ ) {
      $row->load( (int) $artist_id[$i] );

      if ($row->ordering != $order[$i]) {
        $row->ordering = $order[$i];
        if (!$row->store()) {
          $this->setError($this->_db->getErrorMsg());
          return false;
        }
      }
    }

    // Reorder entire table for now....
    $row->reorder();

    return true;
  }

  /**
   * Method to load content artist data
   *
   * @access	private
   * @return	boolean	True on success
   * @since	1.5
   */
  function _loadData() {
    // Lets load the content if it doesn't already exist
    if (empty($this->_data)) {
      $query = 'SELECT * '.
        ' FROM #__artists AS w' .
        ' WHERE w.id = '.(int) $this->_id;
      $this->_db->setQuery($query);
      $this->_data = $this->_db->loadObject();
      return (boolean) $this->_data;
    }
    return true;
  }

  /**
   * Method to initialise the artist data
   *
   * @access	private
   * @return	boolean	True on success
   * @since	1.5
   */
  function _initData() {
    // Lets load the content if it doesn't already exist
    if (empty($this->_data)) {
      $artist = new stdClass();
      $artist->id				= 0;
      $artist->name				= null;
      $artist->alias				= null;
      $artist->description			= null;

      // Artist fields
      $artist->picture				= null;

      // Required fields
      $artist->published			= 0;
      $artist->checked_out			= 0;
      $artist->checked_out_time			= 0;
      $artist->ordering				= 0;
      $artist->params				= null;
      $this->_data				= $artist;
      return (boolean) $this->_data;
    }
    return true;
  }
}
?>

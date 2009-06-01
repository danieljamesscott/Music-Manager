<?php
/**
 * @package	Music
 * @subpackage	Album
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
 * Music Component Album Model
 */
class MusicModelAlbum extends JModel {
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
   * Method to set the album identifier
   *
   * @access	public
   * @param	int Album identifier
   */
  function setId($id) {
    // Set album id and wipe data
    $this->_id		= $id;
    $this->_data	= null;
  }

  /**
   * Method to get an album
   *
   * @since 1.5
   */
  function &getData() {
    // Load the album data
    if ($this->_loadData()) {
      // Initialize some variables
      $user = &JFactory::getUser();

      // Check to see if the artist is published
      if (!$this->_data->artist_pub) {
        JError::raiseError( 404, JText::_("Resource Not Found") );
        return;
      }

      // Check whether artost access level allows access
      if ($this->_data->artist_access > $user->get('arid', 0)) {
        JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
        return;
      }
    } else {
      $this->_initData();
    }

    return $this->_data;
  }

  /**
   * Tests if album is checked out
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
   * Method to checkin/unlock the album
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function checkin() {
    if ($this->_id) {
      $album = & $this->getTable();
      if(! $album->checkin($this->_id)) {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }
    return false;
  }

  /**
   * Method to checkout/lock the album
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
      $album = & $this->getTable();
      if(!$album->checkout($uid, $this->_id)) {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }

      return true;
    }
    return false;
  }

  /**
   * Method to store the album
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function store($data) {
    $row =& $this->getTable();

    // Bind the form fields to the album table
    if (!$row->bind($data)) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    // if new item, order last in appropriate group
    if (!$row->id) {
      $where = 'artistid = ' . (int) $row->artistid ;
      $row->ordering = $row->getNextOrder( $where );
    }

    // Make sure the album table is valid
    if (!$row->check()) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    // Store the album table to the database
    if (!$row->store()) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    return true;
  }

  /**
   * Method to remove a album
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function delete($album_id = array()) {
    $result = false;

    if (count( $album_id )) {
      JArrayHelper::toInteger($album_id);
      $album_ids = implode( ',', $album_id );
      $query = 'DELETE FROM #__albums'
        . ' WHERE id IN ( '.$album_ids.' )';
      $this->_db->setQuery( $query );
      if(!$this->_db->query()) {
        $this->setError($this->_db->getErrorMsg());
        return false;
      }
    }

    return true;
  }

  /**
   * Method to (un)publish an album
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function publish($album_id = array(), $publish = 1) {
    $user 	=& JFactory::getUser();

    if (count( $album_id )) {
      JArrayHelper::toInteger($album_id);
      $album_ids = implode( ',', $album_id );

      $query = 'UPDATE #__albums'
        . ' SET published = '.(int) $publish
        . ' WHERE id IN ( '.$album_ids.' )'
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
   * Method to move an album
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

    if (!$row->move( $direction, ' artistid = '.(int) $row->artistid.' AND published >= 0 ' )) {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    return true;
  }

  /**
   * Method to move an album
   *
   * @access	public
   * @return	boolean	True on success
   * @since	1.5
   */
  function saveorder($album_id = array(), $order) {
    $row =& $this->getTable();
    $groupings = array();

    // update ordering values
    for( $i=0; $i < count($album_id); $i++ ) {
      $row->load( (int) $album_id[$i] );
      // track artists
      $groupings[] = $row->artistid;

      if ($row->ordering != $order[$i]) {
        $row->ordering = $order[$i];
        if (!$row->store()) {
          $this->setError($this->_db->getErrorMsg());
          return false;
        }
      }
    }

    // execute updateOrder for each parent group
    $groupings = array_unique( $groupings );
    foreach ($groupings as $group){
      $row->reorder('artistid = '.(int) $group);
    }

    return true;
  }

  /**
   * Method to load content album data
   *
   * @access	private
   * @return	boolean	True on success
   * @since	1.5
   */
  function _loadData() {
    // Lets load the content if it doesn't already exist
    if (empty($this->_data)) {
      $query = 'SELECT w.*,'.
        ' ar.published AS artist_pub, ar.access AS artist_access'.
        ' FROM #__albums AS w' .
        ' LEFT JOIN #__artists AS ar ON ar.id = w.artistid' .
        ' WHERE w.id = '.(int) $this->_id;

      $this->_db->setQuery($query);
      $this->_data = $this->_db->loadObject();
      return (boolean) $this->_data;
    }
    return true;
  }

  /**
   * Method to initialise the album data
   *
   * @access	private
   * @return	boolean	True on success
   * @since	1.5
   */
  function _initData() {
    // Lets load the content if it doesn't already exist
    if (empty($this->_data)) {
      $album = new stdClass();
      $album->id				= 0;
      $album->name				= null;
      $album->alias				= null;

      // Album fields
      $album->creationyear			= 0;
      $album->albumart_front			= null;
      $album->albumart_back			= null;
      $album->artistid			= 0;
      $album->description			= null;

      // Required fields
      $album->published			= 0;
      $album->checked_out			= 0;
      $album->checked_out_time		= 0;
      $album->ordering			= 0;
      $album->params				= null;
      $this->_data				= $album;
      return (boolean) $this->_data;
    }
    return true;
  }
}
?>

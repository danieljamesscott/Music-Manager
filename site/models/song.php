<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');
jimport('administrator.components.com_song.tables');

/**
 * Song Model
 */
class MusicModelSong extends JModelItem {
  /**
   * Method to build an SQL query to load the song data.
   *
   * @return      string  An SQL query
   */
  function getData() {
    // Create a new query object.
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    // Select some fields
    $query->select(' id, alias, name, number, filename, published, checked_out, checked_out_time, editor, ordering, params, user_id, access, email_to, description');

    $query->from('#__music_song');

    // Get the song ID from the request
    $id = JRequest::getInt('id');
    $query->where("#__music_song.id = $id");
    $db->setQuery($query);
    // Return an object containing the row
    return($db->loadObject());
  }
}

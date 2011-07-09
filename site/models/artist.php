<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');
jimport('administrator.components.com_music.tables');

/**
 * Artist Model
 */
class MusicModelArtist extends JModelList {
  /**
   * Method to build an SQL query to load the list data.
   *
   * @return      string  An SQL query
   */
  protected function getListQuery() {
    // Create a new query object.
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    // Select some fields
    $query->select('#__music_artist.id,#__music_artist.alias,#__music_artist.name,#__music_artist.published,#__music_artist.checked_out,#__music_artist.checked_out_time,#__music_artist.editor,#__music_artist.ordering,#__music_artist.params,#__music_artist.access,#__music_album.id as album_id,#__music_album.name as album_name,#__music_album.creationyear as creationyear,#__music_album.albumart_front as albumart_front,#__music_album.albumart_back as albumart_back');
    // From the artistalbums table
    $query->from('#__music_artistalbums');
    $query->leftJoin('#__music_artist on (#__music_artistalbums.artist_id = #__music_artist.id)');
    $query->leftJoin('#__music_album on (#__music_artistalbums.album_id = #__music_album.id)');

    // Get the artist ID from the request
    $id = JRequest::getInt('id');
    $query->where("#__music_artist.id = $id");
    return $query;
  }
}


<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');
jimport('administrator.components.com_music.tables');

/**
 * Music Model
 */
class MusicModelAlbum extends JModelList {
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
    $query->select('#__music_albumsongs.id as song_id, #__music_albumsongs.album_id, #__music_album.name as name, #__music_album.albumart_front as albumart_front, #__music_album.albumart_back as albumart_back, #__music_album.creationyear as creationyear, #__music_albumsongs.song_id, #__music_song.name as song_name, #__music_song.number as song_number, #__music_song.filename as song_filename, #__music_albumsongs.published,#__music_albumsongs.checked_out,#__music_albumsongs.checked_out_time,#__music_albumsongs.editor,#__music_albumsongs.ordering,#__music_albumsongs.params,#__music_albumsongs.access');

    // From the album table
    $query->from('#__music_album');
    $query->leftJoin('#__music_albumsongs on (#__music_albumsongs.album_id = #__music_album.id)');
    $query->leftJoin('#__music_song on (#__music_albumsongs.song_id = #__music_song.id)');

    // Get the album ID from the request
    $id = JRequest::getInt('id');
    $query->where("#__music_album.id = $id");
    return $query;
  }
}

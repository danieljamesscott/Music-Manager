<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * AlbumSongs Model
 */
class MusicModelAlbumSongs extends JModelList {
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
    $query->select('#__music_albumsongs.id, #__music_albumsongs.album_id, #__music_album.name as album_name, #__music_albumsongs.song_id, #__music_song.name as song_name, #__music_albumsongs.published,#__music_albumsongs.checked_out,#__music_albumsongs.checked_out_time,#__music_albumsongs.editor,#__music_albumsongs.ordering,#__music_albumsongs.params,#__music_albumsongs.access');

    // From the music table
    $query->from('#__music_albumsongs');
    $query->leftJoin('#__music_album on (#__music_albumsongs.album_id = #__music_album.id)');
    $query->leftJoin('#__music_song on (#__music_albumsongs.song_id = #__music_song.id)');
    return $query;
  }
}
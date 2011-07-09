<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * ArtistAlbums Model
 */
class MusicModelArtistAlbums extends JModelList {
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
    $query->select('#__music_artistalbums.id, #__music_artistalbums.artist_id, #__music_artist.name as artist_name, #__music_artistalbums.album_id, #__music_album.name as album_name, #__music_artistalbums.published,#__music_artistalbums.checked_out,#__music_artistalbums.checked_out_time,#__music_artistalbums.editor,#__music_artistalbums.ordering,#__music_artistalbums.params,#__music_artistalbums.access');

    $query->from('#__music_artistalbums');
    $query->leftJoin('#__music_artist on (#__music_artistalbums.artist_id = #__music_artist.id)');
    $query->leftJoin('#__music_album on (#__music_artistalbums.album_id = #__music_album.id)');
    return $query;
  }
}
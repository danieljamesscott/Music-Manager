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
 * @package		Joomla
 */
class MusicModelArtist extends JModel
{
	/**
	 * Builds the query to select artists
	 * @param array
	 * @return string
	 * @access protected
	 */
	function _getArtistsQuery( &$options )
	{
		// TODO: Cache on the fingerprint of the arguments
		$db		=& JFactory::getDBO();
		// aid?
		$aid	= @$options['aid'];

		// ar. = album table
		$wheres[] = 'cc.published = 1';
		$wheres[] = 'cc.id = ' . @$options['artist_id'];

		if ($aid !== null)
		{
			$wheres[] = 'cc.access <= ' . (int) $aid;
		}

		$groupBy	= 'cc.id';
		$orderBy	= 'cc.ordering' ;

		/*
		 * Query to retrieve all artists that are published.
		 */
		$query = 'SELECT cc.*'.
				' FROM #__artists AS cc'.
				' WHERE ' . implode( ' AND ', $wheres ) .
				' GROUP BY ' . $groupBy .
				' ORDER BY ' . $orderBy;

		//echo $query;
		return $query;
	}

	/**
	 * Builds the query to select album items
	 * @param array
	 * @return string
	 * @access protected
	 */
	function _getAlbumsQuery( &$options )
	{
		// TODO: Cache on the fingerprint of the arguments
		$db		=& JFactory::getDBO();
		$aid		= @$options['aid'];
		$artistID	= @$options['artist_id'];
		$groupBy	= @$options['group by'];
		$orderBy	= @$options['order by'];

		$select = 'cd.*, ' .
				'cc.name AS artist_name, cc.description,'.
				' CASE WHEN CHAR_LENGTH(cd.alias) THEN CONCAT_WS(\':\', cd.id, cd.alias) ELSE cd.id END as slug ';
		$from	= '#__albums AS cd';

		$joins[] = 'INNER JOIN #__artists AS cc on cd.artistid = cc.id';

		$wheres[] = 'cc.published = 1';
		$wheres[] = 'cd.published = 1';
		$wheres[] = 'cc.id = ' . @$options['artist_id'];

		if ($aid !== null)
		{
			$wheres[] = 'cc.access <= ' . (int) $aid;
			$wheres[] = 'cd.access <= ' . (int) $aid;
		}

		/*
		 * Query to retrieve all albums under the albums
		 * section and that are published.
		 */
		$query = 'SELECT ' . $select .
				' FROM ' . $from .
				' ' . implode ( ' ', $joins ) .
				' WHERE ' . implode( ' AND ', $wheres ) .
				($groupBy ? ' GROUP BY ' . $groupBy : '').
				($orderBy ? ' ORDER BY ' . $orderBy : '');

		return $query;
	}

	/**
	 * Gets a list of artists
	 * @param array
	 * @return array
	 */
	function getArtists( $options=array() )
	{
		$query	= $this->_getArtistsQuery( $options );
		return $this->_getList( $query, @$options['limitstart'], @$options['limit'] );
	}

	/**
	 * Gets the count of the artists for the given options
	 * @param array
	 * @return int
	 */
	function getArtistCount( $options=array() )
	{
		$query	= $this->_getArtistQuery( $options );
		return $this->_getListCount( $query );
	}

	/**
	 * Gets a list of albums
	 * @param array
	 * @return array
	 */
	function getAlbums( $options=array() )
	{
		$query	= $this->_getAlbumsQuery( $options );
		return $this->_getList( $query, @$options['limitstart'], @$options['limit'] );
	}

	/**
	 * Gets the count of the albums for the given options
	 * @param array
	 * @return int
	 */
	function getAlbumCount( $options=array() )
	{
		$query	= $this->_getAlbumsQuery( $options );
		return $this->_getListCount( $query );
	}
}
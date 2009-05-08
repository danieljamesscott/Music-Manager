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
 * @package		Joomla
 * @subpackage	Song
 */
class MusicModelAlbum extends JModel
{
	/**
	 * Builds the query to select albums
	 * @param array
	 * @return string
	 * @access protected
	 */
	function _getAlbumsQuery( &$options )
	{
		// TODO: Cache on the fingerprint of the arguments
		$db		=& JFactory::getDBO();
		// aid?
		$aid	= @$options['aid'];

		// a. = song table
		$wheres[] = 'a.published = 1';
		$wheres[] = 'cc.published = 1';
		$wheres[] = 'cc.id = ' . @$options['album_id'];

		if ($aid !== null)
		{
			$wheres[] = 'a.access <= ' . (int) $aid;
			$wheres[] = 'cc.access <= ' . (int) $aid;
		}

		$groupBy	= 'cc.id';
		$orderBy	= 'cc.ordering' ;

		/*
		 * Query to retrieve all albums that are published.
		 */
		$query = 'SELECT cc.*, COUNT( a.id ) AS numlinks, a.id as cid'.
				' FROM #__albums AS cc'.
				' LEFT JOIN #__songs AS a ON a.albumid = cc.id'.
				' LEFT JOIN #__artists AS ar ON ar.id = cc.artistid'.
				' WHERE ' . implode( ' AND ', $wheres ) .
				' GROUP BY ' . $groupBy .
				' ORDER BY ' . $orderBy;

		//echo $query;
		return $query;
	}

	/**
	 * Builds the query to select song items
	 * @param array
	 * @return string
	 * @access protected
	 */
	function _getSongsQuery( &$options )
	{
		// TODO: Cache on the fingerprint of the arguments
		$db		=& JFactory::getDBO();
		$aid		= @$options['aid'];
		$albumID	= @$options['album_id'];
		$groupBy	= @$options['group by'];
		$orderBy	= @$options['order by'];

		$select = 'cd.*, ' .
				'cc.name AS album_name, cc.description,'.
				' CASE WHEN CHAR_LENGTH(cd.alias) THEN CONCAT_WS(\':\', cd.id, cd.alias) ELSE cd.id END as slug ';
		$from	= '#__songs AS cd';

		$joins[] = 'INNER JOIN #__albums AS cc on cd.albumid = cc.id';

		$wheres[] = 'cc.published = 1';
		$wheres[] = 'cd.published = 1';
		$wheres[] = 'cc.id = ' . @$options['album_id'];

		if ($aid !== null)
		{
			$wheres[] = 'cc.access <= ' . (int) $aid;
			$wheres[] = 'cd.access <= ' . (int) $aid;
		}

		/*
		 * Query to retrieve all songs under the songs
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
		$query	= $this->_getAlbumQuery( $options );
		return $this->_getListCount( $query );
	}

	/**
	 * Gets a list of songs
	 * @param array
	 * @return array
	 */
	function getSongs( $options=array() )
	{
		$query	= $this->_getSongsQuery( $options );
		return $this->_getList( $query, @$options['limitstart'], @$options['limit'] );
	}

	/**
	 * Gets the count of the songs for the given options
	 * @param array
	 * @return int
	 */
	function getSongCount( $options=array() )
	{
		$query	= $this->_getSongsQuery( $options );
		return $this->_getListCount( $query );
	}
}
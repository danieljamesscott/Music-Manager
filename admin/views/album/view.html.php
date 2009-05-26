<?php
/**
* @package     Music
* @subpackage  Album
* @copyright   Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @copyright   Copyright (C) 2009 Daniel Scott (http://danieljamesscott.org). All rights reserved. 
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Album component
 *
 * @static
 * @package	Music
 * @subpackage	Album
 * @since 1.0
 */
class MusicViewAlbum extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		if($this->getLayout() == 'default') {
			$this->_displayForm($tpl);
			return;
		}

		//get the album
		$album =& $this->get('data');

		if ($album->url) {
			// redirects to url if matching id found
			$mainframe->redirect($album->url);
		}

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		global $mainframe, $option;

		$db	=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();


		$lists = array();

		//get the album
		$album	=& $this->get('data');
		$isNew		= ($album->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The album' ), $album->name );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout( $user->get('id') );
		}
		else
		{
			// initialise new record
			$album->published = 1;
			$album->approved 	= 1;
			$album->order 	= 0;
			$album->id 	= JRequest::getVar( 'id', 0, 'post', 'int' );
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, name AS text'
			. ' FROM #__albums'
		        . ' WHERE artistid = ' . (int) $album->artistid
			. ' ORDER BY ordering';

		$lists['ordering'] 			= JHTML::_('list.specificordering',  $album, $album->id, $query, 1 );

		// build list of artists
		$db =& JFactory::getDBO();
		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__artists'
		. ' WHERE published = 1'
		. ' ORDER BY ordering'
		;
		$db->setQuery( $query );
		$artists[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Select an Artist' ) .' -' );
		$artists = array_merge( $artists, $db->loadObjectList() );
		$lists['artistid'] = JHTML::_('select.genericlist',   $artists, 'artistid', 'class="inputbox" size=1', 'value', 'text', intval( $album->artistid ) );

		// build the html select list
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $album->published );

		//clean album data
		jimport('joomla.filter.output');
		JFilterOutput::objectHTMLSafe( $album, ENT_QUOTES, 'description' );

		if ( !JFolder::create(JPATH_ROOT.DS."images".DS."albumart") ) {
		  echo "Failed to create directory images/albumart";
		  $mainframe->close();
		}

		$lists['albumart_front'] 			= JHTMLList::images('albumart_front', $album->albumart_front, '', 'images'.DS.'albumart' );
		$lists['albumart_back'] 			= JHTMLList::images('albumart_back', $album->albumart_back, '', 'images'.DS.'albumart' );

		$file 	= JPATH_COMPONENT.DS.'models'.DS.'album.xml';
		$params = new JParameter( $album->params, $file );

		$this->assignRef('lists',		$lists);
		$this->assignRef('album',		$album);
		$this->assignRef('params',		$params);

		parent::display($tpl);
	}
}
?>

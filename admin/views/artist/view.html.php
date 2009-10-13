<?php
/**
* @package     Music
* @subpackage  Artist
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
 * HTML View class for the Artist component
 *
 * @package	Music
 * @subpackage	Artist
 * @since 1.0
 */
class MusicViewArtist extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		if($this->getLayout() == 'default') {
			$this->_displayForm($tpl);
			return;
		}

		//get the artist
		$artist =& $this->get('data');

		if ($artist->url) {
			// redirects to url if matching id found
			$mainframe->redirect($artist->url);
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

		//get the artist
		$artist	=& $this->get('data');
		$isNew		= ($artist->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The artist' ), $artist->name );
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
			$artist->published = 1;
			$artist->approved 	= 1;
			$artist->order 	= 0;
			$artist->id 	= JRequest::getVar( 'id', 0, 'post', 'int' );
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, name AS text'
			. ' FROM #__artists'
			. ' ORDER BY ordering';

		$lists['ordering'] 			= JHTML::_('list.specificordering',  $artist, $artist->id, $query, 1 );

		// build the html select list
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $artist->published );

		//clean artist data
		jimport('joomla.filter.output');
		JFilterOutput::objectHTMLSafe( $artist, ENT_QUOTES, 'description' );

		if ( !JFolder::create(JPATH_ROOT.DS."images".DS."artists") ) {
		  echo "Failed to create directory images/artists";
		  $mainframe->close();
		}

		$lists['artists'] 			= JHTMLList::images('picture', $artist->picture, '', 'images'.DS.'artists' );

		$file 	= JPATH_COMPONENT.DS.'models'.DS.'artist.xml';
		$params = new JParameter( $artist->params, $file );

		$this->assignRef('lists',		$lists);
		$this->assignRef('artist',		$artist);
		$this->assignRef('params',		$params);

		parent::display($tpl);
	}
}
?>

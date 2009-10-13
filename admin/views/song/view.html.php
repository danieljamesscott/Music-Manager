<?php
/**
* @package     Music
* @subpackage  Song
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
 * HTML View class for the Song component
 *
 * @package	Music
 * @subpackage	Song
 * @since 1.0
 */
class MusicViewSong extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		if($this->getLayout() == 'default') {
			$this->_displayForm($tpl);
			return;
		}

		//get the song
		$song =& $this->get('data');

		if ($song->url) {
			// redirects to url if matching id found
			$mainframe->redirect($song->url);
		}

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();


		$lists = array();

		//get the song
		$song	=& $this->get('data');

		$isNew		= ($song->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut( $user->get('id') )) {
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The song' ), $song->title );
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
			$song->published = 1;
			$song->approved 	= 1;
			$song->order 	= 0;
			$song->albumid 	= JRequest::getVar( 'albumid', 0, 'post', 'int' );
		}

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, name AS text'
			. ' FROM #__songs'
			. ' WHERE albumid = ' . (int) $song->albumid
			. ' ORDER BY ordering';

		$lists['ordering'] 			= JHTML::_('list.specificordering',  $song, $song->id, $query, 1 );

		// build list of albums
		$db =& JFactory::getDBO();
		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__albums'
		. ' WHERE published = 1'
		. ' ORDER BY ordering'
		;
		$db->setQuery( $query );
		$albums[] = JHTML::_('select.option',  '0', '- '. JText::_( 'Select an Album' ) .' -' );
		$albums = array_merge( $albums, $db->loadObjectList() );
		$lists['albumid'] = JHTML::_('select.genericlist',   $albums, 'albumid', 'class="inputbox" size=1', 'value', 'text', intval( $song->albumid ) );

		// build the html select list
		$lists['published'] 		= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $song->published );

		//clean song data
		jimport('joomla.filter.output');
		JFilterOutput::objectHTMLSafe( $song, ENT_QUOTES, 'description' );

		//Then we create the subfolder called songs
		if ( !JFolder::create(JPATH_ROOT.DS."images".DS."songs") ) {
		  echo "Failed to create directory images/songs";
		  $mainframe->close();
		}
		// Build list of mp3s
                $songFiles = JFolder::files(JPATH_SITE.DS."images".DS."songs", '.', true, true);
                $songs = array(JHTML::_('select.option',  '', '- '. JText::_('Select Song') .' -'));
                foreach ( $songFiles as $file ) {
                  // Strip off root
                  $file = str_replace(JPATH_ROOT.DS."images".DS."songs".DS, '', $file);
		  $file = JPath::clean($file);
		  $songs[] = JHTML::_('select.option',  $file );
                }
                $lists['mp3'] = JHTML::_('select.genericlist',  $songs, 'mp3', 'class="inputbox" size="1" '. null, 'value', 'text', $song->mp3 );

		$file 	= JPATH_COMPONENT.DS.'models'.DS.'song.xml';
		$params = new JParameter( $song->params, $file );

		$this->assignRef('lists',		$lists);
		$this->assignRef('song',		$song);
		$this->assignRef('params',		$params);

		parent::display($tpl);
	}
}
?>

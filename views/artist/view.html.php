<?php
/**
 * @package	Music
 * @subpackage	Artist
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @copyright	Copyright (C) 2009 Daniel Scott (http://danieljamesscott.org). All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');

/**
 * @package		Joomla
 */
class MusicViewArtist extends JView
{
  function display($tpl = null)
  {
    global $mainframe, $option;

    $user	= &JFactory::getUser();
    $uri 	=& JFactory::getURI();
    $model	= &$this->getModel();
    $document	=& JFactory::getDocument();

    $pparams = &JComponentHelper::getParams('com_music');

    // Selected Request vars
    $artistId		= JRequest::getVar('artist_id',0,'', 'int');
    $limit		= JRequest::getVar('limit',$mainframe->getCfg('list_limit'),'', 'int');
    $limitstart		= JRequest::getVar('limitstart',0,'', 'int');
    $filter_order	= JRequest::getVar('filter_order','cd.ordering','', 'cmd');
    $filter_order_Dir	= JRequest::getVar('filter_order_Dir','ASC','','word');

    // query options
    $options['artist_id']	= $artistId;
    $options['limit']		= $limit;
    $options['limitstart']	= $limitstart;
    $options['order by']	= "$filter_order $filter_order_Dir, cd.ordering";

    $artists = $model->getArtists( $options );
    // Search using ID, so should only be one artist returned
    $artist =& $artists[0];

    // Add in specific parameters
    $artist->params = new JParameter($artist->params);
    $pparams->merge($artist->params);

    // Get the parameters of the active menu item
    $menus = &JSite::getMenu();
    $menu = $menus->getActive();

    if (is_object( $menu )) {
      $menu_params = new JParameter( $menu->params );
      $pparams->merge($menu_params);
      if (!$menu_params->get('page_title')) {
	$pparams->set('page_title', $artist->name);
      }
    } else {
      $pparams->set('page_title', $artist->name);
    }

    // Set the page title and pathway
    if ($pparams->get('page_title')) {
      // Add the artist breadcrumbs item
      $document->setTitle(JText::_('Music').' - '.$pparams->get('page_title'));
    } else {
      $document->setTitle(JText::_('Music'));
    }

    $albums = $model->getAlbums( $options );
    $total = $model->getAlbumCount( $options );

    // Clean picture filename
    $artist->cleaned_picture = JFile::makeSafe($artist->picture);

    //prepare albums
    $k = 0;
    for($i = 0; $i <  count( $albums ); $i++) {
	$albums[$i]->album_link = JRoute::_('index.php?option=com_music&view=album&album_id=' . $albums[$i]->id);
	$albums[$i]->album_name = $albums[$i]->name;
    }

    if ($artist == null) {
      $db = &JFactory::getDBO();
      $artist =& JTable::getInstance( 'artist' );
    }

    // table ordering
    if ( $filter_order_Dir == 'DESC' ) {
      $lists['order_Dir'] = 'ASC';
    } else {
      $lists['order_Dir'] = 'DESC';
    }
    $lists['order'] = $filter_order;
    $selected = '';

    jimport('joomla.html.pagination');
    $pagination = new JPagination($total, $limitstart, $limit);

    $this->assignRef('items',		$albums);
    $this->assignRef('lists',		$lists);
    $this->assignRef('pagination',	$pagination);
    $this->assignRef('artist',		$artist);
    $this->assignRef('params',		$pparams);

    $this->assign('action',		$uri->toString());

    parent::display($tpl);
  }
}
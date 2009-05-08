<?php
/**
 * @package	Music
 * @subpackage	Album
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
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

/**
 * @package		Joomla
 * @subpackage	Songs
 */
class MusicViewAlbum extends JView
{
  function display($tpl = null)
  {
    global $mainframe, $option;

    $user	= &JFactory::getUser();
    $uri 	=& JFactory::getURI();
    $model	= &$this->getModel();
    $document	=& JFactory::getDocument();

    $pparams = &$mainframe->getPageParameters('com_music');

    // Selected Request vars
    $albumId		= JRequest::getVar('cid',0,'', 'int');
    $limit		= JRequest::getVar('limit',$mainframe->getCfg('list_limit'),'', 'int');
    $limitstart		= JRequest::getVar('limitstart',0,'', 'int');
    $filter_order	= JRequest::getVar('filter_order','cd.ordering','', 'cmd');
    $filter_order_Dir	= JRequest::getVar('filter_order_Dir','ASC','','word');

    // query options
    $options['aid'] 		= $user->get('aid', 0);
    $options['album_id']	= $albumId;
    $options['limit']		= $limit;
    $options['limitstart']	= $limitstart;
    $options['order by']	= "$filter_order $filter_order_Dir, cd.ordering";

    $albums = $model->getAlbums( $options );
    // Search using ID, so should only be one album returned
    $album =& $albums[0];

    // Add in specific parameters
    $pparams->merge($album->params);

    // Get the parameters of the active menu item
    $menus = &JSite::getMenu();
    $menu = $menus->getActive();

    if (is_object( $menu )) {
      $menu_params = new JParameter( $menu->params );
      $pparams->merge($menu->params);
    }

    if ($menu) {
      //      print_r($menu->getParams());
      //      $pparams->merge($menu->getParams($menuitemid));
    }

    $songs = $model->getSongs( $options );
    $total = $model->getSongCount( $options );

    //prepare songs
    $k = 0;
    for($i = 0; $i <  count( $songs ); $i++) {
      $song =& $songs[$i];
      //			$song->link	   = JRoute::_('index.php?option=com_music&view=song&id='.$song->slug);
      $song->odd   = $k;
      $song->count = $i;
      $k = 1 - $k;
    }

    if ($album == null) {
      $db = &JFactory::getDBO();
      $album =& JTable::getInstance( 'album' );
    }

    // Set the page title and pathway
    if ($album->name) {
      // Add the album breadcrumbs item
      $document->setTitle(JText::_('Music').' - '.$album->name);
    } else {
      $document->setTitle(JText::_('Music'));
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

    $this->assignRef('items',		$songs);
    $this->assignRef('lists',		$lists);
    $this->assignRef('pagination',	$pagination);
    $this->assignRef('album',		$album);
    $this->assignRef('params',		$pparams);
		
    $this->assign('action',		$uri->toString());

    parent::display($tpl);
  }
}
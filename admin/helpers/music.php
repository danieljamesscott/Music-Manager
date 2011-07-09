<?php

// No direct access
defined('_JEXEC') or die;

/**
 * Music component helper.
 *
 * @package             Joomla.Administrator
 * @subpackage          com_music
 * @since               1.6
 */
class MusicHelper {
  /**
   * Configure the Linkbar.
   *
   * @param       string  $vName  The name of the active view.
   *
   * @return      void
   * @since       1.6
   */
  public static function addSubmenu($vName) {
    JSubMenuHelper::addEntry(JText::_('COM_MUSIC_SUBMENU_ARTISTS'),
                             'index.php?option=com_music&view=artists',
                             $vName == 'artists'
                             );
    JSubMenuHelper::addEntry(JText::_('COM_MUSIC_SUBMENU_ALBUMS'),
                             'index.php?option=com_music&view=albums',
                             $vName == 'albums'
                             );
    JSubMenuHelper::addEntry(JText::_('COM_MUSIC_SUBMENU_SONGS'),
                             'index.php?option=com_music&view=songs',
                             $vName == 'songs'
                             );
    JSubMenuHelper::addEntry(JText::_('COM_MUSIC_SUBMENU_ARTISTALBUMS'),
                             'index.php?option=com_music&view=artistalbums',
                             $vName == 'artistalbums'
                             );
    JSubMenuHelper::addEntry(JText::_('COM_MUSIC_SUBMENU_ALBUMSONGS'),
                             'index.php?option=com_music&view=albumsongs',
                             $vName == 'albumsongs'
                             );
  }
}


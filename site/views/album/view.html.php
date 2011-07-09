<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the Album Component
 */
class MusicViewAlbum extends JView {

  protected $items;
  protected $pagination;
  protected $state;

  // Overwriting JView display method
  function display($tpl = null) {
    // Assign data to the view
    $this->items = $this->get('Items');
    $this->pagination = $this->get('Pagination');
    $this->state = $this->get('State');

    // Get front albumart image url
    if($this->items[0]->albumart_front) {
      $this->items[0]->albumart_front_html = JHtml::_('image', $this->items[0]->albumart_front, $this->items[0]->name . ' front albumart', array('align' => 'middle', 'width' => '250', 'height' => '209'));
    } else {
      $this->items[0]->albumart_front_html = JText::_("COM_MUSIC_NO_ALBUMART_AVAILABLE");
    }

    // Get back albumart image url
    if($this->items[0]->albumart_back) {
      $this->items[0]->albumart_back_html = JHtml::_('image', $this->items[0]->albumart_back, $this->items[0]->name . ' back albumart', array('align' => 'middle', 'width' => '250', 'height' => '209'));
    } else {
      $this->items[0]->albumart_back_html = JText::_("COM_MUSIC_NO_ALBUMART_AVAILABLE");
    }

    // Check for errors.
    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode('<br />', $errors));
      return false;
    }
    // Display the view
    parent::display($tpl);
  }
}

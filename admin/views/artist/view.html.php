<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Music View
 */
class MusicViewArtist extends JView {
  /**
   * display method of Artist view
   * @return void
   */
  public function display($tpl = null) {
    // get the Data
    $form = $this->get('Form');
    $item = $this->get('Item');
    $script = $this->get('Script');

    // Check for errors.
    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode('<br />', $errors));
      return false;
    }
    // Assign the Data
    $this->form = $form;
    $this->item = $item;
    $this->script = $script;

    // Set the toolbar
    $this->addToolBar();

    // Display the template
    parent::display($tpl);

    // Set the document
    $this->setDocument();
  }

  /**
   * Setting the toolbar
   */
  protected function addToolBar() {
    JRequest::setVar('hidemainmenu', true);
    $isNew = ($this->item->id == 0);
    JToolBarHelper::title($isNew ? JText::_('COM_MUSIC_ARTIST_NEW') : JText::_('COM_MUSIC_ARTIST_EDIT'));
    JToolBarHelper::save('artist.save');
    JToolBarHelper::cancel('artist.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
  }

  /**
   * Method to set up the document properties
   *
   * @return void
   */
  protected function setDocument() {
    $isNew = ($this->item->id < 1);
    $document = JFactory::getDocument();
    $document->setTitle($isNew ? JText::_('COM_MUSIC_ARTIST_CREATING') : JText::_('COM_MUSIC_ARTIST_EDITING'));
    $document->addScript(JURI::root() . $this->script);
    $document->addScript(JURI::root() . "/administrator/components/com_music/views/artist/submitbutton.js");
    JText::script('COM_MUSIC_ARTIST_ERROR_UNACCEPTABLE');
  }
}

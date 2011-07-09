<?php
// No direct access to this file
defined('_JEXEC') or die;

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Album Form Field class for the Album component
 */
class JFormFieldAlbum extends JFormFieldList {
  /**
   * The field type.
   *
   * @var         string
   */
  protected $type = 'Album';

  /**
   * Method to get a list of options for a list input.
   *
   * @return      array           An array of JHtml options.
   */
  protected function getOptions() {
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('id,name');
    $query->from('#__music_album');
    $db->setQuery((string)$query);
    $messages = $db->loadObjectList();
    $options = array();
    if ($messages) {
      foreach($messages as $message) {
        $options[] = JHtml::_('select.option', $message->id, $message->name);
      }
    }
    $options = array_merge(parent::getOptions(), $options);
    return $options;
  }
}

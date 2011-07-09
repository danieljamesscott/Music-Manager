<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of HelloWorld component
 */
class MusicController extends JController {
  /**
   * display task
   *
   * @return void
   */
  function display($cachable = false) {
    // set default view if not set
    JRequest::setVar('view', JRequest::getCmd('view', 'Artists'));

    $lang = JFactory::getLanguage();
    $lang->load('com_music', JPATH_ROOT);

    // call parent behavior
    parent::display($cachable);
  }
}
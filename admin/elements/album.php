<?php
/**
* @package     Music
* @copyright   Copyright (C) 2009 Daniel Scott (http://danieljamesscott.org). All rights reserved. 
* @license     GNU/GPL, see LICENSE.php
*/

defined('_JEXEC') or die();

class JElementAlbum extends JElement
{
  var   $_name = 'album';

  function fetchElement($name, $value, &$node, $control_name)
  {
    $db = &JFactory::getDBO();

      $query = "SELECT id AS value, name AS text FROM #__albums"
	.' ORDER BY ordering';

//       $query = "SELECT concat(czlo_nazwisko,' ',czlo_imie) AS text, czlo_id AS value FROM #__czlonkowie"
// 	.' ORDER BY czlo_nazwisko, czlo_imie';
      $db->setQuery($query);
      $options = $db->loadObjectList();
      array_unshift($options, JHTML::_('select.option', '0', '- '.JText::_('Select Album').' -', 'value', 'text'));

      return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'value', 'text', $value, $control_name.$name );   
  }
}
?>
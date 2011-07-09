<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
<th width="5">
    <?php echo JText::_('COM_MUSIC_ARTISTALBUM_ID_LABEL'); ?>
</th>
<th width="20">
    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
</th>
<th>
    <?php echo JText::_('COM_MUSIC_ARTISTALBUM_DETAILS'); ?>
</th>
</tr>

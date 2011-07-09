<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
<th width="5">
    <?php echo JText::_('COM_MUSIC_ALBUM_ID_LABEL'); ?>
</th>
<th width="20">
    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
</th>
<th>
    <?php echo JText::_('COM_MUSIC_ALBUM_NAME_LABEL'); ?>
</th>
<th>
    <?php echo JText::_('COM_MUSIC_ALBUM_CREATIONYEAR_LABEL'); ?>
</th>
<th>
    <?php echo JText::_('COM_MUSIC_ALBUM_ALBUMART_FRONT_LABEL'); ?>
</th>
<th>
    <?php echo JText::_('COM_MUSIC_ALBUM_ALBUMART_BACK_LABEL'); ?>
</th>
</tr>

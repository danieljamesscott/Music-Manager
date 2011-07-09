<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
<th width="5">
    <?php echo JText::_('COM_MUSIC_SONG_ID_LABEL'); ?>
</th>
<th width="20">
    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
</th>
<th>
    <?php echo JText::_('COM_MUSIC_SONG_NAME_LABEL'); ?>
</th>
<th>
    <?php echo JText::_('COM_MUSIC_SONG_NUMBER_LABEL'); ?>
</th>
<th>
    <?php echo JText::_('COM_MUSIC_SONG_FILENAME_LABEL'); ?>
</th>
</tr>

<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
  <tr class="row<?php echo $i % 2; ?>">
    <td>
      <a href="<?php echo JRoute::_('index.php?option=com_music&view=album&id='.(int) $item->album_id); ?>">
      <?php echo $this->escape($item->album_name); ?></a>
    </td>
    <td>
       <?php echo $item->creationyear; ?>
    </td>
  </tr>
<?php endforeach; ?>

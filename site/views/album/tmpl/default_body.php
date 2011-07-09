<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item):
?>
  <tr class="row<?php echo $i % 2; ?>">
    <td>
      <?php echo $item->song_number; ?>
    </td>
    <td>
      <?php echo $this->escape($item->song_name); ?>
    </td>
  </tr>
<?php endforeach; ?>

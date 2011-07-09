<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');

$user           = JFactory::getUser();
$userId         = $user->get('id');
?>

<div id="music_album">
<div id="music_album_head">
<h2><?php echo JText::_('COM_MUSIC_ALBUM_INFORMATION'); echo $this->items[0]->name; ?></h2>
</div> <!-- /music_album_head -->
<div id="music_album_left" style="width:50%;float:left;">

<table class="category">
  <thead><?php echo $this->loadTemplate('head');?></thead>
  <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
  <tbody><?php echo $this->loadTemplate('body');?></tbody>
</table>

</div> <!-- /music_album_left -->
<div id="music_album_right" style="width:50%;float:right;">

<?php if ( $this->items[0]->albumart_front_html ) : ?>
<?php echo $this->items[0]->albumart_front_html; ?>
<?php endif; ?>
<br/>
<br/>
<?php if ( $this->items[0]->albumart_back_html ) : ?>
<?php echo $this->items[0]->albumart_back_html; ?>
<?php endif; ?>

</div> <!-- /music_album_right -->
<div id="club_member_footer" style="clear:both">
<br/><br/>
<small><?php echo JText::_("COM_MUSIC_DESIGNED_BY")?><a href="http://danieljamesscott.org">http://danieljamesscott.org</a></small>
</div> <!-- /music_album_footer -->
</div> <!-- /music_album -->

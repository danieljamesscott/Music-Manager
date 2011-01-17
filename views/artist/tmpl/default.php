<?php defined( '_JEXEC' ) or die(); ?>
<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<?php if ($this->params->def('show_page_title')) {
    echo $this->params->get('page_title');
  } else {
    echo $this->artist->name;
  }
?>
</div>
<div class="contentpane<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td>
<ol>
<?php foreach($this->items as $item) : ?>
<li>
    <a href="<?php print $item->album_link; ?>" ><?php print $item->album_name; ?></a>
</li>
<?php endforeach; ?>
</ol>
</td>
<td align="right">
<?php if ($this->params->get('show_picture')) { ?>
<?php if ($this->artist->picture == "") {
      print JText::_('NOPICTUREAVAIL');
} else { ?>
<img src="images/artists/<?php echo $this->artist->cleaned_picture; ?>" hspace="6" height="200px" width="200px" alt="<?php echo $this->artist->name . ' ' . JText::_( 'Picture' ); ?>" />
<?php } ?>
<?php } ?>
</td>
</tr>
<tr>
<td align="left">
<?php echo nl2br($this->artist->description); ?>
</td>
<td align="right">
</td>
</tr>
</tbody>
</table>
<br />
    <small><?php echo JText::_('DESIGNEDBY');?><a href="http://danieljamesscott.org">http://danieljamesscott.org</a></small>
<input type="hidden" name="option" value="com_music" />
<input type="hidden" name="artistid" value="<?php echo $this->artist->id;?>" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>
</div>
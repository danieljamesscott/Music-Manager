<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php 
	// Set toolbar items for the page
	JToolBarHelper::title(   JText::_( 'Album Manager' ), 'generic.png' );
	JToolBarHelper::publishList();
	JToolBarHelper::unpublishList();
	JToolBarHelper::deleteList();
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
	JToolBarHelper::preferences('com_music', '360');
	JToolBarHelper::help( 'screen.album' );
?>
<form action="index.php" method="post" name="adminForm">
<table>
<tr>
	<td align="left" width="100%">
		<?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
	</td>
	<td nowrap="nowrap">
		<?php
			echo $this->lists['state'];
		?>
	</td>
</tr>
</table>
<?php 
	//print htmlspecialchars( JHTML::_('grid.sort',   'Order by', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ));
?>
<?php 
	// echo htmlspecialchars(JHTML::_('grid.order',  $this->items ));
?>

<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="10">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="10" class="title">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
			</th>
			<th class="title">
				<?php echo JHTML::_('grid.sort',   'Name', 'a.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="10%" class="title" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Creation Year', 'a.creationyear', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="10%" class="title" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Alias', 'a.alias', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="5%" class="title" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Published', 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th nowrap="nowrap" width="8%">
				<?php echo JHTML::_('grid.sort',   'Order by', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				<?php echo JHTML::_('grid.order',  $this->items ); ?>
			</th>
			<th width="10%" class="title">
				<?php echo JHTML::_('grid.sort',   'Artist', 'artist', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="9">
				<?php 
			// echo $this->pagination->getListFooter();
?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		$link 	= JRoute::_( 'index.php?option=com_music&c=albums&task=edit&cid[]='. $row->id );

		$checked 	= JHTML::_('grid.checkedout',   $row, $i);
		$published 	= JHTML::_('grid.published', $row, $i );

		$ordering = ($this->lists['order'] == 'a.ordering');

		$row->artist_link	= JRoute::_( 'index.php?option=com_music&c=artists&task=edit&cid[]='. $row->artistid );
		  ?>
		  <tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $this->pagination->getRowOffset( $i ); ?>
					</td>
					<td>
						<?php echo $checked; ?>
					</td>
					<td>
					<?php
					if (JTable::isCheckedOut($this->user->get ('id'), $row->checked_out )) :
						echo $row->name;
					else :
						?>
						<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit Album' ); ?>">
							<?php echo $row->name; ?></a>
						<?php
					endif;
					?>
					</td>
					<td>
						<?php echo $row->creationyear;?>
					</td>
					<td>
						<?php echo $row->alias;?>
					</td>
					<td align="center">
						<?php echo $published;?>
					</td>
					<td class="order">
						<span><?php echo $this->pagination->orderUpIcon( $i, ( $row->artistid == @$this->items[$i-1]->artistid ), 'orderup', 'Move Up', $ordering ); ?></span>
						<span><?php echo $this->pagination->orderDownIcon( $i, $n, ( $row->artistid == @$this->items[$i+1]->artistid ), 'orderdown', 'Move Down', $ordering ); ?></span>
						<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
					</td>
					<td>
						<a href="<?php echo $row->artist_link; ?>" title="<?php echo JText::_( 'Edit Artist' ); ?>">
							<?php echo $row->artist; ?></a>
					</td>
					<td align="center">
						<?php echo $row->id; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
	?>
	</tbody>
	</table>
</div>

<input type="hidden" name="option" value="com_music" />
<input type="hidden" name="c" value="albums" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>
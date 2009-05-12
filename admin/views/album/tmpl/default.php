<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	// Set toolbar items for the page
	$edit		= JRequest::getVar('edit',true);
	$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
	JToolBarHelper::title(   JText::_( 'Album' ).': <small><small>[ ' . $text.' ]</small></small>' );
	JToolBarHelper::save();
	if (!$edit)  {
		JToolBarHelper::cancel();
	} else {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	}
	JToolBarHelper::help( 'screen.album.edit' );
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.name.value == ""){
			alert( "<?php echo JText::_( 'Album item must have a title', true ); ?>" );
		} else if (form.artistid.value == "0"){
			alert( "<?php echo JText::_( 'You must select an artist', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>
<style type="text/css">
	table.paramlist td.paramlist_key {
		width: 92px;
		text-align: left;
		height: 30px;
	}
</style>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="name" id="name" size="60" maxlength="255" value="<?php echo $this->album->name; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="alias">
							<?php echo JText::_( 'Alias' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="alias" id="alias" size="60" maxlength="255" value="<?php echo $this->album->alias; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<?php echo JText::_( 'Published' ); ?>:
					</td>
					<td>
						<?php echo $this->lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="artistid">
							<?php echo JText::_( 'Artist' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $this->lists['artistid'];?>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<label for="ordering">
							<?php echo JText::_( 'Ordering' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $this->lists['ordering']; ?>
					</td>
				</tr>
				<?php
				if ($this->album->id) {
					?>
					<tr>
						<td class="key">
							<label>
								<?php echo JText::_( 'ID' ); ?>:
							</label>
						</td>
						<td>
							<strong><?php echo $this->album->id;?></strong>
						</td>
					</tr>
					<?php
				}
				?>
	</table>
	</fieldset>

			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Information' ); ?></legend>

				<table class="admintable">
				<tr>
					<td class="key">
						<label for="creationyear">
							<?php echo JText::_( 'Creation Year' ); ?>:
						</label>
					</td>
					<td>
						    <input class="inputbox" type="text" name="creationyear" id="creationyear" size="5" maxlength="5" value="<?php echo $this->album->creationyear; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="albumart_front">
							<?php echo JText::_( 'Front album art' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $this->lists['albumart_front']; ?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="albumart_back">
							<?php echo JText::_( 'Back album art' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $this->lists['albumart_back']; ?>
					</td>
				</tr>

				</table>
			</fieldset>

</div>
<div class="col50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parameters' ); ?></legend>

		<table class="admintable">
		<tr>
			<td colspan="2">
				<?php 
		echo $this->params->render();
?>
			</td>
		</tr>
		</table>
	</fieldset>
</div>

<div class="col50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Description' ); ?></legend>

		<table class="admintable">
		<tr>
			<td>
				<textarea class="text_area" cols="44" rows="9" name="description" id="description"><?php echo $this->album->description; ?></textarea>
			</td>
		</tr>
		</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_music" />
<input type="hidden" name="c" value="albums" />
<input type="hidden" name="cid[]" value="<?php echo $this->album->id; ?>" />
<input type="hidden" name="task" value="" />
</form>
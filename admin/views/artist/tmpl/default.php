<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	// Set toolbar items for the page
	$edit		= JRequest::getVar('edit',true);
	$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
	JToolBarHelper::title(   JText::_( 'Artist' ).': <small><small>[ ' . $text.' ]</small></small>' );
	JToolBarHelper::save();
	if (!$edit)  {
		JToolBarHelper::cancel();
	} else {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	}
	JToolBarHelper::help( 'screen.artist.edit' );
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
			alert( "<?php echo JText::_( 'Artist item must have a title', true ); ?>" );
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
						<input class="inputbox" type="text" name="name" id="name" size="60" maxlength="255" value="<?php echo $this->artist->name; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="alias">
							<?php echo JText::_( 'Alias' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="alias" id="alias" size="60" maxlength="255" value="<?php echo $this->artist->alias; ?>" />
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
				if ($this->artist->id) {
					?>
					<tr>
						<td class="key">
							<label>
								<?php echo JText::_( 'ID' ); ?>:
							</label>
						</td>
						<td>
							<strong><?php echo $this->artist->id;?></strong>
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
							<label>
								<?php echo JText::_( 'Biography' ); ?>:
							</label>
						</td>
						<td>
							<textarea class="text_area" cols="44" rows="9" name="description" id="description"><?php echo $this->artist->description; ?></textarea>
						</td>
					</tr>
				<tr>
					<td class="key">
						<label for="picture">
							<?php echo JText::_( 'Picture' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $this->lists['artists']; ?>
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
		//echo $this->params->render();
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
		</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_music" />
<input type="hidden" name="c" value="artists" />
<input type="hidden" name="cid[]" value="<?php echo $this->artist->id; ?>" />
<input type="hidden" name="task" value="" />
</form>
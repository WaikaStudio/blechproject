<?php
/**
 * @author		
 * @copyright	
 * @license		
 */

defined("_JEXEC") or die("Restricted access");
?>

<h2>
	<?php echo JText::_('COM_QUOTE_QUOTE_HEAD_VIEW_HEAD_TITLE'); ?>: <i><?php echo $this->item->idpart; ?></i>
	<span class="pull-right" style="font-weight:300; font-size:15px;">[<a href="<?php echo JRoute::_('index.php?option=com_quote&task=head.edit&id=' . (int) $this->item->id); ?>"><?php echo JText::_('JACTION_EDIT') ?></a>]</span>
</h2>

<table class="table table-striped">
	<tbody>
			<tr>
				<td>Idpart</td>
				<td><?php echo $this->escape($this->item->idpart); ?></td>
			</tr>
			<tr>
				<td>Idbrand</td>
				<td><?php echo $this->escape($this->item->idbrand); ?></td>
			</tr>
			<tr>
				<td>Mess_submit</td>
				<td><?php echo $this->escape($this->item->mess_submit); ?></td>
			</tr>
			<tr>
				<td>Mess_active</td>
				<td><?php echo $this->escape($this->item->mess_active); ?></td>
			</tr>
		<tr>
			<td>ID</td>
			<td><?php echo $this->escape($this->item->id); ?></td>
		</tr>
	</tbody>
</table>
<p><a href="index.php?option=com_quote&view=heads"><?php echo JText::_('JPREVIOUS'); ?></a></p>
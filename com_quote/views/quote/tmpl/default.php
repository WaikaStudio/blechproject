<?php
/**
 * @author		
 * @copyright	
 * @license		
 */

defined("_JEXEC") or die("Restricted access");
?>

<h2>
	<?php echo JText::_('COM_QUOTE_QUOTE_CTRL_VIEW_QUOTE_TITLE'); ?>: <i><?php echo $this->item->uid; ?></i>
	<span class="pull-right" style="font-weight:300; font-size:15px;">[<a href="<?php echo JRoute::_('index.php?option=com_quote&task=quote.edit&id=' . (int) $this->item->id); ?>"><?php echo JText::_('JACTION_EDIT') ?></a>]</span>
</h2>

<table class="table table-striped">
	<tbody>
			<tr>
				<td>Uid</td>
				<td><?php echo $this->escape($this->item->uid); ?></td>
			</tr>
			<tr>
				<td>State</td>
				<td><?php echo $this->escape($this->item->state); ?></td>
			</tr>
		<tr>
			<td>ID</td>
			<td><?php echo $this->escape($this->item->id); ?></td>
		</tr>
	</tbody>
</table>
<p><a href="index.php?option=com_quote&view=quotes"><?php echo JText::_('JPREVIOUS'); ?></a></p>
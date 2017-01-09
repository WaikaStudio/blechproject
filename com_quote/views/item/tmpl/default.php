<?php
/**
 * @author		
 * @copyright	
 * @license		
 */

defined("_JEXEC") or die("Restricted access");
?>

<h2>
	<?php echo JText::_('COM_QUOTE_QUOTE_ITEM_VIEW_ITEM_TITLE'); ?>: <i><?php echo $this->item->brand; ?></i>
	<span class="pull-right" style="font-weight:300; font-size:15px;">[<a href="<?php echo JRoute::_('index.php?option=com_quote&task=item.edit&id=' . (int) $this->item->id); ?>"><?php echo JText::_('JACTION_EDIT') ?></a>]</span>
</h2>

<table class="table table-striped">
	<tbody>
			<tr>
				<td>Brand</td>
				<td><?php echo $this->escape($this->item->brand); ?></td>
			</tr>
			<tr>
				<td>Pserial</td>
				<td><?php echo $this->escape($this->item->pserial); ?></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><?php echo $this->escape($this->item->quantity); ?></td>
			</tr>
			<tr>
				<td>Productid</td>
				<td><?php echo $this->escape($this->item->productid); ?></td>
			</tr>
			<tr>
				<td>Price</td>
				<td><?php echo $this->escape($this->item->price); ?></td>
			</tr>
		<tr>
			<td>ID</td>
			<td><?php echo $this->escape($this->item->id); ?></td>
		</tr>
	</tbody>
</table>
<p><a href="index.php?option=com_quote&view=items"><?php echo JText::_('JPREVIOUS'); ?></a></p>
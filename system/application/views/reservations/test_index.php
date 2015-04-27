<?php echo $this->session->flashdata('saved') ?>
<?php

$jscript = '';
?>				
<style>

	.goRight { float: right; }
	.extraSpace { padding-left: 10px; }
	.labelType { font-weight: bold; width: 35% }
	
</style>


<div class="control-group">
	<label class="control-label">Dropdown Filter</label>
	<div class="controls">
		<select class="span6" tabindex="1" id="item_drop">
				<option value="showAll">Show All</option>
			<?php foreach($item_type as $item_types){ ?>
				<option value="<?php echo 'filter-'.$item_types->item_type_id ?>"><?php echo $item_types->name ?></option>
			<?php } ?>
		</select>
	</div>
</div>

<div class="row-fluid">

	<?php
		$i=0;
		if( $item_groups )
		{
			
			foreach( $item_groups as $item_group )
			{ 
	?>
			<div class="span3 filter-<?php echo $item_group->item_type_id ?>">
	
		<!-- BEGIN WIDGETS-->
			
		<div class="widget green">			
		
			<div class="widget-title centerTitle">
			
				<h4><?php echo $item_group->name ?></h4>
			
			</div>
			
			<div class="widget-body">
				
				<div class="image-container">
					
					<img src="<?php echo 'webroot/images/roomphotos/640/'.$item_group->photo ?>"  />
					
				</div>
				
				<div class="space20"></div>
				
				<table style="width: 100%;">
									
					<tr>
					
						<td class="labelType">Item Type <span class="goRight">:</span></td>
						<td class="extraSpace"><b style="color: #3F0;"> <?php echo $item_group->item_type_name ?></b></td>
					
					</tr>
				
					<tr>
					
						<td class="labelType">Item Name <span class="goRight">:</span></td>
						<td class="extraSpace"><b style="color: #00F;"> <?php echo $item_group->name ?> </b></td>
					
					</tr>
					
					<tr>
					
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					
					</tr>
				
				</table>
				
				<div class="space20"></div>
				
				<?php
					$group_id = $item_group->item_group_id;
					echo form_open('reservations/index/'.$group_id);
				?>
				
				<div class="reserveButton" style="text-align: right;">
				
						<?php if ($this->userauth->GetDepartment() == 0 || $this->userauth->GetDepartment() == 1) { ?>
					
							<button type="submit" class="btn btn-large btn-success"><i class="icon-ok icon-white"></i> &nbsp; Reserve Item</button>
					
						<?php } else { ?>
					
							<button type="submit" class="btn btn-large btn-danger" disabled="disabled"><i class="icon-remove icon-white"></i> &nbsp; Restricted</button>
					
						<?php } ?>

				</div>
				
				<?php
					echo form_close();
				?>	
							
			</div>
		
		</div>
		<!-- END WIDGETS-->
	
	</div>

	
	<?php 
			$i++; 
		
			}
	
		} else {
			echo '<td colspan="6" align="center" style="padding:16px 0">No items exist!</td>';
		}
	?>


</div>
<script type="text/javascript">
<?php echo $jscript ?>
</script>
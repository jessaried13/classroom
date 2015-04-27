<?php echo $this->session->flashdata('saved') ?>

<div class="row-fluid">

	<?php
		$i=0;
		if( $types )
		{
			
			foreach( $types as $type )
			{ 
	?>
	
		<a class="icon-btn span2" href="#">
			<i class="icon-group"></i>
			<div>Users</div>
			<span class="badge badge-important">2</span>
		</a>

	
	<?php 
			$i++; 
		
			}
	
		} else {
			echo '<td colspan="6" align="center" style="padding:16px 0">No items exist!</td>';
		}
	?>


</div>
<?php
/**
 * Open Source Social Network
 */
	$type =	$params['type'];
 ?>
 <div class="row">
	<div class="col-sm-3">
		<div class="ossn-widget widget-description">
			<div class="widget-contents">
				<div class="list-group">
					<a href="#" class="list-group-item"><?php echo ossn_print("admin:pending:approval") ?></a>
					<a href="#" class="list-group-item"><?php echo ossn_print("admin:manufacturer") ?></a>
					<a href="#" class="list-group-item"><?php echo ossn_print("admin:category") ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-9">
		<div class="page-sidebar">
			<?php 
				switch($type){
					case 'pending':
						echo ossn_plugin_view('settings/administrator/Market/pages/pending_approval');
					break;
				}
			?>
		</div>
	</div>
 </div>


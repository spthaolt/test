<?php

use Market\bol\ShopsService;

?>
<div class="ossn-widget">
	<div class="widget-heading">Lists Pending Approval</div>
	<div class="widget-contents">
		<table class="table margin-top-10">
			<tr class="table-titles">
			    <th scope="col"><?php //echo ossn_print('category:title');?></th>
			    <th scope="col"><?php //echo ossn_print('category:description');?></th>
			    <th scope="col"><?php //echo ossn_print('delete');?></th>
			 </tr>
		<?php
		$shop = new ShopsService;
		$aaa = $shop->getAllShop();

		var_dump($aaa);
		die();
		?>
		</table>
	</div>
<div>

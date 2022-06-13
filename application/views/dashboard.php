<html>
<head></head>
<body>
<table>
	<thead></thead>
	<tbody>
		<tr><td>All Active and Verified users:</td><td><b><?php echo $users['activeVarified']->num_rows()?></b></td></tr>
		<tr><td>Active and Verified users having Active products:</td><td><b><?php echo $users['haveActiveProducts']->num_rows()?></b></td></tr>
		<tr><td>All Active products:</td><td><b><?php echo $products['activeProducts']->num_rows()?></b></td></tr>
		<tr><td>active products which don't belong to any user:</td><td><b><?php echo $products['unusedProducts']->num_rows()?></b></td></tr>

<tr><td>all active attached products</td><td><b><?php echo $products['attachedProducts']->row()->inhand?></b></td></tr>

<tr><td>Summarized price of all active attached products</td><td><b>$<?php echo $users['allSummaryActiveProducts']->row()->psum?></b></td></tr>


	</tbody>
</table>
 <b>Summarized prices of all active products per user</b>
 <table>
	<thead></thead>
	<tbody>
		<?php foreach($users['allSummaryProductsUsers']->result() as $row){?>
		<tr><td><?php echo $row->firstname?> <?php echo $row->lastname?></td><td><b>$<?php echo $row->psum?></b></td></tr>
		<?php } ?>
	</tbody>
</table>
 <h3>1 USD = <?php echo $rate['usd'];?> RON</h3> 
</body>
</html>
<html>
<head>
	<title>All Products</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>"/>
</head>
<body>
<?php $this->load->view('admin/menu');?>
<h3>Welcome to the Admin Dashboard</h3>
<hr/>
<h4>All Products</h4>
 <div class="success"><?php echo $this->session->flashdata('message');?></div>
 <table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Image</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($products->result() as $product){?>
		<tr>
			<td><?php echo $product->pid;?></td>
			<td><?php echo $product->title;?></td>
			<td><img src="<?php echo base_url('uploads/'.$product->image);?>" style="max-width:100px" alt="<?php echo $product->title;?>"/></td>
			<td><?php echo $product->status;?></td>
			<td><a href="<?php echo site_url('admin/products/edit/'.$product->pid);?>" title="Click to Edit Product" >Edit</a> <a href="<?php echo site_url('admin/products/delete/'.$product->pid);?>" title="Click to Delete Product" onclick="return confirm('Do you want to delete this product');">Delete</a></td>
		</tr>
	<?php } ?>
	</tbody>
</table> 

</body>
</html>
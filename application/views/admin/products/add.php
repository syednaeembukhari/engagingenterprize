<html>
<head>
	<title>Add New Product</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>"/>
</head>
<body>
	<?php $this->load->view('admin/menu');?>
	<h3>Welcome to the Admin Dashboard</h3>
	<hr/>
	<h4><?php echo $pagetitle;?></h4>
	<?php echo  form_open_multipart($formaction,'id="productform" class="productform"');?>
	<table>
		<tbody>
			<tr>
				<td style="max-width:200px">Title</td>
				<td><?php echo $profrm['title'];?></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><?php echo $profrm['description'];?></td>
			</tr>
			<tr>
				<td>Select Image</td>
				<td><?php echo $profrm['imagefile'];?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?php echo $profrm['status'];?></td>
			</tr>
		</tbody>
	</table>
	<button type="submit"><?php echo $buttontitle;?></button>

	<?php echo form_close();?>
	<div class="error"><?php echo validation_errors();?></div>
	<div class="error"><?php if(isset($message)){echo $message;};?></div> 

</body>
</html>
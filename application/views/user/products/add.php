<html>
<head>
	<title>Add New Product</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>"/>
</head>
<body>
	<?php $this->load->view('user/menu');?>
	<h3>Welcome to the User Dashboard</h3>
	<hr/>
	<h4><?php echo $pagetitle;?></h4>
	<?php echo  form_open_multipart($formaction,'id="productform" class="productform"');?>
	 
	<table>
		<tbody>
			<tr>
				<td style="max-width:200px">Title</td>
				<?php if($buttontitle=='Update'){?>
				<td><?php echo $product->title;?><br/><img src="<?php echo base_url('uploads/'.$product->image);?>" style="max-width:100px" alt="<?php echo $product->title;?>"/></td>	
				<?php }else{?>
				<td><?php echo $profrm['pidlist'];?></td>
				<?php }?>
			</tr>
			
			<tr>
				<td>Price</td>
				<td><?php echo $profrm['price'];?></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><?php echo $profrm['instock'];?></td>
			</tr>
		</tbody>
	</table>
	<button type="submit"><?php echo $buttontitle;?></button>

	<?php echo form_close();?>
	<div class="error"><?php echo validation_errors();?></div>
	<div class="error"><?php if(isset($message)){echo $message;};?></div> 

</body>
</html>
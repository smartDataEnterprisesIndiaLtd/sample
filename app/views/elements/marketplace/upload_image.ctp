<div style="width:100px;float:right;" class="inc-mid">
	<?php
	if($seller_info['Seller']['image'] == 'no_image.gif' || $seller_info['Seller']['image'] == 'no_image.jpeg'){
		
	} else{
		$image_path = 'sellers/'.$seller_info['Seller']['image'];
		$imagePath = SITE_URL.'img/'.$image_path ;
		if(file_get_contents($imagePath)){
			echo $html->image($image_path,array('alt'=>"",'width'=>100,'height'=>30));
		}
	}?>
</div>
<div style="overflow:hidden; margin-right:10px;">
<?php echo  $form->create('Seller',array('action'=>'upload_seller_image','method'=>'POST','name'=>'frmSeller','id'=>'frmSeller','enctype'=>'multipart/form-data'));?>
<ul>
	<li><?php echo $form->input('Seller.photo',array('class'=>'','label'=>false,'div'=>false,'error'=>false,'style'=>'width:none','type' => 'file'));?></li>
	<li>
		<?php echo $form->button('',array('type'=>'submit','class'=>'upload-btn position-area','div'=>false,'style'=>'font-size:10px'));?>
	</li>
</ul>
<?php echo $form->end();?>
<div style="font-size:10px; clear:both">
Image should be 100 pixels long and 30 pixels wide and in .jpg or .gif format.
</div>
</div>
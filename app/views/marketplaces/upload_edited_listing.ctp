<?php echo $javascript->link("jquery");
$img_l =  $this->Html->image('ajax-loader.gif', array('alt' => 'In Progress'));
$up_id = uniqid();
?>
<div id="plsLoaderID" class="dimmer" style="display:none">
	<?php echo $html->image("ajax-loader.gif" ,array('alt'=>"Loading"));?>
	Loading, please wait
</div>
<?php if ($session->check('Message.flash')){ ?>
	<div>
		<?php echo $session->flash(); ?>
	</div>
	<?php }  ?>
<style>
	.blue-btn {
    overflow: visible;
    padding: 0 6px 0 3px;
}
	.black_overlay {
	    background-color: #484B4C;
	    display: block;
	    height: 100%;
	    left: 0;
	    opacity: 0.8;
	    position: fixed;
	    top: 0;
	    width: 100%;
	    z-index: 998;
	}
	.dimmer {
		background-color: #F6F6F6;
		border: 2px solid #CBCBCB;
		border-radius: 10px 10px 10px 10px;
		font-size: 20px;
		font-weight: bold;
		height: 30px;
		left: 50%;
		margin-left: -157px;
		margin-top: -30px;
		padding: 15px 30px 15px 15px;
		position: fixed;
		top: 48%;
		width: 270px;
		z-index: 1200;
	}
	#frmMarketplace{
		
	}
	.cloud_extra{
		height:400px;
	}
	.flashError{
   white-space: nowrap;
	padding:8px 40px;
	}
.blue-button-widget {(-bracket-:hack; padding-left: 0px!important;);}
#MarketplaceSampleBulkData { cursor:pointer!important}
.error_msg_box {padding : 12px 22px !important;}
</style>
<script>
		jQuery(document).ready(function()  { // for writing a review
			var show_bar = 0;
			    jQuery('input[type="file"]').click(function(){
					show_bar = 1;
			    });
			
			//show iframe on form submit
			    jQuery("#frmMarketplace").submit(function(){
					
					if (show_bar === 1) { 
						jQuery('#upload_frame').show();
						function set () {
							jQuery('#upload_frame').attr('src','<?php echo SITE_URL."/marketplaces/upload_frame"; ?>?up_id=<?php echo $up_id; ?>');
						}
						setTimeout(set);
					}
			    });
		//jQuery('body').prepend('<div class="black_overlay" id="fade" style="display: none;"></div><div style="background-color: white; display: none;" id="loading-image"><table border="0" cellspacing="0" cellpadding="5"><tbody><tr><td><?php echo $img_l; ?></td><td class="upload_cloud_img">Loading..Please Wait!</td></tr></tbody></table></div>');
		 
	});
	
</script>


<?php
if(empty($this->params['named']['seller_id'])){	
	echo $form->create('Marketplace',array('action'=>'upload_edited_listing/','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace', 'enctype'=>'multipart/form-data' ));
}else{
	echo $form->create('Marketplace',array('action'=>'upload_edited_listing/seller_id:'.$seller_user_id,'method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace', 'enctype'=>'multipart/form-data' ));
}
?>
<ul class="pop-con-list" id="test">
	<?php
	$error_display = $this->Session->read('Errorupdatelisting');
		if(!empty($error_display)){
			if ($session->check('Message.flash')){ ?><div class="messageBlock">
				<?php echo $session->flash();?>
			</div>
			<?php }
		}
	?>
		
	<li><h4 class="dif-blue-color">Bulk Update</h4></li>
	<li>Manage and update your listings. Please note that you must use the same format as the downloaded listings.</li>
	<li><b>Please note:</b> only upload 10,000 product listings in a single file, if you have more product listings please upload them in separate files.</li>
	<!--<li><?php echo $html->link('Sample template',array('action'=>'download_sample_template'),array('escape'=>false,'class'=>'underline-link'));?></li> --->
<!--APC hidden field-->
    <input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<?php echo $up_id; ?>"/>
<!---->

<li class="upload-file-li"><div class="choose-file-div">Choose file to upload...</div>
		  <?php
		 echo $form->input('Marketplace.sample_bulk_data',array('class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'type' => 'file','size'=>5,'onChange'=>'display_filename();'));?>
	</li>
	<li id ="file_name"></li>

<!--Include the iframe-->

    <iframe id="upload_frame" name="upload_frame" frameborder="0" border="0" src="" scrolling="no" scrollbar="no" >
	
	
	
    </iframe>

<!---->
	
	<li>
		<div class="blue-button-widget"><?php echo $form->button('Submit',array('type'=>'submit','class'=>'blue-btn','div'=>false,'id'=>'clickOnce'/*,'onclick'=>"return progressBar();"*/));?></div>
	
	</li>
</ul>
<?php
echo $form->end();
?>
<script>
function display_filename(){
	
	var upload_filename = jQuery('#MarketplaceSampleBulkData').val();
	upload_filename = upload_filename.replace("C:\\fakepath\\", "");
	var hh = jQuery("#fancybox-content",parent.document).height()+55;
	hh = hh+"px";
	if(upload_filename != ''){
		jQuery('#file_name').html('<img src="../img/attachmentimg.png"> '+upload_filename);
		jQuery("#fancybox-content",parent.document).css({'height':hh});
	}
}
function progressBar(){
		//document.getElementById('fade').style.display = "";
		//document.getElementById('loading-image').style.display = "";
		//jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height()+300);
		// jQuery("#fancybox-content").addClass("cloud_extra");
		// jQuery("#test").addClass("cloud_extra");
		//jQuery('#fancybox-content').css("height","400px");
		//parent.jQuery('#fade').show();
		//parent.jQuery('#plsLoaderID').show();
		//parent.jQuery.fancybox.close();
		//return false;
		
	}
</script>
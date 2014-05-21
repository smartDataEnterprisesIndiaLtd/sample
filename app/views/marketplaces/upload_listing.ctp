<?php
echo $javascript->link(array('jquery.MultiFile'),false);
//echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
?>
<script >
 function validateSubmit(){
	
	if(jQuery('#bulkuploadlistingfile').val() == ''){
		return false
	}
 }
 </script>
<script>
jQuery(document).ready(function()  {
  jQuery('body').prepend('<div class="black_overlay" id="fade" style="display: none;"></div>');
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("'input:file'").val() != "")
		{
			jQuery('#fade').show();
			jQuery('#plsLoaderID').show();
		 	jQuery('#frmMarketplace').submit();
			jQuery("#clickOnce").attr("disabled", "true");
		}
	});
});
</script>
<style>
 #tab-cloud{
background: none repeat scroll 0 0 #CCCCCC;
border-radius: 4px 4px 4px 4px;
color: #333333;
}
#loading-image {
  border-radius: 10px 10px 10px 10px;
    left: 50%;
    margin-left: -90px;
    position: fixed;
    right: auto;
    top: 50%;
    z-index: 999;
    margin-top: -40px;
}
.black_overlay{
display: block;
position: fixed;
top:0;
left: 0;
width: 100%;
height: 100%;
background-color: #484b4c;
z-index:998;
-moz-opacity: 0.8;
opacity:.80;
filter: alpha(opacity=80);
}
.new_text{
    float: left;
    font-weight: bold;
    margin-left: -3px;
    width: 15px;
}
.new_text ol{
 
}
.new_textab li{
  margin-left: 15px;
   
 
}
.flashError { margin-right:69px;}
.message { margin-right:69px;}
</style>
<!--mid Content Start-->
<div class="mid-content pad-rt-none inc-pad">
	<!--- <?php echo $this->element('marketplace/breadcrum'); ?> --->
	<!--Setting Tabs Widget Start-->
	<div class="row-widget">
		<!--Tabs Widget Start-->
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
		<!--Tabs Widget Closed-->
		<?php echo $form->create('Marketplace',array('action'=>'upload_listing','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace','enctype'=>'multipart/form-data', 'onsubmit'=>' return validateSubmit();' ));
		echo $form->hidden('BulkUpload.user_id',array( 'value' =>$this->Session->read('User.id'), 'class'=>'textbox','label'=>false,'div'=>false)); ?>
		<div class="tabs-content">
		<!--Choice Headding Start-->
			<h2 class="choice_headding choiceful">Bulk Upload Inventory</h2>
			<!--Choice Headding Closed-->
			<!--Discription Start-->
			<div class="inner-content">
				<p>Upload your entire product inventory using our uploading tool. It's really simple and fast, upload your inventory in the format provided in the sample template and we'll activate your listings.</p>
				<p>All products go through our rigorous  approval process, to eliminate any difference found in your inventory and products we sell, so allow up to 48 hours untill your product listings  are activated.</p>
				<p>Follow our quick steps below to successfully upload your products to Choiceful.com Marketplace:</p>
				<p><ul class="new_textab"> <span class="new_text">1.</span><li> Download the <?php echo $html->link('sample template','/marketplaces/download_sample_template', array('escape'=>false,'class'=>'underline-link'));?> file. The file is a Microsoft Excel (xls) format. If you do not have Microsoft Excel there are a number of alternatives you can use to open and edit the file including Google Sheets.</li>
				<span class="new_text">2.</span><li> Review the headers along row A, and helpful tips in row B.</li>
				<span class="new_text">3.</span><li> Once you have entered your data save the file as a Comma-Separated Values (.csv) file.</li>
				<span class="new_text">4.</span><li> Upload your file to Choiceful.com using the browse and upload options below.</li></ul></p>

				<p>Please note: only upload 10,000 product listings in a single file, if you have more product listings please upload them in separate files.</p>
				<p>Need help? Contact our <span class="colorText" style="color:#003399;"><script  type="text/javascript"  src="<?php echo SITE_URL;?>/app/webroot/phplive/js/phplive.js.php?d=0&text=live help seller support&base_url=%2F%2Fchoiceful.com%2Fapp%2Fwebroot%2Fphplive"></script></span>.</p>
				<p><?php echo $html->link('Sample template','/marketplaces/download_sample_template', array('escape'=>false,'class'=>'underline-link'));?></p>
				<?php
				if ($session->check('Message.flash')){ ?>
					       <?php echo $session->flash();?>
				<?php } ?>
			</div>
			<!--Discription Closed-->
			<!--Sample block Srart-->
			<div class="sample_block">
				<div class="sample_page">
					<div class="sample_page_head" style="position:relative;">
						<input id="bulkuploadlistingfile" type="file" size="5" name="data[BulkUpload][sample_file]"  class="file-input" style="left:15px; height:25px; width:120px; cursor:pointer;" /><h1><span style="color:#6A89C2;text-decoration:underline;">Click Here</span> and select File to Upload.</h1>
					</div>
				</div>
			</div>
			<!--Sample block Closed-->
		
			<p>&nbsp;</p>
			<!--<div class="sample_total_files">Total: 0 files, 0 bytes</div>-->
			<!--Sample block Closed-->
			<!--Sample Bot Row Srart-->
			<div class="sample_bot_row">
				<?php echo $form->button('Begin Uploding File',array('type'=>'submit','div'=>false,'class'=>'uploading_file_btn','id'=>'clickOnce'));?>
				or 
				<?php echo $html->link('<strong>Create Manual Listing for Manufacturers and Publishers</strong>','/marketplaces/create_product_step1', array('escape'=>false,'class'=>'underline-link'));?>
			</div>
			<!--Sample Bot Row Closed-->
		</div>
		<!--Tabs Content Closed-->
		<?php  echo $form->end();?>
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->
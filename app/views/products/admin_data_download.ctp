<?php

$this->Html->addCrumb('Product Management', '/admin/products');
	$this->Html->addCrumb('Download Data', 'javascript:void(0)');

$img_l =  $this->Html->image('ajax-loader.gif', array('alt' => 'In Progress'));
$selectedDep= isset($this->params['pass'][1])?$this->params['pass'][1]:'';
?>

<?php 
echo $form->create('Product',array('action'=>'admin_dataDownload', 'method'=>'POST','name'=>'frmProduct','id'=>'frmProduct', 'enctype'=>'multipart/form-data' ));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
	</tr>
	<tr>
		<td colspan="2"> 
			<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
				<tr height="20px">
					<!--- <td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td> --->
                                        
				</tr>
				<tr>
					<td align="right" valign="top">Department :</td>
					<td>
						<?php echo $form->select('Product.department_id',$departments,$selectedDep,array('class'=>'textbox', 'type'=>'select'),'All Departments'); ?>
						<?php echo $form->error('Product.department_id'); ?>
					</td>
				</tr>
                                <tr>
					<td align="right" valign="top">Conditions :</td>
					<td>
						<?php
                                                    $conditions = array('1'=>'NEW','2'=>'USED');
                                                echo $form->select('Product.condition_id',$conditions,null,array('class'=>'textbox', 'type'=>'select'),'Both (NEW/USED)'); ?>
						<?php echo $form->error('Product.condition_id'); ?>
					</td>
				</tr>
                                <tr>
					<td align="right" valign="top">Number Of Records from:</td>
					<td>
						<?php
                                                echo $form->input('Product.from_limit',array('class'=>'textbox', 'type'=>'text','label'=>false,'div'=>false,'placeholder'=>0)); ?>
						<!--- <?php echo $form->error('Product.limit'); ?> --->
					</td>
				</tr>
                                <tr>
					<td align="right" valign="top">Number Of Records:</td>
					<td>
						
                                                <?php
                                                echo $form->input('Product.to_limit',array('class'=>'textbox', 'type'=>'text','label'=>false,'div'=>false,'placeholder'=>5000)); ?>
						<!--- <?php echo $form->error('Product.limit'); ?> --->
					</td>
				</tr>
                                 <tr>
					<td align="right" valign="top">Stock Status:</td>
					<td>
						
                                               <?php
                                                    $conditions = array('1'=>' No Sellers Available','2'=>'Sellers Available');
                                                echo $form->select('Product.seller',$conditions,null,array('class'=>'textbox', 'type'=>'select'),'Both (No Sellers/Sellers)'); ?>
						<?php echo $form->error('Product.seller'); ?>
					</td>
				</tr>
				<!--<tr>
					<td colspan="2">&nbsp;</td>
				</tr> -->
				<tr>    
                                     
                                    <?php
                                    $link = "&nbsp;";
                                    $filename = isset($this->params['pass'][0])?$this->params['pass'][0]:'';
                                    if(isset($filename) && !empty($filename)){
                                        $linkdata = SITE_URL."admin/products/zipdownload/$filename";
                                        $link = '<a style="text-decoration: none;" class="btn_53" href="'.$linkdata.'">Download Zip Data</a>';
                                    }
                                    ?>
					<td align="right"> </td>
					<td align="left">
					<?php 
					echo $form->button('Submit Query',array('type'=>'submit','class'=>'btn_53','id'=>'clickOnce','div'=>false));
					?>&nbsp;&nbsp;
                                        <?php echo $link; ?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
                                        <td align="left">Note: Kindly Download 5000 Records at a time.</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->end(); ?>
<script>
    jQuery(document).ready(function()  {
      
    jQuery('body').prepend('<div class="black_overlay" id="fade" style="display: none;"></div><div style="background-color: white; display: none;" id="loading-image"><table border="0" cellspacing="0" cellpadding="5"><tbody><tr><td><?php echo $img_l; ?></td><td class="upload_cloud_img">Loading..Please Wait!</td></tr></tbody></table></div>');
	jQuery('#clickOnce').click(function(){
		
			jQuery('#fade').show();
			jQuery('#loading-image  ').show();
		  	//jQuery("#clickOnce").attr("disabled", "true");
		
	});
	
    });
</script>
<style>
    #loading-image {
      
   /* border-radius: 10px 10px 10px 10px;
    left: 50%;
    margin-left: -90px;
    margin-top: -40px;
    position: fixed;
    right: auto;
    top: 50%;
    z-index:999999;*/
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
    z-index:999999
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
    z-index:99999;
}
a:hover, a.remove:hover {
    color: #FFFFFF;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    font-size: 11px;
    font-style: normal;
    font-weight: bold;

}
</style>


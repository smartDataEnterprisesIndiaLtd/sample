<?php
$this->Html->addCrumb('Seller Management', ' ');
$this->Html->addCrumb('Update', 'javascript:void(0)');
//echo $javascript->link(array('jquery-1.3.2.min'), false);
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
?>
<script type="text/javascript" language="javascript">	
jQuery(document).ready(function(){
	 displayState();
	 HideUnhideSuspendBox();
});



jQuery(document).change( function(){
	 HideUnhideSuspendBox();
	});

// function to show a or hide the suspend display box
function HideUnhideSuspendBox(){
	var suspendStatus = jQuery("#UserSuspend").val();
	if(suspendStatus == '1' ){
		jQuery('#suspendCalenderRow_id').show();
	}else{
		jQuery('#suspendCalenderRow_id').hide();
	}
	
}


// function to provide the state dropdown
function displayState(){
	var countryId = jQuery("#countrySelect").val();
	var stateFieldName = jQuery("#stateFieldName").val();
	var selectedStateValue = jQuery("#AddressSelectedState").val();
	if(selectedStateValue == ''){
		selectedStateValue = '1'; // 1 for test value
	}
	if(countryId == ''){
		countryId = '0'; // 0 for test value
	}
	var selectclassName = 'textbox-m';
	var textclassName = 'textbox-m';
	//if(countryId > 0){ 
		var url = SITE_URL+'totalajax/DisplayStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue+'/'+selectclassName+'/'+textclassName;
		jQuery('#preloader').show();
		jQuery.ajax({
			cache:false,
			async:false,
			type: "GET",
			url:url,
			success: function(msg){
				jQuery('#stateTextSelect').html(msg);
				jQuery('#preloader').hide();
			}
		});
	//}
}
</script>


<?php echo $form->create('Seller',array('action'=>'add/'.base64_encode($id),'method'=>'POST','name'=>'frmUser','id'=>'frmUser'));?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td class="adminGridHeading heading"  height="25px" align="right"></td>
	</tr>
	
	<tr>
	<td colspan="2">
		<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
        <tr height="2">
                <td  align="right"></td>
                <td align="left"></td>
        </tr>
        <tr class="adminGridHeading heading">
                <td colspan="2"><strong>Personal Details</strong></td>
        </tr>
        <tr height="20px">
                <td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Title :</td>
                <td>
                        <?php echo $form->select('User.title', $title, $this->data['User']['title'], array('type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1), 'Select Title');
                        echo $form->error('User.title'); ?>
                </td>
        </tr>
	
	<tr>
                <td align="right" valign="top"><span class="error_msg">*</span> First name :</td>
                <td>
                        <?php echo $form->input('User.firstname',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
                
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Last name :</td>
                <td>
                        <?php echo $form->input('User.lastname',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Email address :</td>
                <td>
        <?php echo $form->input('User.email',array('size'=>'30','maxlength'=>'50', 'class'=>'textbox-m','label'=>false,'div'=>false));?>
        <?php echo $form->hidden('User.id',array('size'=>'30','maxlength'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
                
        </tr>
        
        <?php if(empty($this->data['User']['id'])) { ?>
        <tr>
                <td align="right"><span class="error_msg">*</span> Password :</td>
                <td>
                        <?php echo $form->input('User.password',array('size'=>'30','maxlength'=>'40','class'=>'textbox-m','type'=>'password','label'=>false,'value'=>'','div'=>false));?>
                </td>
        </tr>
        <tr>
                <td align="right"><span class="error_msg">*</span> Confirm password :</td>
                <td>
                        <?php echo $form->input('User.confirmpassword',array('size'=>'30','maxlength'=>'40','class'=>'textbox-m','type'=>'password','label'=>false,'value'=>'','div'=>false)); ?>
                </td>
        </tr>
        <?php }?>
        
	<tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Address Line 1 :</td>
                <td>
		 <?php echo $form->input('User.address1',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
       <br/> <br><div class="note">Company name/House name number and Street, PO Box, C/O</div>
                </td>
                
        </tr>
        <tr>
                <td align="right" valign="top">Address Line 2 :</td>
                <td>
        <?php echo $form->input('User.address2',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
	
                </td>
                
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Town/City :</td>
                <td>
        <?php echo $form->input('User.city',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
                
        </tr>
	
	
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Postcode :</td>
                <td>
        <?php echo $form->input('User.postcode',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
                
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Country :</td>
                <td>
        <?php echo $form->select('User.country_id',$countries,null,array('id'=>'countrySelect','onchange'=>'displayState()', 'type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1) ,'Select Country' ); 
                echo $form->error('User.country_id'); ?>
                </td>
                
        </tr>
	<tr>
		<td align="right" valign="top"><span class="error_msg">*</span> State :</td>
		<td >
		 <input type="hidden" name="stateFieldName" id="stateFieldName" value="User.state">
		<?php
		
		
		echo $form->hidden('Address.selected_state', array('value'=>$this->data['User']['state']));	?>
		<div id="stateTextSelect">
		<?php echo $form->input('User.state',array('class'=>'textbox-m','label'=>false,'div'=>false));
		?>
		</div>
		  <?php //echo $form->error('Address.add_state'); ?>
		</td>
		
	</tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Phone Number :</td>
                <td>
        <?php echo $form->input('User.phone',array('class'=>'textbox-m','label'=>false,'div'=>false,'maxlength'=>100));?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top">Contact By Telephone :</td>
                <td>
        <?php echo $form->checkbox('User.contact_by_phone',array("class"=>"textbox-m","label"=>false,"div"=>false)); ?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top">Contact By Partners :</td>
                <td>
        <?php echo $form->checkbox('User.contact_by_partner',array("class"=>"textbox-m","label"=>false,"div"=>false)); ?>
                </td>
        </tr>
        
        <tr>
                <td align="right" valign="top">Status :</td>
                <td>
        <?php echo $form->select('User.status', array('1'=>'Active','0'=>'Inactive'), null, array('type'=>'select','class'=>'textbox-s','label'=>false,'div'=>false,'size'=>1), 'Select Status'); 
                        echo $form->error('User.status'); ?>
                </td>
        </tr>
	 <tr>
                <td align="right" valign="top">Suspend :</td>
                <td>
        <?php echo $form->select('User.suspend', array('1'=>'Yes','0'=>'No'), null, array('type'=>'select','class'=>'textbox-s','label'=>false,'div'=>false,'size'=>1), 'Select'); 
                        ?>
                </td>
        </tr>
       <tr id="suspendCalenderRow_id" style="display:none;">
                <td align="right" valign="top">Suspended Till :</td>
                <td>
                        <?php
                        echo $form->input('User.suspend_date',array('autocomplete'=>'off','type'=>'text','size'=>'15','label'=>false,'div'=>false,'class'=>'textbox-s','readonly'=>'readonly')); 									
                        echo $html->image('calendar/cal.gif',array('border'=>'0','alt'=>'','onClick'=>"displayCalendar(document.forms[0].UserSuspendDate,'dd/mm/yyyy',this)"));
                        ?>
                </td>
        </tr>
        <tr class="adminGridHeading heading">
                <td colspan="2"><strong>Business Details</strong></td>
        </tr>
        
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Business Name : </td>
                <td align="left">
                        <?php echo $form->input('Seller.business_name',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Business Display Name :</td>
                <td align="left">
                        <?php echo $form->input('Seller.business_display_name',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
        </tr>
       
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Secret Question : </td>
                <td align="left">
                <?php echo $form->select('Seller.secret_question',$security_questions,null,array('type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1) ,'Select' );
                echo $form->error('Seller.secret_question'); ?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Answer :</td>
                <td align="left">
                <?php echo $form->input('Seller.secret_answer',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Service Email :</td>
                <td align="left">
                <?php echo $form->input('Seller.service_email',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                <?php echo $form->hidden('Seller.id',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top">Bank Sort Code :</td>
                <td align="left">
                <?php echo $form->input('Seller.bank_sort_code',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top">Bank Account Number :</td>
                <td align="left">
                <?php echo $form->input('Seller.bank_account_number',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top">Account Holder Name :</td>
                <td align="left">
                <?php echo $form->input('Seller.account_holder_name',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top">Paypal Account Email :</td>
                <td align="left">
                <?php echo $form->input('Seller.paypal_account_mail',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?></td>
        </tr>
        <tr>
                <td align="right" valign="top">Account Holder Name : </td>
                <td align="left">
                <?php echo $form->input('Seller.account_holder_name',array('size'=>'40','class'=>'textbox-m','label'=>false,'div'=>false));?></td>
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Free Delivery : </td>
                <td align="left">
                        <?php
                        $options=array('0'=>' Disabled ','1'=>' Enabled ');
                        $attributes=array('legend'=>false,'label'=>false);
                        echo $form->radio('Seller.free_delivery',$options,$attributes);?>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top">Free Delivery Threshold : </td>
                <td align="left"> 
                        <?php echo $form->input('Seller.threshold_order_value',array('size'=>'30','class'=>'textbox-s','maxlength'=>'30','label'=>false,'div'=>false,'error'=>false)); echo $form->error('Seller.threshold_order_value'); ?><br /><div style=""> e.g. 35.00</div>
                </td>
        </tr>
        <tr>
                <td align="right" valign="top"><span class="error_msg">*</span> Gift Service : </td>
                <td align="left">
                <?php echo $form->select('Seller.gift_service',array('0'=>'No','1'=>'Yes'),null,array('type'=>'select','class'=>'textbox-m','label'=>false,'div'=>false,'size'=>1) ,'Select' );
                echo $form->error('Seller.gift_service'); echo $form->hidden('User.id');
		echo $form->hidden('Address.id');?></td>
        </tr>
        <tr>
                <td colspan="2">&nbsp;</td></tr>
        <tr>
                <td>&nbsp;</td>
                <td align="left">
                <?php if(!empty($this->data['User']['id'])) {
                        echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
                } else {
                        echo $form->button('Add',array('type'=>'submit','class'=>'btn_53','div'=>false));
                }?>
                <?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/sellers')"));?>
                </td>
        </tr>
	
	</table>
	</td>
	</tr>
</table>


<?php 

echo $form->end();
// echo $validation->rules(array('User'),array('formId'=>'frmUser'));
?>
<!--<script>
alert(jQuery("input[name='data[User][firstname]']").val() );
jQuery("input[name='data[User][firstname]']").val('raman');
</script>-->
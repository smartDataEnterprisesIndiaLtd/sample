<?php ?>
<style>
#updateadd .form-widget label { float: left!important; padding: 5px!important; } 
</style>
<script type="text/javascript" language="javascript">	

	jQuery(document).ready( function(){
		jQuery('#AddressCountryId').change(function() {
			displayState();
		})
	});
	
// function to provide the state dropdown
function displayState(){
	var countryId = jQuery("#AddressCountryId").val();
	var stateFieldName = jQuery("#addressStateFieldName").val();
	var selectedStateValue = jQuery("#AddressSelectedState").val();
	if(countryId == ''){
		countryId = '0';
	}
	if(selectedStateValue == ''){
		selectedStateValue = '1';
	}
	var selectclassName = 'select '+ jQuery("#addStateText").val();
	var textclassName = 'form-textfield '+ jQuery("#addStateText").val();
	
	if(countryId != ''){
		var url = SITE_URL+'totalajax/DisplayStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue+'/'+selectclassName+'/'+textclassName;
		//alert(url);
		jQuery('#plsLoaderID').show();
		jQuery('#fancybox-overlay-header').show();
		jQuery.ajax({
			cache:false,
			async:false,
			type: "GET",
			url:url,
			success: function(msg){
				jQuery('#addressStateTextSelect_div').html(msg);
				jQuery('#plsLoaderID').hide();
				jQuery('#fancybox-overlay-header').hide();
			}
		});
	}
}


</script>
<?php 
if (!empty($change_address)) { ?>

<div id="updateadd">
<div class="billing-info-left">
	<h2 class="gray margin-bottom">Billing Information</h2>
	<p align="center" class="font-size10 pad-btm"><strong>Where are your credit-card statements sent?</strong></p>
	<div class="form-widget">
		<?php echo $form->create('Checkout',array('action'=>'change_add','method'=>'POST','name'=>'frmCheckout','id'=>'frmCheckout'));?>
		<ul>
			<li>
				<label><span class="star">*</span> Title :</label>
				<div class="form-field-widget">
					<?php
					if(!empty($errors['title'])){
						$errorTitle ='select small-width error_message_box';
					}else{
						$errorTitle ='select small-width';
					}
					echo $form->select('Address.title',$titles,null,array('type'=>'select','class'=>$errorTitle,'label'=>false,'div'=>false,'size'=>1),'Select');
					echo $form->error('Address.title'); ?>
				</div>
			</li>
			<li>
				<label><span class="star">*</span> First Name:</label>
				<div class="form-field-widget">
					<?php
					if(!empty($errors['add_firstname'])){
						$errorAddFirstName ='form-textfield error_message_box';
					}else{
						$errorAddFirstName ='form-textfield';
					} 
					echo $form->input('Address.add_firstname',array('maxlength'=>'50','size'=>'30','class'=>$errorAddFirstName,'label'=>false,'div'=>false));
					?>
				</div>
			</li>
			<li>
				<label><span class="star">*</span> Surname:</label>
				<div class="form-field-widget">
					<?php
					if(!empty($errors['add_lastname'])){
						$errorAddLastName ='form-textfield error_message_box';
					}else{
						$errorAddLastName ='form-textfield';
					}
					echo $form->input('Address.add_lastname',array('maxlength'=>'50','size'=>'30','class'=>$errorAddLastName,'label'=>false,'div'=>false));
					?>
				</div>
			</li>
			<li>
				<label><span class="star">*</span> Address:</label>
				<div class="form-field-widget">
					<?php
					if(!empty($errors['add_address1'])){
						$errorAddAddress1 ='form-textfield error_message_box';
					}else{
						$errorAddAddress1 ='form-textfield';
					}
					echo $form->input('Address.add_address1',array('maxlength'=>'30','size'=>'30','class'=>$errorAddAddress1,'label'=>false,'div'=>false));
					?>
				</div>
			</li>
			<li>
				<label> </label>
				<div class="form-field-widget">
					<?php echo $form->input('Address.add_address2',array('maxlength'=>'30','size'=>'30','class'=>'form-textfield','label'=>false,'div'=>false));
					?>
				</div>
			</li>
			<li>
				<label><span class="star">*</span> Town:</label>
				<div class="form-field-widget">
					<?php
					if(!empty($errors['add_city'])){
						$errorAddCity ='form-textfield error_message_box';
					}else{
						$errorAddCity ='form-textfield';
					}
					echo $form->input('Address.add_city',array('maxlength'=>'30','size'=>'30','class'=>$errorAddCity,'label'=>false,'div'=>false));
					?>
				</div>
			</li>
			<li>
				<label><span class="star">*</span> Country :</label>
				<div class="form-field-widget">
					<?php
					if(!empty($errors['country_id'])){
						$errorCountryId ='form-textfield error_message_box';
					}else{
						$errorCountryId ='form-textfield';
					}
					echo $form->select('Address.country_id',$countries,null,array('type'=>'select','class'=>$errorCountryId,'label'=>false,'div'=>false,'size'=>1),'Select');
						echo $form->error('Address.country_id'); 
					?>
					</div>
			</li>
			<li>
				<label><span class="star">*</span> State/county:</label>
				<input type="hidden" name="addressStateFieldName" id="addressStateFieldName" value="Address.add_state">
				<?php
				if(isset($this->data['Address']['add_state'])){
					$this->data['Address']['add_state'] = $this->data['Address']['add_state'];
				}else{
					$this->data['Address']['state'] = '';
				}
				echo $form->hidden('Address.selected_state', array('value'=>@$this->data['Address']['add_state'] ));?>
					
				<!--<div class="form-field-widget" >-->
					<span id="addressStateTextSelect_div" >
					<?php
					if(!empty($errors['add_state'])){
						$errorAddState ='error_message_box';
					}else{
						$errorAddState ='';
					} ?>
					<input type="hidden" name="addStateText" id="addStateText" value="<?php echo $errorAddState; ?>">
					<?php echo $form->input('Address.add_state',array('maxlength'=>'30','size'=>'30','maxlength'=>'30','class'=>$errorAddState,'label'=>false,'div'=>false));?>
					</span>
				<!--</div>-->
			</li>
			<li>
				<label><span class="star">*</span> Post Code:</label>
				<div class="form-field-widget">
					<?php
					if(!empty($errors['add_postcode'])){
						$errorAddPostcode ='form-textfield error_message_box';
					}else{
						$errorAddPostcode ='form-textfield';
					}
					echo $form->input('Address.add_postcode',array('maxlength'=>'30','size'=>'30','class'=>$errorAddPostcode,'label'=>false,'div'=>false)); 
					?>
				</div>
			</li><!--
			<li>
				<label><span class="star">*</span> Telephone No:</label>
				<div class="form-field-widget">
				<input type="text" value="0780 777777" class="form-textfield" name="textfield2"/>
				</div>
			</li>-->
			<li>
				<label> </label>
				<div class="form-field-widget">
					<?php /*$options=array(
						"url"=>"/checkouts/change_add",
						//"with"=>"console.log('updateadd')",
						"update"=>"billing_address",
						"indicator"=>"plsLoaderID",
						'loading'=>"Element.show('plsLoaderID')",
						"complete"=>"Element.hide('plsLoaderID'); document.getElementById('updateaddchange').innerHTML=''",
						"class" =>"",
						"type"=>"Submit",
						"id"=>"myAddress",
					); */ ?>
					
					<?php //echo $ajax->submit('checkout/continue-checkout.gif',$options);?>
					<?php echo $form->button('',array('type'=>'submit','class'=>'cahnge_add_btn','div'=>false)); ?>
				</div>
				<!--<div class=""><input type="image" src="/img/checkout/continue-checkout-btn.png" name="button2" value=" "/></div>-->
			</li>
		</ul>
		<?php echo $form->end();?>
	</div>
	<p class="sml-fnt">* Required Field</p>
</div></div>
<?php } else
{}
?>

<script type="text/javascript" language="javascript">	
displayState();
</script>
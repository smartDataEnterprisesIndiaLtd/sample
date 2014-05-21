<?php ?>
<script defer="defer" type="text/javascript" language="javascript">	

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
	var selectclassName = 'select';
	var textclassName = 'form-textfield';
	if(countryId != ''){
		var url = SITE_URL+'totalajax/DisplayStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue+'/'+selectclassName+'/'+textclassName;
		//alert(url);
		jQuery('#preloader').show();
		jQuery.ajax({
			cache:false,
			async:false,
			type: "GET",
			url:url,
			success: function(msg){
				jQuery('#addressStateTextSelect_div').html(msg);
				jQuery('#preloader').hide();
			}
		});
	}
}


</script>
<style>
.checkout_info li{border-bottom:none;}
.checkout_info li input[type="text"] { border:0 0 0 0;}
</style>
<?php 
if (!empty($change_address)) { ?>
<div id="updateadd">
<div class="billing-info-left">
	<h2 class="gray margin-bottom">Billing Information</h2>
	<p align="center" class="font-size10 pad-btm"><strong>Where are your credit-card statements sent?</strong></p>
	<div class="form-widget">
		<?php echo $form->create('Checkout',array('action'=>'change_add','method'=>'POST','name'=>'frmCheckout','id'=>'frmCheckout'));?>
		 <ul class="signinlist xprsrgstrson xprsfrm2">
                       	<li>
				<label>Title:</label>
				<div class="field">
					<p class="pad-rt12">
					<?php echo $form->select('Address.title',$titles,null,array('type'=>'select','class'=>'select small-width','label'=>false,'div'=>false,'size'=>1),'Select');
					echo $form->error('Address.title');
					if(!empty($errors['title']))
						echo '<div class="error-message">'.$errors['title'].'</div>';?>
				</div>
			</li>
			
			
			<li>
				<label>First name:</label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->input('Address.add_firstname',array('maxlength'=>'50','size'=>'30','class'=>'form-textfield','label'=>false,'div'=>false));
						if(!empty($errors['add_firstname']))
						echo '<div class="error-message">'.$errors['add_firstname'].'</div>';
						?>
					</p>
				</div>
			</li>
			
			<li>
				<label>Last name:</label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->input('Address.add_lastname',array('maxlength'=>'50','size'=>'30','class'=>'form-textfield','label'=>false,'div'=>false));
						if(!empty($errors['add_lastname']))
						echo '<div class="error-message">'.$errors['add_lastname'].'</div>';
						?>
					</p>
				</div>
			</li>
			
			<li>
				<label>Address Line 1:</label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->input('Address.add_address1',array('maxlength'=>'30','size'=>'30','class'=>'form-textfield','label'=>false,'div'=>false));
						if(!empty($errors['add_address1']))
						echo '<div class="error-message">'.$errors['add_address1'].'</div>';
						?>
					</p>
				</div>
			</li>
			
			<li>
				<label style="color:#000;">Address Line 2:</label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->input('Address.add_address2',array('maxlength'=>'30','size'=>'30','class'=>'form-textfield','label'=>false,'div'=>false));?>
					</p>
					<span class="opsonal">Optional</span>
				</div>
			</li>
			
			<li>
				<label>Town/City:</label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->input('Address.add_city',array('maxlength'=>'30','size'=>'30','class'=>'form-textfield','label'=>false,'div'=>false));
						if(!empty($errors['add_city']))
						echo '<div class="error-message">'.$errors['add_city'].'</div>';
						?>
					</p>
				</div>
			</li>
			
			<li>
				<label>Country:</label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->select('Address.country_id',$countries,null,array('type'=>'select','class'=>'form-textfield','label'=>false,'div'=>false,'size'=>1),'Select');
						echo $form->error('Address.country_id'); 
						if(!empty($errors['country_id']))
						echo '<div class="error-message">'.$errors['country_id'].'</div>';
						?>
					</p>
					</div>
			</li>
			
			<li>
				<label>State/County:</label>
					<div class="field">
					<p class="pad-rt12">
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
						<?php echo $form->input('Address.add_state',array('maxlength'=>'30','size'=>'30','maxlength'=>'30','class'=>'form-textfield','label'=>false,'div'=>false));?>
						</span>
					<!--</div>-->
						<?php  
							if(!empty($errors['add_state']))
								echo '<label> </label><div class="error-message">'.$errors['add_state'].'</div>';
						?>
					</p>
					</div>
			</li>
			<li>
				<label>Postcode:</label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->input('Address.add_postcode',array('maxlength'=>'30','size'=>'30','class'=>'form-textfield','label'=>false,'div'=>false)); 
						if(!empty($errors['add_postcode']))
						echo '<div class="error-message">'.$errors['add_postcode'].'</div>';?>
					</p>
				</div>
			</li>
			
			<li>
				<label> </label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->button('Continue',array('type'=>'submit','class'=>'signinbtnwhyt cntnuchkot','div'=>false)); ?>
					</p>
				</div>
				
			</li>
		</ul>
		<?php echo $form->end();?>
	</div>
	<p class="sml-fnt">* Required Field</p>
</div></div>
<?php } else
{}
?>

<script defer="defer" type="text/javascript" language="javascript">	
displayState();
</script>
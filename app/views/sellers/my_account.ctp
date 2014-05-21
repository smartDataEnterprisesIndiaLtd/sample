<?php
 echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);?>

<style type="text/css">
.messageBlock {
border:0px;
margin:0px
}
.form-error {
  float: none;
  background-color:#FFE5E5;
}
</style>

<script language="JavaScript">	
// function to provide the state dropdown

function displayState(){
	//alert('Hello');
	var countryId = jQuery("#SellerCountryId").val();
	var stateFieldName = jQuery("#userStateFieldName").val();
	var selectedStateValue = jQuery("#AddressSelectedState").val();
	if(countryId == ''){
		countryId = '0';
	}
        if(selectedStateValue == ''){
		selectedStateValue = '1';
	}
	//var selectclassName = 'select';
	//var textclassName = 'form-textfield';
	var selectclassName = jQuery("#textclassSelectId").val();
	var textclassName = jQuery("#textclassNameId").val();
            var url = SITE_URL+'totalajax/DisplayStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue+'/'+selectclassName+'/'+textclassName;
	   //var url = SITE_URL+'totalajax/DisplayStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue+'/'+textclassName;
            //alert(url);
            jQuery('#plsLoaderID').show();
            jQuery.ajax({
                    cache:false,
                    async:false,
                    type: "GET",
                    url:url,
                    success: function(msg){
                            jQuery('#userStateTextSelect_div').html(msg);
                            jQuery('#plsLoaderID').hide();
                    }
            });
	
}
</script>
<div id="my-account"><?php echo $this->element('marketplace/updateseller');?></div>
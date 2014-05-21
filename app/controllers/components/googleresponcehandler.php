<?php
/**
 * Copyright (C) 2007 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

 /* This is the response handler code that will be invoked every time
  * a notification or request is sent by the Google Server
  *
  * To allow this code to receive responses, the url for this file
  * must be set on the seller page under Settings->Integration as the
  * "API Callback URL'
  * Order processing commands can be sent automatically by placing these
  * commands appropriately
  *
  * To use this code for merchant-calculated feedback, this url must be
  * set also as the merchant-calculations-url when the cart is posted
  * Depending on your calculations for shipping, taxes, coupons and gift
  * certificates update parts of the code as required
  *
  */

/** import all the venders  required files */
//App::import('Vendor','googlelog' ,array('file'=>'googlecheckout/googlelog.php'));
App::import('Vendor','googleresponse' ,array('file'=>'googlecheckout/googleresponse.php'));
App::import('Vendor','googlemerchantcalculations' ,array('file'=>'googlecheckout/googlemerchantcalculations.php'));
App::import('Vendor','googleresult' ,array('file'=>'googlecheckout/googleresult.php'));
App::import('Vendor','googlerequest' ,array('file'=>'googlecheckout/googlerequest.php'));


class GoogleresponcehandlerComponent extends Object{
    
     var $components =  array('Session','Email','File', 'Common','Ordercom');
  
    
    /**
     *@ function to prcess the payment gateway responce from the google checkout
     *# created by: kulvinder singh
     *@ created : 20 May 2011
     */
    function processGoogleResponce(){
	  define('MODULE_CGI', 'True'); 
	  
	  define('RESPONSE_HANDLER_ERROR_LOG_FILE', 'googleerror.log');
	  define('RESPONSE_HANDLER_LOG_FILE', 'googlemessage.log');
	  
	  
	 
	 // $server_type = 'sandbox';    // sandbox - live
	  //$currency =  "USD";
	  $server_type = 'live';    // sandbox - live
          $currency = "GBP";
	  
	  if($server_type == "live"){
	       $merchant_id 	= MERCHANT_ID_GC_LIVE;
	       $merchant_key 	= MERCHANT_KEY_GC_LIVE;
	       
	  }else{ // kulvinder test account info
	       $merchant_id 	= MERCHANT_ID_GC_TEST;
	       $merchant_key 	= MERCHANT_KEY_GC_TEST;
	  }
	       
	  //$currency = 'GBP';  // set to GBP if in the UK
	       
	  $Gresponse = new GoogleResponse($merchant_id, $merchant_key);
	  $Grequest = new GoogleRequest($merchant_id, $merchant_key, $server_type, $currency);
	       
	       
	     $certificate_path = "/etc/ssl/certs/choiceful.com.crt"; // set your SSL CA cert path
  
	       //$Gresponse = new GoogleResponse($merchant_id, $merchant_key);
	       //$Grequest = new GoogleRequest($merchant_id, $merchant_key, $server_type, $currency);
	       $Grequest->SetCertificatePath($certificate_path);
	       
	       
	  //Setup the log file
	  $Gresponse->SetLogFiles(RESPONSE_HANDLER_ERROR_LOG_FILE, RESPONSE_HANDLER_LOG_FILE, L_ALL);
	       
	  // Retrieve the XML sent in the HTTP POST request to the ResponseHandler
	       
	       
	  $xml_response = isset($HTTP_RAW_POST_DATA)?  $HTTP_RAW_POST_DATA:file_get_contents("php://input");
	       
	  if (get_magic_quotes_gpc()) {
	   $xml_response = stripslashes($xml_response);
	  }
	       
	  list($root, $data) = $Gresponse->GetParsedXML($xml_response);
	  $Gresponse->SetMerchantAuthentication($merchant_id, $merchant_key);
	       
	   $responseData['status'] 	= 	'';
	   
	       
	  switch ($root) :
	       case "request-received": {
	       break;
	  }
	       case "error": {
	       break;
	  }
	       case "diagnosis": {
	       break;
	  }
	       case "checkout-redirect": {
	       break;
	  }
	    case "new-order-notification": {
	    
	       $googleOrderNumber 		= $data[$root]['google-order-number']['VALUE'];  
	       $orderDataArray 		= explode('~',$data[$root]['shopping-cart']['merchant-private-data']['VALUE']);
	       $choicefulSessionID   	= $orderDataArray[0];             
	       $choicefulOrderNumber 	= $orderDataArray[1];
	       $choicefulOrderType	 	= $orderDataArray[2];
	       $responseData['order_type'] 	= $choicefulOrderType;
		
	       $responseData['tranx_id'] 	= $googleOrderNumber;
	       $responseData['order_number'] 	= $choicefulOrderNumber;
	       $responseData['status'] 	= 'OK';
	       $Gresponse->SendAck();
      break;
    }
    case "order-state-change-notification": {
     /*
      $Gresponse->SendAck();
      $new_financial_state   = $data[$root]['new-financial-order-state']['VALUE'];
      $new_fulfillment_order = $data[$root]['new-fulfillment-order-state']['VALUE'];

      switch($new_financial_state) {
        case 'REVIEWING': {
          break;
        }
        case 'CHARGEABLE': {
          //$Grequest->SendProcessOrder($data[$root]['google-order-number']['VALUE']);
          //$Grequest->SendChargeOrder($data[$root]['google-order-number']['VALUE'],'');
          break;
        }
        case 'CHARGING': {
          break;
        }
        case 'CHARGED': {
          break;
        }
        case 'PAYMENT_DECLINED': {
          break;
        }
        case 'CANCELLED': {
          break;
        }
        case 'CANCELLED_BY_GOOGLE': {
          //$Grequest->SendBuyerMessage($data[$root]['google-order-number']['VALUE'],
          //    "Sorry, your order is cancelled by Google", true);
          break;
        }
        default:
          break;
      }
     */
      
      break;
    }
    case "charge-amount-notification": {
      //$Grequest->SendDeliverOrder($data[$root]['google-order-number']['VALUE'],
      //    <carrier>, <tracking-number>, <send-email>);
      //$Grequest->SendArchiveOrder($data[$root]['google-order-number']['VALUE'] );
      $Gresponse->SendAck();
      break;
    }
    case "chargeback-amount-notification": {
      $Gresponse->SendAck();
      break;
    }
    case "refund-amount-notification": {
      $Gresponse->SendAck();
      break;
    }
    case "risk-information-notification": {
      $Gresponse->SendAck();
      break;
    }
    default:
      $Gresponse->SendBadRequestStatus("Invalid or not supported Message");
      $responseData['status'] = 'FAIL';
      break;
     
  endswitch;
  
   
   return $responseData;

  /* In case the XML API contains multiple open tags
     with the same value, then invoke this function and
     perform a foreach on the resultant array.
     This takes care of cases when there is only one unique tag
     or multiple tags.
     Examples of this are "anonymous-address", "merchant-code-string"
     from the merchant-calculations-callback API
  */
  
    }
    
    
     function get_arr_result($child_node) {
       $result = array();
       if(isset($child_node)) {
	 if(is_associative_array($child_node)) {
	   $result[] = $child_node;
	 }
	 else {
	   foreach($child_node as $curr_node){
	     $result[] = $curr_node;
	   }
	 }
       }
       return $result;
     }

     /* Returns true if a given variable represents an associative array */
     function is_associative_array( $var ) {
       return is_array( $var ) && !is_numeric( implode( '', array_keys( $var ) ) );
     }
  
  
  
  
  
  
      function processGoogleResponceGiftcertificate(){
	  define('MODULE_CGI', 'True'); 
     
	  define('RESPONSE_HANDLER_ERROR_LOG_FILE', 'googleerror.log');
	  define('RESPONSE_HANDLER_LOG_FILE', 'googlemessage.log');
	 
	  //$server_type = 'sandbox';    // sandbox - live
	  //$currency =  "USD";
	  $server_type = 'live';    // sandbox - live
          $currency = "GBP";
	  if($server_type == "live"){
	       $merchant_id 	= MERCHANT_ID_GC_LIVE;
	       $merchant_key 	= MERCHANT_KEY_GC_LIVE;
	  
	  }else{ // kulvinder test account info
	       $merchant_id 	= MERCHANT_ID_GC_TEST;
	       $merchant_key 	= MERCHANT_KEY_GC_TEST;
	  }
	  
	 // $currency = 'GBP';  // set to GBP if in the UK
	  
	  $Gresponse = new GoogleResponse($merchant_id, $merchant_key);
	  $Grequest = new GoogleRequest($merchant_id, $merchant_key, $server_type, $currency);
	  
	  //Setup the log file
	  $Gresponse->SetLogFiles(RESPONSE_HANDLER_ERROR_LOG_FILE, RESPONSE_HANDLER_LOG_FILE, L_ALL);
	  
	  // Retrieve the XML sent in the HTTP POST request to the ResponseHandler
	 

	  $xml_response = isset($HTTP_RAW_POST_DATA)?  $HTTP_RAW_POST_DATA:file_get_contents("php://input");
	       
	  if (get_magic_quotes_gpc()) {
	   $xml_response = stripslashes($xml_response);
	  }
	  
	  
	  list($root, $data) = $Gresponse->GetParsedXML($xml_response);
	  $Gresponse->SetMerchantAuthentication($merchant_id, $merchant_key);
	  
	   $responseData['status'] 	= 	'';
	   
	    //$responseData['order_number'] = 1111;
	    //$responseData['tranx_id'] 	=  22222;
	    //$responseData['status'] = 'YES';
	    //
	  
	 // mail('kulvinder2@gmail.com', 'Google checkout order number', $order_number);
	  
	  
	  switch ($root) {
	       case "request-received": {
		 break;
	       }
	       case "error": {
		    break;
	       }
	       case "diagnosis": {
		    break;
	       }
	       case "checkout-redirect": {
		    break;
	       }
	       case "new-order-notification": {
	    
		    $googleOrderNumber 		= $data[$root]['google-order-number']['VALUE'];  
		    $orderDataArray 		= explode('~',$data[$root]['shopping-cart']['merchant-private-data']['VALUE']);
		    $choicefulSessionID   	= $orderDataArray[0];             
		    $choicefulOrderId 	= $orderDataArray[1];
		    
		    $responseData['tranx_id'] 	= $googleOrderNumber;
		    $responseData['order_id'] = $choicefulOrderId;
		    $responseData['status'] 	= 'OK';
		    $Gresponse->SendAck();
		    break;
	       }
	       case "order-state-change-notification": {
		   
	         break;
	       }
	       case "charge-amount-notification": {
		    
		    $Gresponse->SendAck();
		    break;
	       }
	       case "chargeback-amount-notification": {
	         $Gresponse->SendAck();
	         break;
	       }
	       case "refund-amount-notification": {
	         $Gresponse->SendAck();
	         break;
	       }
	       case "risk-information-notification": {
	         $Gresponse->SendAck();
	         break;
	       }
	       default:
		    $Gresponse->SendBadRequestStatus("Invalid or not supported Message");
		    $responseData['status'] = 'FAIL';
		    break;
	  }
	  mail('gyanp.sdei@gmail.com', 'after switch',$choicefulOrderId );
	  return $responseData;
     }
    
    

    }
?>
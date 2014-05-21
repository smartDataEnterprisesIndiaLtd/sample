<?php



class SageComponent extends Object{
    
    var $strVSPVendorName      = ""; /** Set this value to the VSPVendorName assigned to you by protx or chosen when you applied **/
    var $strEncryptionPassword = "";  /** Set this value to the XOR Encryption password assigned to you by Protx uDo145K2U3Br6CMw**/
    var $strCurrency	       = "";		 /** Set this to indicate the currency in which you wish to trade. You will need a merchant number in this currency **/
    var $strVendorEMail        = "";  /** Set this to the mail address which will receive order confirmations and failures **/
    var $strTransactionType    = ""; /** This can be DEFERRED or AUTHENTICATE if your Protx account supports those payment types **/
    var $strPurchaseURL;
    var $fields = array();
    
    var $components = array('Common');
    function __construct(){
        
        //$this->strVSPVendorName      = "akaluklimited"; // Set this value to the VSPVendorName assigned to you by protx or chosen when you applied **/
        //$this->strEncryptionPassword = "Qy74eRX7uRF56vmM";  // Set this value to the XOR Encryption password assigned to you by Protx uDo145K2U3Br6CMw**/
        //$this->strCurrency	     = "GBP";		// Set this to indicate the currency in which you wish to trade. You will need a merchant number in this currency **/
        //$this->strVendorEMail        = "payment@choiceful.com";  // Set this to the mail address which will receive order confirmations and failures **/
        //$this->strTransactionType    = "PAYMENT"; // This can be DEFERRED or AUTHENTICATE if your Protx account supports those payment types **/
    
    // Commanted Test Fro live sage deatail on 04 Aug 2012
        //$this->strVSPVendorName      = "akaluklimited"; // Set this value to the VSPVendorName assigned to you by protx or chosen when you applied **/
       // $this->strEncryptionPassword = "Qy74eRX7uRF56vmM";  // Set this value to the XOR Encryption password assigned to you by Protx uDo145K2U3Br6CMw**/
       // $this->strCurrency	     = "GBP";		// Set this to indicate the currency in which you wish to trade. You will need a merchant number in this currency **/
       // $this->strVendorEMail        = "payment@choiceful.com";  // Set this to the mail address which will receive order confirmations and failures **/
       // $this->strTransactionType    = "PAYMENT"; // This can be DEFERRED or AUTHENTICATE if your Protx account supports those payment types **/
    
    //Fro live sage deatail on 04 Aug 2012
       // $this->strVSPVendorName      = "akaluklimited"; // Set this value to the VSPVendorName assigned to you by protx or chosen when you applied **/
       // $this->strEncryptionPassword = "J7Zhv3namjguC4Aa";  // Set this value to the XOR Encryption password assigned to you by Protx uDo145K2U3Br6CMw**/
      //  $this->strCurrency	     = "GBP";		// Set this to indicate the currency in which you wish to trade. You will need a merchant number in this currency **/
      //  $this->strVendorEMail        = "payment@choiceful.com";  // Set this to the mail address which will receive order confirmations and failures **/
       // $this->strTransactionType    = "PAYMENT"; // This can be DEFERRED or AUTHENTICATE if your Protx account supports those payment types **/
        
        $this->strVSPVendorName      = "akaluklimited"; // Set this value to the VSPVendorName assigned to you by protx or chosen when you applied **/
        $this->strEncryptionPassword = "Qy74eRX7uRF56vmM";  // Set this value to the XOR Encryption password assigned to you by Protx uDo145K2U3Br6CMw**/
        $this->strCurrency	     = "GBP";		// Set this to indicate the currency in which you wish to trade. You will need a merchant number in this currency **/
        $this->strVendorEMail        = "payment@choiceful.com";  // Set this to the mail address which will receive order confirmations and failures **/
        $this->strTransactionType    = "PAYMENT"; // This can be DEFERRED or AUTHENTICATE if your Protx account supports those payment types **/    
        
        
        // AUTHENTICATE, 
    // Vendor Name:vcvreddy-password:3quvcc8c
    }
    
  
    function add_field($field, $value) {
    
        // adds a key=>value pair to the fields array, which is what will be 
        // sent to paypal as POST variables.  If the value is already in the 
        // array, it will be overwritten.
        
        $this->fields["$field"] = $value;
     
    }
    
    
    
    function getstrPost($order){
        
        $site_url = SITE_URL;    
       
        
        $TotalCartAmount = $order['order_total_cost'];
        
        
        $strSuccessUrl = $site_url."checkouts/protx_return&utm_nooverride=1";
        $strFailureUrl = $site_url."checkouts/protx_error&utm_nooverride=1";
        
        // Now to build the VSP Form crypt field.  For more details see the VSP Form Protocol 2.22
        //$intRandNum = rand(0,32000)*rand(0,32000);
       // $strVendorTxCode = $this->strVSPVendorName.$intRandNum;
       // $strPost ="VendorTxCode =" .$strVendorTxCode;
       
        $strPost = "VendorTxCode=".$order['order_number'];
        $strPost = $strPost . "&VendorEMail=" . $this->strVendorEMail;
       
        $strPost=$strPost . "&Amount=" . number_format($TotalCartAmount,2, '.', ''); // Formatted to 2 decimal places with leading digit
        $strPost=$strPost . "&Currency=" . $this->strCurrency;
        $strPost=$strPost . "&Description=Products from Choiceful.com";
        
        /* The SuccessURL is the page to which VSP Form returns the customer if the transaction is successful 
        ** You can change this for each transaction, perhaps passing a session ID or state flag if you wish */
        $strPost=$strPost . "&SuccessURL=" .$strSuccessUrl;
        $strPost=$strPost . "&FailureURL=" . $strFailureUrl; 
        // The FailureURL is the page to which VSP Form returns the customer if the transaction is unsuccessful
       
       
        $strPost=$strPost . "&eMailMessage=Thank you very much for your order. We will conatct you soon";
        $strPost=$strPost . "&CustomerName=" . $order['billing_firstname']." ".$order['billing_lastname'];
        $strPost=$strPost . "&CustomerEMail=" . $order['user_email'] ;
        $strPost=$strPost . "&BillingSurname=" . $order['billing_lastname'];
        $strPost=$strPost . "&BillingFirstnames=" . $order['billing_firstname'];
        $strPost=$strPost . "&BillingAddress1=" . $order['billing_address1'];
        $strPost=$strPost . "&BillingAddress2=" . $order['billing_address2'];
        $strPost=$strPost . "&BillingCity=" 	. $order['billing_city'];    
        $strPost=$strPost . "&BillingCountry=" .  $order['billing_country'];
     
         if($order['shipping_country'] == 'US'){
               $strPost=$strPost . "&BillingState=".strtoupper(substr($order['billing_state'],0,2));
        }
            
        $strPost=$strPost . "&BillingPhone=" 	. $order['billing_phone'];
        $strPost=$strPost . "&BillingPostCode=" . $order['billing_postal_code'];
        $strPost=$strPost . "&DeliverySurname=" .   $order['shipping_lastname'];
        $strPost=$strPost . "&DeliveryFirstnames=" . $order['shipping_firstname'];
        $strPost=$strPost . "&DeliveryAddress1=" . $order['shipping_address1'];
        $strPost=$strPost . "&DeliveryAddress2=" . $order['shipping_address2'];
        $strPost=$strPost . "&DeliveryCity=" .     $order['shipping_city'];
        $strPost=$strPost . "&DeliveryCountry=" .  $order['shipping_country'];
            
            
        if($order['shipping_country'] == 'US'){
           $strPost=$strPost . "&DeliveryState=" .     strtoupper(substr($order['shipping_state'], 0,2)); 
        }
        $strPost=$strPost . "&DeliveryPhone=" . $order['shipping_phone'];
        $strPost=$strPost . "&DeliveryPostcode=" . $order['shipping_postal_code'];
        
        ############################ $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
        /* Allow fine control over AVS/CV2 checks and rules by changing this value. 0 is Default 
        ** It can be changed dynamically, per transaction, if you wish.  See the VSP Server Protocol document */
        if ($this->strTransactionType != "AUTHENTICATE"){
            $strPost=$strPost . "&ApplyAVSCV2=0";
        }
        /* Allow fine control over 3D-Secure checks and rules by changing this value. 0 is Default 
        ** It can be changed dynamically, per transaction, if you wish.  See the VSP Server Protocol document */
      $strPost=$strPost . "&Apply3DSecure=0";
    //echo $strPost; die;
       return $strPost;
    }
   
   function submit_post() {
        
      // The user will briefly see a message on the screen that reads:
      // "Please wait, your order is being processed..." and then immediately
      // is redirected to sage payment gateway.
        
      echo "<html>\n";
      echo "<head><title>Processing Payment...</title></head>\n";
      echo "<body onLoad=\"document.form.submit();\">\n";
      echo "<center><h3>Please wait, your order is being processed...</h3></center>\n";
      echo "<form method=\"post\" name=\"form\" action=\"".$this->gateway_url."\">\n";
      echo "<input type=\"hidden\" name=\"VPSProtocol\" value=\"2.23\">\n";
      
    //pr($this->fields);
      foreach ($this->fields as $name => $value) {
         echo "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
      }
      echo "</form>\n";
      echo "</body></html>\n";
      
    
    
   }
   
   
    
   #
    function base64Encode($plain) {
         $output = "";
         $output = base64_encode($plain);
         return $output;
    }
    
    ###
    function base64Decode($scrambled) {
        $output = "";
        $scrambled = str_replace(" ","+",$scrambled);
        $output = base64_decode($scrambled);
        return $output;
    }
    
    
    function simpleXor($InString, $Key) {
        
         $KeyList = array();
         $output = ""; 
         for($i = 0; $i < strlen($Key); $i++){
            $KeyList[$i] = ord(substr($Key, $i, 1));
         }
        
         for($i = 0; $i < strlen($InString); $i++) {    
            $output.= chr(ord(substr($InString, $i, 1)) ^ ($KeyList[$i % strlen($Key)]));
         }
         
        //pr($output) ;die();
        return $output;
    }


    /* The getToken function.                                                                                         **
    ** NOTE: A function of convenience that extracts the value from the "name=value&name2=value2..." VSP reply string **
    ** Works even if one of the values is a URL containing the & or = signs.                                      	  */
    
    function getToken($thisString) {
    
        // List the possible tokens
        $Tokens = array("Status",
                "StatusDetail",
                "VendorTxCode",
                "VPSTxId",
                "TxAuthNo",
                "Amount",
                "AVSCV2", 
                "AddressResult", 
                "PostCodeResult", 
                "CV2Result", 
                "GiftAid", 
                "3DSecureStatus", 
                "CAVV",
                "CardType",
                "Last4Digits"
                ); 
    
    // Initialise arrays
    $output = array();
    $resultArray = array();
    
    // Get the next token in the sequence
    for ($i = count($Tokens)-1; $i >= 0 ; $i--){
        // Find the position in the string
        $start = strpos($thisString, $Tokens[$i]);
        // If it's present
        if ($start !== false){
            // Record position and token name
            $resultArray[$i]->start = $start;
            $resultArray[$i]->token = $Tokens[$i];
        }
    }
    
    // Sort in order of position
    sort($resultArray);
    // Go through the result array, getting the token values
    for ($i = 0; $i<count($resultArray); $i++){
        // Get the start point of the value
        $valueStart = $resultArray[$i]->start + strlen($resultArray[$i]->token) + 1;
        // Get the length of the value
        if ($i==(count($resultArray)-1)) {
                $output[$resultArray[$i]->token] = substr($thisString, $valueStart);
        } else {
                $valueLength = $resultArray[$i+1]->start - $resultArray[$i]->start - strlen($resultArray[$i]->token) - 2;
                $output[$resultArray[$i]->token] = substr($thisString, $valueStart, $valueLength);
        }      
    
    }
    
    // Return the ouput array
    return $output;
    }

	function getgift_strPost($order){
		$site_url = SITE_URL;
		$TotalCartAmount = $order['OrderCertificate']['total_amount'];
		$strSuccessUrl = $site_url."checkouts/protx_gift_return";
		$strFailureUrl = $site_url."checkouts/protx_gift_error";
		// Now to build the VSP Form crypt field.  For more details see the VSP Form Protocol 2.22
		//$intRandNum = rand(0,32000)*rand(0,32000);
		// $strVendorTxCode = $this->strVSPVendorName.$intRandNum;
		// $strPost ="VendorTxCode =" .$strVendorTxCode;
		//$strPost ="VendorTxCode=".$order['OrderCertificate']['id'];
                $strPost ="VendorTxCode=".$order['OrderCertificate']['order_number'];
		$strPost=$strPost . "&Amount=" . number_format($TotalCartAmount,2, '.', ''); // Formatted to 2 decimal places with leading digit
		$strPost=$strPost . "&Currency=" . $this->strCurrency;
		$strPost=$strPost . "&Description=Gift Certificate from Choiceful.com";
		/* The SuccessURL is the page to which VSP Form returns the customer if the transaction is successful 
		** You can change this for each transaction, perhaps passing a session ID or state flag if you wish */
		$strPost=$strPost . "&SuccessURL=" .$strSuccessUrl;
		$strPost=$strPost . "&FailureURL=" . $strFailureUrl;
		// The FailureURL is the page to which VSP Form returns the customer if the transaction is unsuccessful
		$strPost=$strPost . "&VendorEMail=" . $this->strVendorEMail;
		$strPost=$strPost . "&eMailMessage=Thank you very much for your order. We will conatct you soon";
		$strPost=$strPost . "&CustomerName=" . $order['OrderCertificate']['billing_firstname']." ".$order['OrderCertificate']['billing_lastname'];
// 		$strPost=$strPost . "&CustomerEMail=" . $order['OrderCertificate']['user_email'] ;
		$strPost=$strPost . "&BillingSurname=" . $order['OrderCertificate']['billing_lastname'];
		$strPost=$strPost . "&BillingFirstnames=" . $order['OrderCertificate']['billing_firstname'];
		$strPost=$strPost . "&BillingAddress1=" . $order['OrderCertificate']['billing_address1'];
		$strPost=$strPost . "&BillingAddress2=" . $order['OrderCertificate']['billing_address2'];
		$strPost=$strPost . "&BillingCity=" 	. $order['OrderCertificate']['billing_city'];
		$country_codes = $this->Common->getCountryCodes();
		$strPost=$strPost . "&BillingCountry=".$country_codes[$order['OrderCertificate']['billing_country_id']];
		//App::import('Model', 'Country');
		//$this->Country = &new Country();
		//$ordercountry_code = $this->Country->find('first',array('Country.id'=>$order['OrderCertificate']['billing_country_id']));
		//$strPost=$strPost . "&BillingCountry=GB";
		
// 		$strPost=$strPost . "&BillingPhone=" 	. $order['OrderCertificate']['billing_phone'];
		$strPost=$strPost . "&BillingPostCode=" . $order['OrderCertificate']['billing_postecode'];
		$strPost=$strPost . "&DeliverySurname=" .   $order['OrderCertificate']['billing_lastname'];
		$strPost=$strPost . "&DeliveryFirstnames=" . $order['OrderCertificate']['billing_firstname'];
		$strPost=$strPost . "&DeliveryAddress1=" . $order['OrderCertificate']['billing_address1'];
		$strPost=$strPost . "&DeliveryAddress2=" . $order['OrderCertificate']['billing_address2'];
		$strPost=$strPost . "&DeliveryCity=" .     $order['OrderCertificate']['billing_city'];
		$strPost=$strPost . "&DeliveryCountry=".$country_codes[$order['OrderCertificate']['billing_country_id']];
		//if($order['shipping_country'] == 'US'){
		//$strPost=$strPost . "&DeliveryState=" .     strtoupper(substr($order['shipping_state'], 0,2)); 
		//}
// 		$strPost=$strPost . "&DeliveryPhone=" . $order['shipping_phone'];
		$strPost=$strPost . "&DeliveryPostcode=" . $order['OrderCertificate']['billing_postecode'];
		############################ $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
		/* Allow fine control over AVS/CV2 checks and rules by changing this value. 0 is Default 
		** It can be changed dynamically, per transaction, if you wish.  See the VSP Server Protocol document */
		if ($this->strTransactionType != "AUTHENTICATE"){
			$strPost=$strPost . "&ApplyAVSCV2=0";
		}
		/* Allow fine control over 3D-Secure checks and rules by changing this value. 0 is Default 
		** It can be changed dynamically, per transaction, if you wish.  See the VSP Server Protocol document */
		$strPost=$strPost . "&Apply3DSecure=0";
		return $strPost;
	}
}
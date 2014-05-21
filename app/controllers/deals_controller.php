<?php
/**
* DealsController class
* PHP versions 5.1.4
* @date Oct 14, 2010
* @Purpose:
* @filesource
* @author   
**/


class DealsController extends AppController {
	var $name = 'Deals';
	var $helpers =  array('Html','Ajax','Fck', 'Form', 'Javascript','Format','Common','Session','Validation','Calendar');
	var $components =  array('RequestHandler','Email','Common','File','Thumb','Zip');
	var $paginate =  array();
	var $uses =  null;
	
        
        function index(){
            $this->layout ="temphome";
            
        }
        function groupbuy(){
             $this->layout ="temphome";
            
        }
        function discountdeals(){
            $this->layout ="temphome";
            
        }
        
}
?>
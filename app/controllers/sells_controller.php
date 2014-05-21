<?php
/**
* SellsController class
* PHP versions 5.1.4
* @date 
* @Purpose:
* @filesource
* @author   
**/


class SellsController extends AppController {
	var $name = 'Sells';
	var $helpers =  array('Html','Ajax','Fck', 'Form', 'Javascript','Format','Common','Session','Validation','Calendar');
	var $components =  array('RequestHandler','Email','Common','File','Thumb','Zip');
	var $paginate =  array();
	var $uses =  null;
	
        
        function selling_opportunities(){
            $this->layout ="temphome";
            
        }
     
        
}
?>
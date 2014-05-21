<?php ?>
<!--Gift Options Start-->
	<?php echo $form->create('Seller',array('action'=>'my_account','method'=>'POST','name'=>'frmSeller3','id'=>'frmSeller3'));?>
		<h2 class="font14">Gift Options 
			<a href="#" class="blkgradbtn">
				<?php $options3=array(
				"url"=>"/sellers/save_giftoptions","before"=>"",
				"update"=>"gift-options",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"btn_blk-bg-link",
				"type"=>"Submit",
				"id"=>"giftoptid",
				"div"=>false
				);?><?php echo $ajax->submit('Change',$options3);?>
			</a>
		</h2>
		<ul class="change">
		<?php
		if ($session->check('Message.flash')){ ?>
			<li><div class="messageBlock"><?php echo $session->flash();?></li></div>
		<?php }	?>
			<li>You can offer customers the option to gift-wrap and provide a message for products within an order.
			</li> 
		<li>
			<?php
				$options_gift=array('0'=>'<span class="wdth100"><strong>Disabled</strong></span><span class="wdth100">','1'=>' <strong>Enabled</strong></span>');
				$attributes_gift=array('legend'=>false,'label'=>false,'class'=>'adio v-align-middle');
				echo $form->radio('Seller.gift_service',$options_gift,$attributes_gift);
			?>
			<!--<span class="wdth100"><input type="radio" name="radio" value="radio" /> 
			<strong>Enabled</strong></span> 
			<span class="wdth100"><input type="radio" name="radio" value="radio" /> 
			<strong>Disabled</strong></span>-->
		</li>
		</ul>
	<?php echo $form->end();?>
<!--Gift Options Closed-->
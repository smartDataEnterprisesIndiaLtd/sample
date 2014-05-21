<?php 
if(!empty($permissions)) {
	foreach($permissions as $permission_id=>$permission){
		if(!empty($alluserpermissions)){
			foreach($alluserpermissions as $user_permission){
				if($user_permission['AdminuserPermission']['permission_id'] == $permission_id){
					$checked[] = $permission_id;
				} else{
					
				}
			}
		}
	}
}
?>

<?php 
	echo $form->create('Adminuser',array('action'=>'access/','method'=>'POST','onsubmit' => ''));
?>

<table cellspacing="5" cellpadding="2" border="0" width=80%  align="center">
<?php 
if(!empty($permissions)) {
	foreach($permissions as $permission_id=>$permission){
		?>
		<tr>
			<td align="right" width="30%"><?php echo ucwords($permission);?></td>
			<td align="center" width="20">:</td>
			<td align="left"><?php if(!empty($checked)){
				if(in_array($permission_id,$checked)){
					$checkbox =true;
				} else{ $checkbox =false;}
			} else{
				$checkbox = false;
			}
			echo $form->checkbox("AdminuserPermissions.permission_id".$permission_id,array("id"=>"AdminuserPermission_".$permission_id,"class"=>"string login-input","checked"=>$checkbox,"label"=>false,'value'=>$permission_id,"div"=>false)); ?>
			</td>
		</tr>
		<?php 
	}
}
?>

<tr>
	<td>&nbsp;</td>
	<td colspan="2" align="left" height="40"><?php echo $form->submit('Save',array('class'=>"btn_53",'div'=>false))."&nbsp;&nbsp;&nbsp;";
	echo $form->button('Back', array('type'=>'button','class'=>"btn_53",'onclick'=>"goBack('/admin/adminusers/index')"));
	?></td>
</tr>
</table>
<?php
echo $form->hidden("Adminuser.adminuser_id",array('type'=>'textbox','value'=>$user_id));
echo $form->end();
?>
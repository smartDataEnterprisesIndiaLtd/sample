<?php ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
    <tr>
	<td valign="top">		
	    <table align="center" width="98%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
		    <td>
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
			    <tr class="adminBoxHeading reportListingHeading">
				<td height="25" align="left" class="heading">User Details</td>
				<td height="25" align="right"><?php echo $html->link("Update Account",array("controller"=>"adminusers","action"=>"updateprofile")); ?></td>
			    </tr>
        		    <tr>
				<td colspan="2">
				    <table width="100%" border="0" cellspacing="1" cellpadding="3" class="adminBox">
					<tr>
						<td style="vertical-align:top;padding-top:10px">
						<?php if(isset($this->data['Adminuser']) && count($this->data['Adminuser']) >0 ) { ?>
							<table>
								<tr>
									<td>Username :</td><td>    <?php echo $this->data['Adminuser']['username'];   ?></td>
								</tr>
								<tr>
									<td>Name :</td><td>    <?php echo ucfirst($this->data['Adminuser']['firstname'])." ".ucfirst($this->data['Adminuser']['lastname']);   ?></td>
								</tr>
								<tr>
									<td>Email :</td><td>   <?php echo $this->data['Adminuser']['email'];   ?></td>
								</tr>
							</table>
							<?php } ?>
						</td>
					</tr>
				    </table>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</td>
    </tr>
</table>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $title_for_layout;?></td>
		<td class="adminGridHeading" height="25px" align="right">
			&nbsp; &nbsp;
		</td>
	</tr>
	<tr><td heigth="6" colspan="2"> &nbsp; &nbsp;</td></tr>
 	<tr>
		<td colspan="2" valign="top" id="pagging">
				
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td  id='listing'>
						<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
						<?php if(!empty($disCountries)){
						?>
						<tr>
							<td class="adminGridHeading" align="left" width="">Country Name</td>
							<td class="adminGridHeading" align="center" width="">Country Id</td>
						</tr>
						<?php
						//pr($volumeArr);
						$class= 'rowClassEven';
						foreach ($disCountries as $countries) {
							$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
							?>
							<tr class="<?php echo $class?>">
								<td align="left" >
									<?php
										echo $countries['DispatchCountry']['name'];
									?>
								</td>
								<td align="center">
									<?php
										echo $countries['DispatchCountry']['id'];
									?>
								</td>
								
							</tr>
							<?php
						} }
						?>
						<tr><td heigth="6" colspan="2"></td></tr>
						</table>
							
					</td>
							
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td>		
	</tr>

</table>

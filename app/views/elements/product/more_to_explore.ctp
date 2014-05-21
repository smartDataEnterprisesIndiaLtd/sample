<?php 
if(!empty($moreToExploreArr)){
?>
<div class="row no-pad-btm">
	<!--FBTogether Start-->
	<div class="fbtogether">
		<h4 class="mid-gr-head blue-color"><span>More to Explore</span></h4>
		<div class="tec-details">
			<ul class="more-links">
				<?php
				foreach($moreToExploreArr as $breadcrums){
					if(!empty($breadcrums)){
					?>
					<li><?php
						$i = 1;
						if(!empty($breadcrums['Dept'])){
							$dept_url=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($breadcrums['Dept']['Department']['name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($breadcrums['Dept']['Department']['name'],"/".$dept_url."/departments/index/".$breadcrums['Dept']['Department']['id'],array('escape'=>false,'class'=>'')); echo ' &gt; ';
						}
						if(!empty($breadcrums['Parents_arr'])) {
							foreach($breadcrums['Parents_arr'] as $breadcrum){
								if($i != count($breadcrums['Parents_arr'])){
								$dept_cat_url=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($breadcrum['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
									echo $html->link($breadcrum['Category']['cat_name'],"/".$dept_url."/".$dept_cat_url."/categories/index/".$breadcrum['Category']['id']."/".$breadcrums['Dept']['Department']['id'],array('escape'=>false,'class'=>'')); echo ' &gt; ';
								} else {
								$dept_cat_url=str_replace(array(' ','/','&quot;','&'), array('-','','"','and'), html_entity_decode($breadcrum['Category']['cat_name'], ENT_NOQUOTES, 'UTF-8'));
									echo $html->link($breadcrum['Category']['cat_name'],"/".$dept_url."/".$dept_cat_url."/categories/viewproducts/".$breadcrum['Category']['id']."/".$breadcrums['Dept']['Department']['id'],array('escape'=>false,'class'=>''));
								}?>
							<?php $i++; }
						}?></li>
					<?php }
				}
				?>
			</ul>
		</div>
	</div>
	<!--FBTogether Closed-->
</div>
<?php }?>
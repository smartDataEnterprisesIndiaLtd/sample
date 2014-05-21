
<?php
 $model_name = $this->params['models'][0] ;
 if($this->params['action'] == 'admin_footerdes'){
  $model_name = $this->params['models'][1] ;
 }
  if($this->params['action'] == 'admin_index' && $this->params['controller'] == 'orders' ){
$keyword = isset($this->data['Search']['keyword'])?$this->data['Search']['keyword']:'';
$searchin = isset($this->data['Search']['searchin'])?$this->data['Search']['searchin']:'';
$start_date = isset($this->data['Search']['start_date'])?$this->data['Search']['start_date']:'';
$end_date = isset($this->data['Search']['end_date'])?$this->data['Search']['end_date']:'';

 }

?>
<table width="100%" cellpadding="2" cellspacing="2" border="0" style="background-color:#DFDFDF;"  >
<tr>
	<td align="left" width="40%"  height="0">
<?php
	//echo $target_page_url = SITE_URL.ltrim($_SERVER['REQUEST_URI'], "/");
	$target_page_url = "/".ltrim($_SERVER['REQUEST_URI'], "/");
	//echo $form->create($model_name,array("action"=>"index","method"=>"post", "id"=>"frmRecordsPages", "name"=>"frmRecordsPages"));
	?>
	<form name="frmRecordsPages" action="<?php echo $target_page_url; ?>" method="post" >
	<?php if($this->params['action'] == 'admin_index' && $this->params['controller'] == 'orders' ){
	echo $form->hidden('Search.searchin',array('size'=>'30','class'=>'textbox','label'=>'','value'=>@$searchin,'div'=>false,'maxlength'=>'50'));?><?php

echo $form->hidden('Search.start_date',array('size'=>'30','class'=>'textbox','label'=>'','value'=>@$start_date,'div'=>false,'maxlength'=>'50'));
echo $form->hidden('Search.end_date',array('size'=>'30','class'=>'textbox','label'=>'','value'=>@$end_date,'div'=>false,'maxlength'=>'50'));}
echo $form->hidden('Search.keyword',array('size'=>'30','class'=>'textbox','label'=>'','value'=>@$keyword,'div'=>false,'maxlength'=>'50'));


	echo 'Show &nbsp;';
	echo $form->select('Record.limit',array('25'=>'25','50'=>'50','100'=>'100','200'=>'200'),null,array('type'=>'select','onChange'=>'this.form.submit()', 'class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'size'=>1));
	if(!empty($pass_url))
		echo $form->hidden('Record.pass_url_value',array('value'=>base64_encode(@$pass_url)));
	echo '&nbsp; Records Per Page &nbsp;';
	echo $form->end();
?> 
	</td>
	<td align="right"><b></b>
<?php
      // $paginator->options(array('url' => 'abc'));
	echo $paginator->first('First', array('class'=>"homeLink"));echo '&nbsp;&nbsp;';
	echo $paginator->prev('Previous',array('class'=>"homeLink"));  echo '&nbsp;&nbsp;';
	echo $paginator->numbers(); echo '&nbsp;&nbsp;';
	echo $paginator->next('Next',array('class'=>"homeLink")); echo '&nbsp;';
	
			
	echo $paginator->last('Last',array('class'=>"homeLink"));
	//echo $paginator->numbers(array(	'format' => 'Page %page% of %pages% ' ));
?> 
	&nbsp;
	</td>
</tr>
</table>
<script>
	jQuery(".breadcrumb_frame ul li:last-child").addClass("last");
</script>
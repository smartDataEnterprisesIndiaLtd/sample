<?php $url = SITE_URL."orders/purchaseorder_slip/".$val['Order']['id'];
$win_height = 500;
$win_width = 850;
echo $html->image("mobile/print_icon.png",array('width'=>'24' , 'height'=>'24' , 'alt'=>""));

echo $html->link('Print Order Summary','javascript:void(0);',array('class'=>'underline-none-link','escape'=>false,'onClick'=>"open_window('$url',$win_height,$win_width);"));?> 
<script defer="defer" type="text/javascript">
	function open_window(url,win_height,win_width){
		window.open(url,"PrintOrderSummary","scrollbars=yes,menubar=NO,width="+win_width+",height="+win_height+",screenX=50,left=80,screenY=50,top=100");
	}
</script>
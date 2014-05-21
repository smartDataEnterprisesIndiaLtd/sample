<?php $url = SITE_URL."sellers/packing_slip/".$order_details['Order']['id'];
$win_height = 500;
$win_width = 850;
echo $html->link('Print Order Packing Slip','javascript:void(0);',array('escape'=>false,'onClick'=>"open_window('$url',$win_height,$win_width);"));
//echo $html->link('Print Order Packing Slip','javascript:void(0);',array('escape'=>false,'onClick'=>"window.open('".$url."','Payment Slip','scrollbars=yes,menubar=no,width=".$win_width.",height=".$win_height.",screenX=50,left=80,screenY=50,top=100');"));?> 
<!--<a href='#' onClick='window.open("<?php //echo $url; ?>","PaymentSlip","scrollbars=yes,menubar=no,width=<?php //echo $win_width?>,height=<?php //echo $win_height;?>,screenX=50,left=80,screenY=50,top=100");'>Print Order Packing Slip</a>-->


<script type="text/javascript">
	function open_window(url,win_height,win_width){
		window.open(url,"PaymentSlip","scrollbars=yes,menubar=NO,width="+win_width+",height="+win_height+",screenX=50,left=80,screenY=50,top=100");
	}
</script>
<?php 
class FckHelper extends Helper
{
	
    function load($id, $toolbar = 'Basic') {
        foreach (explode('/', $id) as $v) {
             @$did .= ucfirst($v);
        }
        return <<<FCK_CODE
<script type="text/javascript">
fckLoader_$did = function () {
    var bFCKeditor_$did = new FCKeditor('$did');
    bFCKeditor_$did.BasePath = '/js/';
    bFCKeditor_$did.ToolbarSet = '$toolbar';
	    bFCKeditor_$did.Skin         = 'silver';
		bFCKeditor_$did.Height   = '400';  
		//bFCKeditor_$did.Height = '300';
		bFCKeditor_$did.Width    = '100%';

    bFCKeditor_$did.ReplaceTextarea();
}
fckLoader_$did();
</script>
FCK_CODE;
    }
}
?>
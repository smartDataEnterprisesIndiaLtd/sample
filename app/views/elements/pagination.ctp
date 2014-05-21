<div id='pagination'>
<?php
    $leftArrow = '<<';
    $rightArrow = '>>';
    $prev = $pagination->prevPage($leftArrow,false);
    $prev = $prev?$prev:$leftArrow;
    $next = $pagination->nextPage($rightArrow,false);
    $pages = $pagination->pageNumbers(" | ");
    echo("<table width='100%'><tr>");
    echo "<td width='25%' align='left' class='pagging'>".$pagination->result()."&nbsp;&nbsp;&nbsp</td>";
    if(isset($pagination->_pageDetails['pageCount']) && $pagination->_pageDetails['pageCount']!='1'){
        echo "<td width='45%' align='left' class='pagging'>".$prev." ".$pages." ".$next."&nbsp;</td>";
        }
    echo "<td width='30%' align='right' class='pagging'>&nbsp;&nbsp;&nbsp;Show Per Page".$pagination->resultsPerPage(NULL, ' ')."&nbsp;</td>";
    echo("</tr></table>");
?>
</div>


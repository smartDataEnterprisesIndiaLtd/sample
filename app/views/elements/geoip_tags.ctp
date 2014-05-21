<?php
$site_domain = $_SERVER['HTTP_HOST'];
$reuested_url =  $_SERVER['REQUEST_URI'];
$site_url = "http://".$site_domain.$reuested_url;
        if($_SERVER['HTTP_HOST'] == 'us.choiceful.com'){
            $hreflang = "en-us";
        }else if($_SERVER['HTTP_HOST'] == 'uk.choiceful.com'){
            $hreflangd = "en-gb";
        }else{
            $hreflang = "x-default";
        }
echo "<link rel='alternate' href=".$site_url." hreflang=".$hreflang." />";


?>
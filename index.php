<!-- index.php
//
// MAINTENANCE HISTORY
// DATE         PROGRAMMER AND DETAILS
// 07-12-15     Rahul Sharma    	Original
//
//-------------------------------------------------------------------------------------
-->

<?php

require_once 'includes/classUtil.php'; //  Util class for db and shortcode generation

$classUtil = new classUtil();

echo 'Encode and Decode test for value 1001<br/>';
$str = $classUtil->encode(1001);
echo "Encoded:". $str;
echo '<br/>';
echo "Decoded:". $classUtil->decode($str);
	
?>
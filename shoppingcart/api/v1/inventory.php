<?php
	$products=array(array('id'=>1,'product_name'=>'pen','product_price'=>10),array('id'=>2,'product_name'=>'notebook','product_price'=>20));
	file_put_contents("json_products.json",json_encode($products));
?>

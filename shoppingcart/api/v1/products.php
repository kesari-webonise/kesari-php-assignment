<?php
$list_products=json_decode(file_get_contents("json_products.json"));
$products=array();

foreach ($list_products as $product) {
	$products[]=(array)$product;
}

$method=$_SERVER['REQUEST_METHOD'];
processRequest($method);

	function processRequest($method) {
		global $products;

		if($method=='GET') {
			echo json_encode($products);
		}

		elseif($method=='POST') {
			$products[]=array('id'=>end($products)['id']+1,'product_name'=>$_POST["product_name"],'product_price'=>$_POST["product_price"]);
		}
		elseif($method=='PUT') {
			$product_id=basename($_SERVER['REQUEST_URI']);
			parse_str(file_get_contents("php://input"),$post_vars);

			foreach ($products as $key => $value) {
				if($products[$key]['id']==$product_id){
					$products[$key]['product_name']=$post_vars["product_name"];
					$products[$key]['product_price']=$post_vars["product_price"];
				}
			}
		}
		elseif($method=='DELETE') {
			$product_id=basename($_SERVER['REQUEST_URI']);
			foreach ($products as $key => $value) {
				if($products[$key]['id']==$product_id){
					unset($products[$key]);
				}
			}
		}
		else{
			echo "Unknown method";
		}
		file_put_contents("json_products.json",json_encode($products));
	}
?>

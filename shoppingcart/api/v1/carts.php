<?php
$list_items=json_decode(file_get_contents("json_carts.json"));
$items=array();

foreach ($list_items as $item) {
	$items[]=(array)$item;
}

$method=$_SERVER['REQUEST_METHOD'];
processRequest($method);

	function processRequest($method) {
		global $items;

		if($method=='GET') {
			$total=0;
			$item_id=basename($_SERVER['REQUEST_URI']);
			if($item_id=="carts.php"){
				echo json_encode($items).PHP_EOL;
				foreach ($items as $key => $value) {
					$total+=$items[$key]['item_price'];
				}
				echo "Cart Total=".$total.PHP_EOL;
			}
			else{
				foreach ($items as $key => $value) {
					if($items[$key]['id']==$item_id){
						echo "Item name =".$items[$key]['item_name'].PHP_EOL;
						echo "Item price =".$items[$key]['item_price'].PHP_EOL;
					}
				}
			}
		}

		elseif($method=='POST') {
			if(!empty($items)){
				$items[]=array('id'=>end($items)['id']+1,'item_name'=>$_POST["item_name"],'item_price'=>$_POST["item_price"]);
			}
			else{
				$items[]=array('id'=>1,'item_name'=>$_POST["item_name"],'item_price'=>$_POST["item_price"]);
			}
		}
		elseif($method=='PUT') {
			$item_id=basename($_SERVER['REQUEST_URI']);
			parse_str(file_get_contents("php://input"),$post_vars);

			foreach ($items as $key => $value) {
				if($items[$key]['id']==$item_id){
					$items[$key]['item_name']=$post_vars["item_name"];
					$items[$key]['item_price']=$post_vars["item_price"];
				}
			}
		}
		elseif($method=='DELETE') {
			$item_id=basename($_SERVER['REQUEST_URI']);
			foreach ($items as $key => $value) {
				if($items[$key]['id']==$item_id){
					unset($items[$key]);
				}
			}
		}
		else{
			echo "Unknown method";
		}
		file_put_contents("json_carts.json",json_encode($items));
	}
?>

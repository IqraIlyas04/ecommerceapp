 <?php
include_once('db_connect.php');
include_once('db_handler.php');
include_once('utility.php');

$db = new DB_CONNECT();
$conn = $db->connect();

$db_handler = new DB_HANDLER($conn);
$utility_handler = new UTILITY();

if($_POST['action'] == "insert_product")
{
	extract($_POST);

	$res=$db_handler->add_product_in_cart($product_id);

	if($res)
	{
		echo "Submitted";
	}
	else
	{
		echo "Error";
	}
exit;
}

?>
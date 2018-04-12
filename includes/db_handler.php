 <?php
class DB_HANDLER
{
	private $conn;
	
	function __construct($conn)
	{
		$this->conn = $conn;
	}
	
	// get all products
	public function get_all_prods()
	{
		return $this->get_cust_cols("SELECT * from products");
	}

	//get products based on user id
	public function get_prod_userid($user_id)
	{
		$query="SELECT products.* from products left join cart ON products.product_id=cart.product_id where cart.user_id=?";
		$params=array("i", $user_id);
		$result= $this->preparedStatement($this->conn, "get", $query, $params);
		return $result;
	}

	// add button for cart
	public function add_user_prod($product_id, $user_id)
	{
		$query="INSERT INTO cart (product_id, user_id) VALUES (?,?)";
		$params=array("ii", $product_id, $user_id);
		$result= $this->preparedStatement($this->conn, "add", $query, $params);
		return $result;
	}
	
	//remove button for cart
	public function del_user_prod($product_id, $user_id)
	{
		$query="DELETE FROM cart where product_id=? and user_id=?";
		$params=array("ii", $product_id, $user_id);
		$result= $this->preparedStatement($this->conn, "delete", $query, $params);
	}

	public function check_user_exists($username)
	{
		$query = "SELECT username FROM users where username = ?";
		$params= array("s", $username);
		$result= $this->preparedStatement($this->conn, "check", $query, $params);
		return $result;
	}

	public function validate_user($username, $password)
	{
		$query = "SELECT * from users where username=? and password=?";
		$params= array("ss", $username, $password);
		$result= $this->preparedStatement($this->conn, "check", $query, $params);
		return $result;
	}

	public function get_user($username, $password)
	{
		$query= "SELECT * from users where username=? and password=?";
		$params=array("ss", $username, $password);
		$result= $this->preparedStatement($this->conn, "get", $query, $params);
		return $result;
	}

	public function add_user($username, $password)
	{
		$query= "INSERT INTO users(username, password)values(?,?)";
		$params = array('ss', $username, $password);
		$result= $this->preparedStatement($this->conn, "add", $query, $params);
		return $result;
	}

	// Existing functions
	function refValues($arr){
	    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
	    {
	        $refs = array();
	        foreach($arr as $key => $value)
	            $refs[$key] = &$arr[$key];
	        return $refs;
	    }
	    return $arr;
	}



	//Dynamic prepared statement function to do all add and edit operations
	function preparedStatement($conn, $type, $stmt, $params)
	{

		if($type == "add")
		{
			$stmt = $conn->prepare($stmt);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
			$result = $stmt->execute();
			$stmt->close();
			return $result;
		}

		if($type == "check")
		{
			$stmt = $conn->prepare($stmt);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
			$stmt->execute();
			$stmt->store_result();
			$num_rows = $stmt->num_rows;
			$stmt->close();
			return $num_rows > 0;
		}

		if($type == "edit")
		{
			$stmt = $conn->prepare($stmt);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
			$stmt->execute();
			$num_affected_rows = $stmt->affected_rows;
			$stmt->close();
			return $num_affected_rows > 0;
		}

		if($type == "delete")
		{
			$stmt = $conn->prepare($stmt);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
			$stmt->execute();
			$num_affected_rows = $stmt->affected_rows;
			$stmt->close();
			return $num_affected_rows > 0;
		}

		if($type == "get")
		{
			include_once('utility.php');
			$utility_handler = new UTILITY();

			$stmt = $conn->prepare($stmt);
			call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));

			if($stmt->execute())
			{
				$arr = array();
				$row = $utility_handler->bind_result_array($stmt);

				if(!$stmt->error)
				{
					$counter = 0;
					while($stmt->fetch())
					{
						$arr[$counter] = $utility_handler->getCopy($row);
						$counter++;
					}
				}
				$stmt->close();
				return $arr;
			}
			else
			{
				return NULL;
			}
		}
	}

	//Get Custom columns
	function get_cust_cols($query)
	{
		include_once('utility.php');
		$utility_handler = new UTILITY();

		$arr = array();
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$row = $utility_handler->bind_result_array($stmt);

		if(!$stmt->error)
		{
			$counter = 0;
			while($stmt->fetch())
			{
				$arr[$counter] = $utility_handler->getCopy($row);
				$counter++;
			}
		}
		$stmt->close();
		return $arr;
	}

}
?>
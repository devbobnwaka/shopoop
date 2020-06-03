<?php 
	
	class Database {
		//specify your own database credentials
		private $host;
		private $db_name;
		private $username;
		private $password;
		public $conn;

		public function __construct($host,$username,$password,$db_name){
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->db_name = $db_name;
			$this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->db_name) or die(mysqli_connect_error());
		}
		//get the database connection
		public function getConnection(){
			return $this->conn;
		}
	}

	class Product{
		//database connection and table name
		private $conn;
		private $table_name;
		private $upload_date;

		public function __construct($db,$table,$upload_date){
			$this->conn = $db;
			$this->table_name = $table;
			$this->upload_date = $upload_date;
		}

		public function fetchAll($offset,$display){
			$query = "SELECT * FROM $this->table_name ORDER BY $this->upload_date DESC LIMIT $offset, $display";
			$result = mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
			return $result;
		}

		public function merchantPro($id,$offset,$display){
			$query = "SELECT * FROM $this->table_name WHERE merchant_id = '$id' ORDER BY $this->upload_date DESC 
			LIMIT $offset, $display";
			$result = mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
			return $result;


		}

		public function productDetails($id){
			$query = "SELECT * FROM $this->table_name WHERE product_id = '$id' ";
			$result = mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
			return $result;
		}

		public function productUpdate($col,$name,$product_id){
			$query = "UPDATE $this->table_name SET $col = '$name' WHERE product_id = '$product_id' " ;
			$result = mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
			return $result;
		}

		public function insertProduct($name,$desc,$price,$cat,$merchant_id,$destination){
			$query = "INSERT INTO $this->table_name
										VALUES(NULL,
											  '$name',
											  '$desc',
											  '$price',
											  NOW(),
											  '$cat',
											  '$merchant_id',
											  '$destination' )";
			$result = mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
			return $result;
		}

	}

	class FormValidator{

		private $input;
		private $error;

		public function __construct($input,$error){
			$this->input = $input;
			$this->error = $error;
			
		}

		public function validateString(){
			$input = ($this->input) ? filter_var($this->input, FILTER_SANITIZE_STRING) : NULL;
			return $input;
		}

		public function validateNumber(){
			//filter_var($var, FILTER_VALIDATE_INT, array('min_range' => 1,  'max_range' => 120)) 
			$input = ($this->input) ? filter_var($this->input, FILTER_VALIDATE_INT) : NULL;
			return $input;
		}

		public function validateEmail(){
			//filter_var($var, FILTER_VALIDATE_INT, array('min_range' => 1,  'max_range' => 120)) 
			$input = ($this->input) ? filter_var($this->input, FILTER_VALIDATE_EMAIL) : NULL;
			return $input;
		}

		public function validateImageName(){
			$input = ($this->input) ? $this->input['name'] : NULL;
			return $input;
		}

		public function validateImageSize(){
			$max_size = 4000000;
			$input = ($this->input) ? $this->input['size'] > $max_size : NULL;
			return $input;
		}

		public function validateImageType(){
			$extension = array("image/jpg", "image/jpeg","image/png");
			$input = ($this->input) ? in_array($this->input['type'], $extension) : NULL;
			return $input;
		}

		public function error($input){
			if($input == NULL)	return $this->error;
		} 


	}

	class Auth{
		private $conn;
		private $table;
		
		public function __construct($db,$table){
			$this->conn = $db;
			$this->table = $table;
		}

		public function login($username,$password): bool{
			$pword = md5($password);
			$query = "SELECT * FROM merchant WHERE username = '$username' AND secured_password = '$pword' ";
			$result = mysqli_query($this->conn,$query) or die(mysqli_error($this->conn));

			if(!mysqli_num_rows($result) == 1){
				return false;
			}

			$this->storeInSession($result);

			return true;
		}

		private function storeInSession($result){
			$res = mysqli_fetch_array($result) or die(mysqli_error($this->conn));
			$_SESSION['merchant'] = ['id' => $res['merchant_id'], 
												  'name' => $res['name'],
												  'phone_number' => $res['phone_number'],
												  'email' => $res['email'],
												  'username' => $res['username'],
												  'address' => $res['address'],
												  'date_registered' => $res['date_registered']
												];
		}

		public function logout($redirect){
			session_start();
			session_unset();

			header("location:$redirect");
		}

		public function check($ses_name,$redirect){
			if(empty($ses_name)){
				header("location:$redirect");
			}
		}
		public function signUp(){

		}


	}

 ?>
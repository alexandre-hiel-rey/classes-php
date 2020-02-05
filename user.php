<?php session_start();
$db = mysqli_connect("localhost","root","","users");
    class user
    {
        private $id = "";
        public $login = "";
        public $password = "";
        public $email = "";
        public $firstname = "";
        public $lastname = "";

        public function register($login, $password, $email, $firstname, $lastname)
        {
	    $reqtab="SELECT *FROM users WHERE login='$login'";
        $querytab=mysqli_query($db, $reqtab);
        $num=mysqli_num_rows($querytab);

		if($num == 0)
		{ 
			$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);	
			$requser="INSERT INTO users VALUES(NULL, '$login', '$hash', '$email','$firstname','$lastname')";
			$queryuser=mysqli_query($db, $requser);
			return array($login, $password, $email, $firstname, $lastname);
		}
		else
		{
			return "login déjà existant";
		}
        }

        public function connect($login,$password)
        {
            $query="SELECT * from users WHERE login='$login'";
            $result= mysqli_query($db, $query);
            $row = mysqli_fetch_array($result);
		
		if(password_verify($password,$row['password'])) 
		{
			
			session_start();
			$_SESSION['login']=$login;
			$_SESSION['password']=$password;
			return $_SESSION['login']. " vous êtes bien connecté";

		}
		else
		{
			return "Login ou mot de passe incorrect";	
		}

        }

        public function disconnect()
        {
            session_destroy();
        }

        public function delete()
        {
            $delete = mysqli_query($db,"DELETE * FROM utilisateurs Where login = '$login'");
            session_destroy();
        }

        public function update($login, $email, $firstname, $lastname)
        {
            $update = mysqli_query($db, "UPDATE utilisateurs SET login = '$login', email = '$email', firstname = '$firstname', lastname = '$lastname' Where id = '$id'");
        }

        public function isConnected()
        {

        }

        public function getAllInfos()
        {
            return($this->$login);
            return($this->$email);
            return($this->$firstname);
            return($this->$lastname);
        }

        public function getLogin()
        {
            return($this->$login);
        }

        public function getEmail()
        {
            return($this->$email);
        }

        public function getFirstname()
        {
            return($this->$firstname);
        }

        public function getLastname()
        {
            return($this->$lastname);
        }

        public function refresh()
        {

        }        
    }

?>
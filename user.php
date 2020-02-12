<?php session_start();

    class user
    {
        private $id = "";
        public $login = "";
        public $email = "";
        public $firstname = "";
        public $lastname = "";

        public function register($login, $password, $email, $firstname, $lastname)
        {
            $db = mysqli_connect("localhost","root","","users");
            $reqtab="SELECT *FROM utilisateurs WHERE login='$login'";
            $querytab=mysqli_query($db, $reqtab);
            $num=mysqli_num_rows($querytab);

            if($num == 0)
            { 
                $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);	
                $requser="INSERT INTO utilisateurs VALUES(NULL, '$login', '$hash', '$email','$firstname','$lastname')";
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
            $db = mysqli_connect("localhost","root","","users");
            $query="SELECT * from utilisateurs WHERE login='$login'";
            $result= mysqli_query($db, $query);
            $row = mysqli_fetch_array($result);
		
		if(password_verify($password,$row['password'])) 
		{
            $this->id = $row['id'];
			$this->login = $login;
			$this->email = $row['email'];
			$this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            
			$_SESSION['login']=$login;
			$_SESSION['password']=$password;
			return $_SESSION['login']. " vous êtes bien connecté <br>";

		}
		else
		{
			return "Login ou mot de passe incorrect";	
		}

        }

        public function disconnect()
        {
            session_destroy();
            return("Vous êtes bien déconnecté !");
        }

        public function delete($login)
        {
            $db = mysqli_connect("localhost","root","","users");
            $query = "DELETE * FROM utilisateurs Where login = '$login'";
            $delete = mysqli_query($db,$query);
            session_destroy();
            return "Données supprimés";
        }

        public function update($login, $email, $firstname, $lastname)
        {
            if(isset($_SESSION['login']))
                {
                    $db = mysqli_connect("localhost", "root", "", "users");
                    $log = $_SESSION['login'];
                    $update="UPDATE utilisateurs SET login='$login',email='$email', firstname='$firstname', lastname='$lastname' WHERE login='$log'";
                    mysqli_query($db, $update);
                    return "Données changés";
                }
        }

        public function isConnected()
        {
            $bool = FALSE;
            if(isset($_SESSION['login']))
            {
                return $bool= TRUE;
                return "Vous êtes bien connecté";
            }  
            else
            {
                return "Vous n'êtes pas connecté";
            }
        }

        public function getAllInfos()
        {
            if(isset($_SESSION['login']))
            {
                return($this->login);
            }
            else
            {

            return "Pas de connection en cours";
            }
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
            $db = mysqli_connect("localhost", "root", "", "users");
            $login = $_SESSION['login'];
            $queryuser = "SELECT * from utilisateurs WHERE login='$login'";
            $resultuser = mysqli_query($db, $queryuser);
            $tab = mysqli_fetch_array($resultuser);

            $this->id = $tab['id'];
            $this->login = $tab['login'];
            $this->email = $tab['email'];
            $this->firstname = $tab['firstname'];
            $this->lastname = $tab['lastname'];

        }        
    }

    $user = new user;

     $user->register('Ztery','test','bla','dzd', 'dzdd');

    echo $user->connect('Ztery', 'test');

    // echo $user->disconnect();

    // echo $user->delete();

    echo $user->update('Ztery','dédé','dz', 'dzdz');

    // echo $user->isConnected();

    $info=$user->getAllInfos();
    var_dump($info);

    // echo $user->getLogin();

    // echo $user->getEmail();

    // echo $user->getFirstname();

    // echo $user->getLastname();

    echo $user->refresh();
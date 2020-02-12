<?php   

    class userpdo
    {
        private $id = "";
        public $login = "";
        public $email = "";
        public $firstname = "";
        public $lastname = "";

        public function register($login, $password, $email, $firstname, $lastname)
        {
            $db = new PDO('mysql:host=localhost;dbname=users', "root", "");
            $query = $db->query("SELECT *FROM utilisateurs WHERE login='$login'");
            $row = $query->rowCount();

            if($row == 0)
            {
                $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $regquery = $db->query("INSERT INTO utilisateurs VALUES(NULL, '$login', '$hash', '$email','$firstname','$lastname')");
                return array($login, $password, $email, $firstname, $lastname);
            }

            else
            {
                return "Login déjà existant";
            }
        }

        public function connect($login,$password)
        {
            $db = new PDO('mysql:host=localhost;dbname=users', "root", "");
            $query = $db->query("SELECT * from utilisateurs WHERE login='$login'");
            $result = $query->fecth();

            if(password_verify($password,$result['password']))
            {
                $this->id = $result['id'];
                $this->login = $login;
                $this->email = $result['email'];
                $this->firstname = $result['firstname'];
                $this->lastname = $result['lastname'];

                $_SESSION['login']=$login;
                $_SESSION['password']=$password;
                return $_SESSION['login']. " vous êtes bien connecté <br>";
    
            }
            else
                return "Login ou mot de passe incorrect";	

        }

        public function disconnect()
        {
            session_destroy();
            return("Vous êtes bien déconnecté !");
        }

        public function delete()
        {
            $db = new PDO('mysql:host=localhost;dbname=users', "root", "");
            $query = $db->query("DELETE * FROM utilisateurs Where login = '$login'");
            session_destroy();
            return 'Données supprimés';
        }

        public function update($login,$email,$firstname,$lastname)
        {
            if(isset($_SESSION['login']))
                {
                    $db = new PDO('mysql:host=localhost;dbname=users', "root", "");
                    $log = $_SESSION['login'];
                    $query = $db->query("UPDATE utilisateurs SET login='$login',email='$email', firstname='$firstname', lastname='$lastname' WHERE login='$log'");
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
            $db = new PDO('mysql:host=localhost;dbname=users', "root", "");
            $login = $_SESSION['login'];
            $queryuser = $db->query("SELECT * from utilisateurs WHERE login='$login'");
            $tab = $queryuser->fecth();

            $this->id = $tab['id'];
            $this->login = $tab['login'];
            $this->email = $tab['email'];
            $this->firstname = $tab['firstname'];
            $this->lastname = $tab['lastname'];

        }
    }

    $user = new userpdo;

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
?>
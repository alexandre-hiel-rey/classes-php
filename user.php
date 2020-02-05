<?php
$db = mysqli_connect("localhost","root","","users");
    class user
    {
        private $id = "";
        public $login = "kiki";
        public $email = "zeofijz";
        public $firstname = "ozrin";
        public $lastname = "oizefje";

        public function register($login, $email, $firstname, $lastname)
        {
            $query = mysqli_query($db,"INSERT INTO utilisateurs(login,email,firstname,lastname) VALUES('$login','$email','$firstname','$lastname')");
            $result = mysqli_fetch_all($query);

            return($this->$login = $result[0][1]);
            return($this->$email = $result[0][2]);
            return($this->$firstname = $result[0][3]);
            return($this->$lastname = $result[0][4]);

        }

        public function connect($login,$password)
        {
            $requete = mysqli_query($db, "SELECT login,password FROM utilisateurs");
            $resultat = mysqli_fecth_all($requete);

            return($this->$login = $resultat[0][1]);
            return($this->$password = $resultat[0][2]);
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
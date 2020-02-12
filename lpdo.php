<?php
    class lpdo
        {
            private $connexion = null;
            private $lastQuery = null;
            private $lastResult = null;
            
            function constructeur($host="", $username="", $password="", $db="")
            {
                $this->connexion = mysqli_connect($host, $username, $password, $db);
                $this->db = $db;
            }
            
            function connect($host="", $username="", $password="", $db="")
            {
                if(isset($this->connexion))
                {
                    $this->close();
                    echo "Connexion fermé <br>";
                }
                $this->connexion = mysqli_connect($host, $username, $password, $db);
                $this->db = $db;
            }
            
            function destructeur()
            {
                if(isset($this->connexion))
                {
                    mysqli_close($this->connexion);
                    echo "Connexion fermé <br>";
                }
            }
            
            function close()
            {
                if(isset($this->connexion))
                {
                    mysqli_close($this->connexion);
                    echo "Connexion fermé <br>";			
                }
            }
            
            function execute($query)
            {
                $this->lastQuery = $query;
                if(isset($this->connexion))
                {
                    $return_data = [];
                    $prepare = mysqli_query($this->connexion,$this->lastQuery);
                    foreach (mysqli_fetch_all($prepare) as $data)
                    {
                        array_push($return_data, $data);
                    }
                    
                    $this->lastResult = $return_data;
                    return $return_data;
                }
                else
                {
                    echo "pas de connexion <br>";
                }
            }
            
            function getLastQuery()
            {
                if(isset($this->lastQuery))
                {
                    return $this->lastQuery;
                }
                else
                {
                    return false;
                }
                
            }
            
            function getLastResult()
            {
                if(isset($this->lastResult))
                {
                    return $this->lastResult;
                }
                else
                {
                    return false;
                }
            }
            
            function getTables()
            {
                if(isset($this->connexion))
                {
                    $table=[];
                    $query = "SHOW TABLES";
                    foreach($this->execute($query) as $result)
                    {
                        array_push($table,$result);
                    }
                    return $table;
                }
                else
                {
                    echo "Pas de connexion<br>";
                }
                
            }

            function getFields($table)
            {
                if(isset($this->connexion))
                {
                    $field=[];
                    $query = "SHOW COLUMNS FROM $table";
                    foreach($this->execute($query) as $result)
                    {
                        array_push($field,$result);
                    }
                    return $field;
                }
                else
                {
                    echo "Pas de connexion<br>";
                }
                
            }
        }

    $user = new lpdo;

    $user->connect("localhost","root","","users");
    //$user->close();
    //$user->execute("SELECT * FROM utilisateurs");
    //$user->getLastQuery();
    //$user-> getLastResult();
    //$user->getTables();
    //$user->getFields('utilisateurs');
?>

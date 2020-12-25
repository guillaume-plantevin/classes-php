<?php 
    /*
        Consignes:
        Créez un fichier nommé “lpdo.php”. Dans ce fichier, créez une classe
        “lpdo” qui est une version simplifiée de pdo et qui utilise les fonctions
        mysqli*. Voici les méthodes que la classe doit avoir :

        NOTE:
        Vous êtes libres concernant les attributs présents dans cette classe, mais
        ils doivent être privés.
    */
    require_once('functions/functions.php');
    class lpdo {
        private $host = null;
        private $username = null;
        private $password = null;
        private $db = null;

        private $mysqli;
        public function constructeur($host, $username, $password, $db) {
            // Les paramètres sont optionnels. Ouvre une connexion à un serveur MySQL.

            $this->mysqli = new mysqli($host, $username, $password, $db);

            if ($this->mysqli->connect_errno) {
                echo '(constructeur) Failed to connected to MySQL' . $this->mysqli->connect_error;
                return FALSE;
            }
            else {
                echo '<p>(constructeur) connexion-DB: OK</p>';
                return TRUE;
            }
        }
        public function connect($host, $username, $password, $db) {
            // Ferme la connexion au serveur SQL en cours s’il y en a une et en ouvre une nouvelle.
            // var_dump_pre($this->mysqli, '$this->mysqli');

            if (isset($this->mysqli) && $this->mysqli->ping()) {
                // echo '38: ping: OK + $this->mysqli isset';
                $this->mysqli->close();
                $this->mysqli = new mysqli($host, $username, $password, $db);

                if ($this->mysqli->connect_errno) {
                    echo '(connect) Failed to connected to MySQL' . $this->mysqli->connect_error;
                    return FALSE;
                }
                else {
                    echo '<p>(connect) connexion-DB: OK</p>';
                    return TRUE;
                }
            }
            else {
                $this->mysqli = new mysqli($host, $username, $password, $db);

                if ($this->mysqli->connect_errno) {
                    echo '(connect) Failed to connected to MySQL' . $this->mysqli->connect_error;
                    return FALSE;
                }
                else {
                    echo '<p>(connect) connexion-DB: OK</p>';
                    return TRUE;
                }
            }
        }
    }

?>
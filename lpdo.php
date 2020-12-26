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
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $db = 'classes';

        private $mysqli;

        private $lastQuery = null;
        private $lastResult = null;

        public function __construct() {
            // Les paramètres sont optionnels. Ouvre une connexion à un serveur MySQL.

            $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->db);

            if ($this->mysqli->connect_errno) {
                echo '(__construct) Failed to connected to MySQL' . $this->mysqli->connect_error;
                return FALSE;
            }
            else {
                echo '<p>(__construct) connexion-DB: OK</p>';
                return TRUE;
            }
        }
        public function connect($host, $username, $password, $db) {
            // Ferme la connexion au serveur SQL en cours s’il y en a une et en ouvre une nouvelle.
            // var_dump_pre($this->mysqli, '$this->mysqli');

            if (isset($this->mysqli) && $this->mysqli->ping()) {
                
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
        public function close() {
            // Ferme la connexion au serveur MySQL.
            if (!isset($this->mysqli)) {
                echo '<p>69: connection is not set.</p>';
                return FALSE;
            }
            else {
                if (!$this->mysqli->close()) {
                    echo '<p>(destructeur) can\'t close connection</p>';
                    return FALSE;
                }
                else {
                    echo '<p>(destructeur) connexion-DB: CLOSED</p>';
                    return TRUE;
                }
            }
        }
        public function execute($query) {
            // Exécute la requête $query et retourne un tableau contenant la réponse du serveur SQL.
            /* check connection */
            if ($this->mysqli->connect_errno) {
                printf("Connect failed: %s\n", $this->mysqli->connect_error);
                exit();
            }
            /* Select queries return a resultset */
            if ($result = $this->mysqli->query($query)) {
                
                $this->lastQuery = $query;
                // $this->getLastResult = $result;
                $returnedData = $result->fetch_all(MYSQLI_ASSOC);
                $this->lastResult = $returnedData;
                return $returnedData;
            }
            else {
                return FALSE;
            }
        }
        function getlastQuery() {
            // Retourne la dernière requête SQL ayant été exécutée, false si aucune requête n’a été exécutée.
            if (!empty($this->lastQuery)) {
                return $this->lastQuery;
            }
            else 
                return FALSE;
            
        }
        function getLastResult() {
            // Retourne le résultat de la dernière requête SQL exécutée, false si aucune requête n’a été exécutée.
            if (!empty($this->lastResult)) {
                return $this->lastResult;
            }
            else 
                return FALSE;   
        }
        public function __destruct() {
            // Ferme la connexion au serveur MySQL.
            if (!isset($this->mysqli)) {
                echo '<p>69: connection is not set.</p>';
                return FALSE;
            }
            else {
                if (!$this->mysqli->close()) {
                    echo '<p>(__destruct) can\'t close connection</p>';
                    return FALSE;
                }
                else {
                    echo '<p>(__destruct) connexion-DB: CLOSED</p>';
                    return TRUE;
                }
            }
        }
    }

?>
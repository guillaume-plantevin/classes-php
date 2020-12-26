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
                echo '<p>(__construct) connexion-DB: OUVERTE</p>';
                return TRUE;
            }
        }
        public function connect($host, $username, $password, $db) {
            // Ferme la connexion au serveur SQL en cours s’il y en a une et en ouvre une nouvelle.

            if (isset($this->mysqli) && $this->mysqli->ping()) {
                
                $this->mysqli->close();
                $this->mysqli = new mysqli($host, $username, $password, $db);

                if ($this->mysqli->connect_errno) {
                    echo '(connect) Failed to connected to MySQL' . $this->mysqli->connect_error;
                    return FALSE;
                }
                else {
                    echo '<p>(connect) connexion-DB: OUVERTE</p>';
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
                    echo '<p>(connect) connexion-DB: OUVERTE</p>';
                    return TRUE;
                }
            }
        }
        public function close() {
            // Ferme la connexion au serveur MySQL.
            if (!isset($this->mysqli)) {
                echo '<p>(close) la connexion n\'est pas itinialisée.</p>';
                return FALSE;
            }
            else {
                if (!$this->mysqli->close()) {
                    echo '<p>(close) Erreur lors de fermeture de la connexion</p>';
                    return FALSE;
                }
                else {
                    echo '<p>(close) connexion-DB: FERMÉE</p>';
                    return TRUE;
                }
            }
        }
        public function execute($query) {
            // Exécute la requête $query et retourne un tableau contenant la réponse du serveur SQL.
            if ($this->mysqli->connect_errno) {
                printf("(execute) Connect failed: %s\n", $this->mysqli->connect_error);
                return FALSE;
            }
            $escQuery = $this->mysqli->real_escape_string($query);
            
            if (!$result = $this->mysqli->query($escQuery)) {
                echo '<p>(execute) erreur lors de l\'exécution de la requête</p>';
                return FALSE;
            }
            else {
                $this->lastQuery = $escQuery;
                $returnedData = $result->fetch_all(MYSQLI_ASSOC);
                $this->lastResult = $returnedData;
                return $returnedData;
            }
        }
        function getlastQuery() {
            // Retourne la dernière requête SQL ayant été exécutée, false si aucune requête n’a été exécutée.
            if (!empty($this->lastQuery)) {
                return $this->lastQuery;
            }
            else 
                echo '<p>(getlastQuery) Aucune requête n\'a été réalisé précédemment.</p>';
                return FALSE;
        }
        function getLastResult() {
            // Retourne le résultat de la dernière requête SQL exécutée, false si aucune requête n’a été exécutée.
            if (!empty($this->lastResult)) {
                return $this->lastResult;
            }
            else 
                echo '<p>(getLastResult) Aucune résultat n\'a été enregistré précédemment.</p>';
                return FALSE;   
        }
        function getFields($table) {
            // Retourne un tableau contenant la liste des champs présents dans la table passée en paramètre, 
            // false en cas d’erreur.
            if ($this->mysqli->connect_errno) {
                printf("(getFields) Connect failed: %s\n", $this->mysqli->connect_error);
                return FALSE;
            }
            // indispensable ?
            $escTable = $this->mysqli->real_escape_string($table);

            //  also: SHOW COLUMNS FROM
            if (!$result = $this->mysqli->query("DESCRIBE {$escTable}")) {
                echo '<p>(execute) erreur lors de l\'exécution de la requête</p>';
                return FALSE;
            }
            else 
                $returnedData = $result->fetch_all(MYSQLI_ASSOC);

            if (empty($returnedData)) {
                echo '<p style="color:red;text-transform:uppercase;">[GET_FIELDS] le retour de la requête est vide.</p>';
                return FALSE;
            }
            else 
                return $returnedData;
        }
        public function __destruct() {
            // Ferme la connexion au serveur MySQL.
            if (!isset($this->mysqli)) {
                echo '<p>(__destruct) la connexion n\'a pas été initialisé.</p>';
                return FALSE;
            }
            else {
                if (!$this->mysqli->close()) {
                    echo '<p>(__destruct) Erreur lors de fermeture de la connexion</p>';
                    return FALSE;
                }
                else {
                    echo '<p>(__destruct) connexion-DB: FERMÉE</p>';
                    return TRUE;
                }
            }
        }
    }

?>
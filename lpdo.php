<?php 
    /*
        Consignes:
        Créez un fichier nommé “lpdo.php”. Dans ce fichier, créez une classe
        “lpdo” qui est une version simplifiée de pdo et qui utilise les fonctions
        mysqli*. Voici les méthodes que la classe doit avoir :

        NOTE:
        Vous êtes libres concernant les attributs présents dans cette classe, mais
        ils doivent être privés.

        NOTE DE L'ETUDIANT:
        Je ne suis pas certain d'avoir compris le but n'aillant utilisé mysqli 
        qu'en mode objet et non en procédurale, du coup j'avais déjà un code orienté objet...
    */
    require_once('functions/functions.php');
    class lpdo {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $db = 'classes';

        private $dbcon;

        function __construct() {
            // Les paramètres sont optionnels. Ouvre une connexion à un serveur MySQL.
            
            $this->dbcon = new mysqli($this->host, $this->username, $this->password, $this->db);

            if ($this->dbcon->connect_error) {
                echo '<p style="color:red;text-transform:uppercase;">[__CONSTRUCT] Connexion[DB]: failed:</p>';
                die("$this->dbcon->connect_errno: $this->dbcon->connect_error");
            }
            // DEBUG
            echo '<p style="color:green;text-transform:uppercase;">[__CONSTRUCT] Connexion[DB]: success.</p>';
        }
        function connect($host, $username, $password, $db) {
            // Ferme la connexion au serveur SQL en cours s’il y en a une et en ouvre une nouvelle.
            // DEBUG
            // var_dump_pre(empty($this->dbcon), '!empty($this->dbcon)');
            // var_dump_pre(isset($this->dbcon), 'isset($this->dbcon)');
            
            if (empty($this->dbcon) || !isset($this->dbcon)) {
                $this->__construct($this->host, $this->username, $this->password, $this->db);
                echo '<p style="color:green;text-transform:uppercase;">[CONNECT] Connexion[DB]: success.</p>';
            }
            else {
                echo '<p style="color:red;text-transform:uppercase;">[CONNECT] Connexion[DB]: previous one closed.</p>';
                $this->dbcon->close();
                $this->__construct($host, $username, $password, $db);
            }
            
        }
        function close() {
            // Ferme la connexion au serveur MySQL.
            if (isset($this->dbcon)) {
                $this->dbcon->close();
                echo '<p style="color:green;text-transform:uppercase;">[CLOSE] Connexion (DB): fermée.</p>';
                return;
            }
            
        }
        function execute($query) {
            // Exécute la requête $query et retourne un tableau contenant la réponse du serveur SQL.
            
            $result = $this->dbcon->query($query);

            $returnedData = $result->fetch_all(MYSQLI_ASSOC);

            if (empty($returnedData)) {
                echo '<p style="color:red;text-transform:uppercase;">[EXECUTE] Query[DB]: empty.</p>';
                return 1;
            }
            else {
                echo '<p style="color:green;text-transform:uppercase;">[EXECUTE] Query[DB]: success.</p>';
            }
            return $returnedData;
        }
        function getLastQuery() {
            // Retourne la dernière requête SQL ayant été exécutée, false si aucune requête n’a été exécutée.
            
        }
        function getLastResult() {
            // Retourne le résultat de la dernière requête SQL exécutée, false si aucune requête n’a été exécutée.
            
        }
        function getTables() {
            // Retourne un tableau contenant la liste des tables présentes dans la base de données.
            $query = "SHOW TABLES";
            $result = $this->dbcon->query($query);
            $returnedData = $result->fetch_all(MYSQLI_ASSOC);
            if (empty($returnedData)) 
                echo '<p style="color:red;text-transform:uppercase;">[GET_TABLES] le retour de la requête est vide.</p>';
            else 
                return $returnedData;


        }
        // ERROR
        function getFields($table) {
            // Retourne un tableau contenant la liste des champs présents dans la table passée en paramètre, 
            // false en cas d’erreur.

            // Pour une raison encore inconnue, je ne pouvais pas bind_param sur cette requete meme apres de multiples essais
            // putain... marche plus... 
            // NE FONCTIONNE PLUS
            /* Prepared statement, stage 1: prepare */
            if (!($stmt = $this->dbcon->prepare("SHOW FULL COLUMNS FROM $table"))) {
                echo "Prepare failed: (" . $this->dbcon->errno . ") " . $this->dbcon->error;
                return false;
            }

            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                return false;
            }
            $returnedData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            if (empty($return)) {
                echo '<p style="color:red;text-transform:uppercase;">[GET_FIELDS] le retour de la requête est vide.</p>';
                return false;
            }
            else 
                return $returnedData;
        }
        function getFields2($table) {
            // Retourne un tableau contenant la liste des champs présents dans la table passée en paramètre, 
            // false en cas d’erreur.

            // NE MARCHE PAS

            /* Prepared statement, stage 1: prepare */
            if (!($stmt = $this->dbcon->prepare("SHOW FULL COLUMNS FROM ?"))) {
                echo "Prepare failed: (" . $this->dbcon->errno . ") " . $this->dbcon->error;
                return false;
            }

            /* Prepared statement, stage 2: bind and execute */
            // $id = 49;
            if (!$stmt->bind_param("s", $table)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
                return false;
            }

            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                return false;
            }
            $return = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            // PROBLEME SUR LE RETOUR EN FALSE: NE MARCHE PAS
            if (!$return) {
                echo '<p style="color:red;text-transform:uppercase;">[GET_FIELDS] le retour de la requête est vide.</p>';
                return false;
            }
            else 
                return $return;
        }
        function __destruct() {
            // Ferme la connexion au serveur MySQL.
                $this->dbcon->close();

                //  DEBUG
                echo '<p style="color:green;text-transform:uppercase;">
                        [__DESTRUCT] Connexion (DB): fermée.</p>';
        }
    }

?>
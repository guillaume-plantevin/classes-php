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

        private $dbcon;

        function constructeur($host, $username, $password, $db) {
            // Les paramètres sont optionnels. Ouvre une connexion à un serveur MySQL.
            
            $this->dbcon = new mysqli($host, $username, $password, $db);

            if ($this->dbcon->connect_error) {
                echo '<p style="color:red;text-transform:uppercase;">Échec de la connexion:</p>';
                die("$this->dbcon->connect_errno: $this->dbcon->connect_error");
            }
            echo '<p style="color:green;text-transform:uppercase;">Connexion (DB) réussie.</p>';
            
        }
        function connect($host, $username, $password, $db) {
            // Ferme la connexion au serveur SQL en cours s’il y en a une et en ouvre une nouvelle.
            // DEBUG
            // var_dump_pre(empty($this->dbcon), '!empty($this->dbcon)');
            // var_dump_pre(isset($this->dbcon), 'isset($this->dbcon)');
            
            if (empty($this->dbcon) || !isset($this->dbcon)) {
                // echo 'Im in IF<br>';
                $this->constructeur($host, $username, $password, $db);
            }
            else {
                // echo 'im in ELSE<br>';
                $this->dbcon->close();
                $this->constructeur($host, $username, $password, $db);
            }
            
        }
        function destructeur() {
            // Ferme la connexion au serveur MySQL.

        }
        function close() {
            // Ferme la connexion au serveur MySQL.

        }
        function execute($query) {
            // Exécute la requête $query et retourne un tableau contenant la réponse du serveur SQL.

        }
        function getLastQuery() {
            // Retourne la dernière requête SQL ayant été exécutée, false si aucune requête n’a été exécutée.

        }
        function getLastResult() {
            // Retourne le résultat de la dernière requête SQL exécutée, false si aucune requête n’a été exécutée.

        }
        function getTables() {
           // Retourne un tableau contenant la liste des tables présentes dans la base de données.

        }
        function getFields($table) {
            // Retourne un tableau contenant la liste des champs présents dans la table passée en paramètre, 
            // false en cas d’erreur.
        }
    }

?>
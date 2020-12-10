<?php
    require_once('functions/functions.php');
    /*
        NOTE:
        Vos requêtes SQL doivent être faites à l’aide des fonctions mysqli*.
    */

    // require_once('connect.php');
    class user {
        private $id = '';
        public $login = '';
        public $email = '';
        public $password = '';
        public $firstname = '';
        public $lastname = '';

        private $dbc;
        private $dbclosing;

        public $host = '127.0.0.1';
        // public $port = 3306;
        public $db   = 'classes';
        public $user = 'root';
        public $pass = '';
        // public $charset = 'utf8mb4';
        // public $charset = 'utf8';

        // 
        public function __construct() {
            $this->dbc = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

            // controlData($this->dbc, '$dbc');
            if ($this->dbc) {
                echo "<p style='color:green'>connection established</p>";
            }
            else {
                print '<p style="color:red;">Could not connect to the database:<br>' . mysqli_connect_error() . '.</p>';
                exit();
            }
        }

        public function register($login, $password, $email, $firstname, $lastname) {
            // Crée l’utilisateur en base de données. 
            // Retourne un tableau(array) contenant l’ensemble des informations concernant l’utilisateur créé.


            // $stmt = $this->dbc->prepare("SELECT * FROM utlisateurs WHERE login = ?");
            $stmt = $this->dbc->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) 
                                        VALUES ($this->login, $this->password, $this->email, $this->firstname, $this->lastname);");

            $stmt->bind_param("sssss", $this->login, $this->password, $this->email, $this->firstname, $this->lastname);
            $stmt->execute();
            $reg = $stmt->get_result()->fetch_assoc();


            // $query = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) 
            //             VALUES ($this->login, $this->password, $this->email, $this->firstname, $this->lastname);";
            // $query = 'INSERT INTO utilisateurs (login, password) VALUES ("toto", "123123")';
            // $reg = mysqli_query($this->dbc, $query);
            controlData($reg, '$reg');
            var_dump($reg);
        }
        public function connect($login, $password) {
            // Connecte l’utilisateur, modifie les attributs présents dans la classe et
            // retourne un tableau contenant l’ensemble de ses informations.
 
        }
        public function disconnect​() {
            // Déconnecte l’utilisateur.

        }
        public function delete() {
            // Supprime et déconnecte l’utilisateur.

        }
        public function update​($login, $password, $email, $firstname, $lastname) {
            // Modifie les informations de l’utilisateur en base de données.

        }
        public function isConnected​() {
            // Retourne un booléen permettant de savoir si un utilisateur est connecté ou non.            

        }
        public function getAllInfos() {
            // Retourne un tableau contenant l’ensemble des informations de l’utilisateur.

        }
        public function getEmail() {
            // Retourne l’adresse email de l’utilisateur connecté.

        }
        public function getFirstname() {
            // Retourne le firstname de l’utilisateur connecté.

        }
        public function getLastname() {
            // Retourne le lastname de l’utilisateur connecté.

        }
        public function refresh() {
            // Met à jour les attributs de la classe à partir de la base de données.

        }
        public function __destruct() {
            $this->dbclosing = mysqli_close($this->dbc);

            controlData($this->dbclosing, '$dbclosing');

            if ($this->dbclosing) {
                echo '<p style="color:green">Succesfully disconnected.</p>';
            }
            else {
                echo '<p style="color:red">problem while disconnecting.</p>';
                exit();
            }
        }
    }
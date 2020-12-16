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

        private $dbConnect;
        private $dbclosing;

        public $host = 'localhost';
        // public $port = 3306;
        public $db   = 'classes';
        public $user = 'root';
        public $pass = '';
        // public $charset = 'utf8mb4';
        // public $charset = 'utf8';
        
        // 
        public function __construct() {
            $this->dbConnect = new mysqli($this->host, $this->user, $this->pass, $this->db);
            if($this->dbConnect === false){
                die("ERROR: Could not connect. " . $this->dbConnect->connect_error);
            }
            // Feedback, to erase after
            echo "Connect Successfully. Host info: " . $this->dbConnect->host_info;
        }

        public function register($login, $password, $email, $firstname, $lastname) {
            // Crée l’utilisateur en base de données. 
            // Retourne un tableau(array) contenant l’ensemble des informations concernant l’utilisateur créé.
            $password = md5($password);
			$sql = "SELECT * FROM utlisateurs WHERE login ='$login' OR email = '$email'; ";
 
			//checking if the username or email is available in database classes
			$check =  $this->dbConnect->query($sql);
			$count_row = $check->num_rows;
 
			//if the username is not in db then insert to the table
			if ($count_row == 0){
				$sql1="INSERT INTO utilisateurs VALUES (login ='$login', password ='$password', email ='$email', firstname = $firstname, lastname = $lastname)";
				$result = mysqli_query($this->db,$sql1) or die(mysqli_connect_errno()."Data cannot inserted");
        		return $result;
			}
			else { 
                return false;
            }
		}
 

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
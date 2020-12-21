<?php
    require_once('functions/functions.php');
    /*
        NOTE:
        Vos requêtes SQL doivent être faites à l’aide des fonctions mysqli*.
    */
    class user {
        private $id;

        public $login;
        public $email;
        public $password;
        public $firstname;
        public $lastname;

        private $mysqli;

        public $host = 'localhost';
        public $db   = 'classes';
        public $user = 'root';
        public $pass = '';
        
        public function __construct() {
            $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
            
            // Check connection
            if ($this->mysqli->connect_error) {
                echo '<p style="color:red;text-transform:uppercase;">Échec de la connexion:</p>';
                die("$this->mysqli->connect_errno: $this->mysqli->connect_error");
            }
            echo '<p style="color:green;text-transform:uppercase;">Connection to DB: OK</p>';
            echo "Host info: " . $this->mysqli->host_info;
        }

        public function register($login, $password, $email, $firstname, $lastname) {
            // Crée l’utilisateur en base de données. 
            // Retourne un tableau(array) contenant l’ensemble des informations concernant l’utilisateur créé.

            // sanitize input data
            $saLogin = htmlentities($login);
            $pHash = password_hash($password, PASSWORD_DEFAULT);
            $saEmail = htmlentities($email);
            $saFirstname = htmlentities($firstname);
            $saLastname = htmlentities($lastname);
            
            $sql = "SELECT * FROM utilisateurs WHERE login = ? OR email = ?"; 

            $stmt = $this->mysqli->prepare($sql); 
            $stmt->bind_param('ss', $saLogin, $saEmail);
            $stmt->execute();
            // get the mysqli result
            $result = $stmt->get_result(); 
            // fetch the data   
            $user = $result->fetch_assoc(); 

            // $userInfo = $user;
            // print_r_pre($user, '$user, while verifying:');
 
			//if the username is not in db then insert to the table
			if (empty($user)) {
				$sqlRegister = "INSERT INTO utilisateurs (login, password, email, firstname, lastname)
                                VALUES (?, ?, ?, ?, ?)";

                $stmt = $this->mysqli->prepare($sqlRegister);
                $stmt->bind_param('sssss', $saLogin, $pHash, $saEmail, $saFirstname, $saLastname);
                $stmt->execute();
                $result = $stmt->get_result();
                
                // print_r_pre($result, '$result:');
                // $user = $result->fetch_assoc();

                $sqlReturn = "SELECT * FROM utilisateurs WHERE login = ? AND password = ?";

                $stmt = $this->mysqli->prepare($sqlReturn);
                $stmt->bind_param('ss', $saLogin, $pHash);
                $stmt->execute();
                // $result = $stmt->get_result(); 
                // $userInfo = $result->fetch_assoc(); 
                $user = $stmt->get_result()->fetch_assoc();

                echo '<p style="color:red;text-transform:uppercase;">Profil enregistré avec succès.</p>';
        		return $user;
			}
			else { 
                echo '<p style="color:red;text-transform:uppercase;">Ce login ou cet email ont déjà été utilisés.</p>';
                exit(1);
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

            $this->mysqli->close();

            // print_r_pre($this->mysqli, '$mysqli->close:');

            if ($this->mysqli) {
                echo '<p style="color:green;text-transform:uppercase;">Succesfully disconnected.</p>';
                return;
            }
            else {
                echo '<p style="color:red;text-transform:uppercase;">problem while disconnecting.</p>';
                exit(1);
            }
        }
    }
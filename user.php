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

        public function __construct() {
            $host = 'localhost';
            $db   = 'classes';
            $user = 'root';
            $pass = '';

            $this->mysqli = new mysqli($host, $user, $pass, $db);
            
            // Check connection
            if ($this->mysqli->connect_error) {
                echo '<p style="color:red;text-transform:uppercase;">Échec de la connexion:</p>';
                die("$this->mysqli->connect_errno: $this->mysqli->connect_error");
            }
            echo '<p style="color:green;text-transform:uppercase;">Connexion réussie.</p>';
            // echo "Host info: " . $this->mysqli->host_info;
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
            // get the mysqli result & fetch as an associative array
            $user = $stmt->get_result()->fetch_assoc();

			//if the username is not in db then insert to the table
			if (empty($user)) {
				$sqlRegister = "INSERT INTO utilisateurs (login, password, email, firstname, lastname)
                                VALUES (?, ?, ?, ?, ?)";

                $stmt = $this->mysqli->prepare($sqlRegister);
                $stmt->bind_param('sssss', $saLogin, $pHash, $saEmail, $saFirstname, $saLastname);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                
                // return what the DB has received
                // $sqlReturn = "SELECT * FROM utilisateurs WHERE login = ? AND password = ?";

                // $stmt = $this->mysqli->prepare($sqlReturn);
                // $stmt->bind_param('ss', $saLogin, $pHash);
                // $stmt->execute();
                // $user = $stmt->get_result()->fetch_assoc();

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

            $saLogin = htmlentities($login);
            // $pHash = password_hash($password, PASSWORD_DEFAULT);

            // VERIFIER que l'utilisateur existe en DB
            $verifying = "SELECT * FROM utilisateurs WHERE login = ?";

            $stmt = $this->mysqli->prepare($verifying); 
            $stmt->bind_param('s', $saLogin);
            $stmt->execute();
            // get the mysqli result & fetch as an associative array
            $user = $stmt->get_result()->fetch_assoc();

            if (empty($user)) {
                echo '<p style="color:red;text-transform:uppercase;">Ce login n\'existe pas.</p>';
                exit(1);
            }
            else if (!password_verify($password, $user['password'])) {
                echo '<p style="color:red;text-transform:uppercase;">Le mot de passe que vous avez fourni ne correspond pas à celui enregistré.</p>';
                return FALSE;
            }
            else {
                // change les attributs
                foreach ($user as $key => $value) {
                    $this->$key = $value;
                }
                // garde en memoire le mot de passe et non pas le hash
                $this->password = htmlentities($password);

                // renvoi le mot de passe enregistré et non pas le hash
                $user['password'] = htmlentities($password);

                return $user;
            }
        }
        public function disconnect​() {
            // Déconnecte l’utilisateur.

            if (isset($this->login) && !empty($this->login)) {
                $this->id = null;
                $this->login = null;
                $this->password = null;
                $this->email = null;
                $this->firstname = null;
                $this->lastname = null;
            }
            else {
                echo '<p style="color:red;text-transform:uppercase;">Cet utilisateur n\'est as connecté.</p>';
            }
        }
        public function delete() {
            // Supprime et déconnecte l’utilisateur.

            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Cet utilisateur n\'est pas connecté.</p>';
                return;
            }
            else {
                $sql = "DELETE FROM utilisateurs WHERE id = ?";
                
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param('d', $this->id);
                $stmt->execute();


                $this->id = null;
                $this->login = null;
                $this->password = null;
                $this->email = null;
                $this->firstname = null;
                $this->lastname = null;

                // FLASH msg
                echo '<p style="color:green;text-transform:uppercase;">Profil supprimé avec succès!.</p>';
                return;
            }

        }
        public function update​($login, $password, $email, $firstname, $lastname) {
            // Modifie les informations de l’utilisateur en base de données.

            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Cet utilisateur n\'est pas connecté.</p>';
                return(1);
            }
            else {
                $sql = "UPDATE utilisateurs 
                        SET 
                        login = ?, 
                        password = ?, 
                        email = ?, 
                        firstname = ?,
                        lastname = ?
                        WHERE 
                        id = ?";

                $saLogin = htmlentities($login);
                $pHash = password_hash($password, PASSWORD_DEFAULT);
                $saEmail = htmlentities($email);
                $saFirstname = htmlentities($firstname);
                $saLastname = htmlentities($lastname);

                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param('sssssd', 


                                $this->id);  

                $stmt->execute(array(
                    ':login' => htmlentities($login),
                    ':password' => password_hash(htmlentities($password), PASSWORD_DEFAULT),
                    ':email' => htmlentities($email),
                    ':firstname' => htmlentities($firstname),
                    ':lastname' => htmlentities($lastname),
                    ':id' => $this->id
                ));

                echo '<p style="color:green;text-transform:uppercase;">Le profil mis à jour avec succès.</p>';
                return;
            }

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
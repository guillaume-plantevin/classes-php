<?php
    require_once('functions/functions.php');
    /*
        Consignes:
        Créez un fichier nommé “user-pdo.php”. Dans ce fichier, créez une classe
        “userpdo” en vous basant sur la classe user que vous avez créé dans le job1. 
        
        => Vos requêtes SQL doivent maintenant être faites avec pdo.
    */
    class userpdo {
        private $id;

        public $login;
        public $password;
        public $email;
        public $firstname;
        public $lastname;

        private $pdo;
        
        public function getId() {
            return $this->id;
        }

        public function __construct() {
            $this->pdo = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
            // See the "errors" folder for details...
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // just to verify it is working
            echo '<p style="color:green;text-transform:uppercase;">Connection to DB: OK</p>';
        }

        public function register($login, $password, $email, $firstname, $lastname) {
            // Crée l’utilisateur en base de données. 
            // Retourne un tableau contenant l’ensemble des informations concernant l’utilisateur créé.

            // Verification que le compte n'existe pas deja
            $verifying = "SELECT * FROM utilisateurs WHERE login = :login AND email = :email";

            $stmt = $this->pdo->prepare($verifying);

            $stmt->execute([
                ':login' => htmlentities($login),
                ':email' => htmlentities($email)
            ]);

            $user = $stmt->fetchAll();

            // EXISTE deja
            if (!empty($user)) {
                echo '<p style="color:red;text-transform:uppercase;">Ce login est déjà utilisé.</p>';
                return;
            }

            // N'EXISTE PAS ==> CREATION
            else {
                $sql = "INSERT INTO utilisateurs (
                    login, password, email, firstname, lastname) 
                    VALUES (
                    :login, :password, :email, :firstname, :lastname)";
    
    
                $stmt = $this->pdo->prepare($sql);
    
                $stmt->execute(array(
                    ':login' => htmlentities($login),
                    ':password' => hash('sha256', htmlentities($password)),
                    ':email' => htmlentities($email),
                    ':firstname' => htmlentities($firstname),
                    ':lastname' => htmlentities($lastname)
                ));
                
                // DEBUG: FLASH MESSAGE
                echo '<p style="color:green;text-transform:uppercase;">utilisateur enregistré.</p>';
                
                $infoUser = [
                    'login' => htmlentities($login),
                    'password' => htmlentities($password),
                    'email' => htmlentities($email),
                    'firstname' => htmlentities($firstname),
                    'lastname' => htmlentities($lastname)
                ];

                return $infoUser;            
            }
        }
        
        public function connect($login, $password) {
            // Connecte l’utilisateur, modifie les attributs présents dans la classe et
            // retourne un tableau contenant l’ensemble de ses informations.

            // VERIFIER que l'utilisateur existe en DB
            $verifying = "SELECT * FROM utilisateurs WHERE login = :login AND password = :password";
            
            $stmt = $this->pdo->prepare($verifying);

            $stmt->execute([
                ':login' => htmlentities($login),
                ':password' => hash('sha256', htmlentities($password))
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($user)) {
                echo '<p style="color:red;text-transform:uppercase;">Ce compte n\'existe pas ou les informations ne sont pas exactes.</p>';
                return FALSE;
            }
            else {
                foreach ($user as $key => $value) {
                    $this->$key = $value;
                }
                // garde en memoire le mot de passe et non pas le hash
                $user['password'] = $password;
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
                $sql = "DELETE FROM utilisateurs 
                        WHERE id = :id";

                $stmt = $this->pdo->prepare($sql);

                $stmt->execute(array(':id' => $this->id));

                $this->id = null;
                $this->login = null;
                $this->password = null;
                $this->email = null;
                $this->firstname = null;
                $this->lastname = null;

                echo '<p style="color:green;text-transform:uppercase;">Profil supprimé de la Base de Données.</p>';
                return;
            }
        }

        public function update​($login, $password, $email, $firstname, $lastname) {
            // Modifie les informations de l’utilisateur en base de données.

            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Cet utilisateur n\'est pas connecté.</p>';
                return;
            }
            else {
                $sql = "UPDATE utilisateurs 
                        SET 
                        login = :login, 
                        password = :password, 
                        email = :email, 
                        firstname = :firstname,
                        lastname = :lastname
                        WHERE login = :login 
                        AND 
                        id = :id";
    
                $stmt = $this->pdo->prepare($sql);
    
                $stmt->execute(array(
                    ':login' => htmlentities($login),
                    ':password' => hash('sha256', htmlentities($password)),
                    ':email' => htmlentities($email),
                    ':firstname' => htmlentities($firstname),
                    ':lastname' => htmlentities($lastname),
                    ':id' => $this->id
                ));

                echo '<p style="color:green;text-transform:uppercase;">Le profil a bien été mis à jour.</p>';
                return;
            }
        }
        public function isConnected​() {
            // Retourne un booléen permettant de savoir si un utilisateur est connecté ou non.  
            // var_dump_pre($this->login, '$this->login');
            if (empty($this->login) && !isset($this->login)) {
                return FALSE;
            }
            else {
                return TRUE;
            }

        }
        public function getAllInfos() {
            // Retourne un tableau contenant l’ensemble des informations de l’utilisateur.
            $infoUser = [
                'id' => $this->id,
                'login' => $this->login,
                'password' => $this->password,
                'email' => $this->email,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname
            ];
            return  $infoUser;
        }
        public function getEmail() {
            // Retourne l’adresse email de l’utilisateur connecté.
            return $this->email;

        }
        public function getFirstname() {
            // Retourne le firstname de l’utilisateur connecté.
            return $this->firstname;
        }
        public function getLastname() {
            // Retourne le lastname de l’utilisateur connecté.
            return $this->lastname;

        }
        public function refresh() {
            // Met à jour les attributs de la classe à partir de la base de données.

        }
        public function __destruct() {
            echo 'FUNCTION __DESTRUCT(): ';
            $allInfoUser = [
                'id' => $this->id,
                'login' => $this->login,
                'password' => $this->password,
                'email' => $this->email,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname
            ];
            // DEBUG
            echo $this->login . ':<br>';
            // echo 'END of destruct(): ';
            print_r_pre($allInfoUser, 'RÉSUMÉ: ' . $this->login . ':');
            return;
        }
    }
?>
<?php
    require_once('functions/functions.php');
    class userpdo {
        private $id;

        public $login;
        public $password;
        public $email;
        public $firstname;
        public $lastname;

        private $pdo;

        public function __construct() {
            $this->pdo = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // FLASH MESSAGE
            // NOTE: PLUSIEURS SONT UTLISES DANS LE CODE
            echo '<p style="color:green;text-transform:uppercase;">Connection to DB: OK</p>';
        }

        public function register($login, $password, $email, $firstname, $lastname) {
            // Crée l’utilisateur en base de données. 
            // Retourne un tableau contenant l’ensemble des informations concernant l’utilisateur créé.

            // Verification que le login avec ce mail n'existe pas déjà
            $verifying = "SELECT * FROM utilisateurs WHERE login = :login OR email = :email";

            $stmt = $this->pdo->prepare($verifying);

            $stmt->execute([
                ':login' => htmlentities($login),
                ':email' => htmlentities($email)
            ]);

            $user = $stmt->fetchAll();

            // EXISTE déjà
            if (!empty($user)) {
                echo '<p style="color:red;text-transform:uppercase;">Ce login et/ou email sont déjà utilisés.</p>';
                exit(1);
            }
            // N'EXISTE PAS ==> CREATION
            else {
                $sql = "INSERT INTO utilisateurs (
                    login, password, email, firstname, lastname) 
                    VALUES (:login, :password, :email, :firstname, :lastname)";
    
                $stmt = $this->pdo->prepare($sql);
    
                $stmt->execute($infoUser = [
                    ':login' => htmlentities($login),
                    ':password' => password_hash(htmlentities($password), PASSWORD_DEFAULT),
                    ':email' => htmlentities($email),
                    ':firstname' => htmlentities($firstname),
                    ':lastname' => htmlentities($lastname)
                ]);
                
                // DEBUG: FLASH MESSAGE
                echo '<p style="color:green;text-transform:uppercase;">utilisateur enregistré.</p>';

                return $infoUser;            
            }
        }
        
        public function connect($login, $password) {
            // Connecte l’utilisateur, modifie les attributs présents dans la classe et
            // retourne un tableau contenant l’ensemble de ses informations.

            // VERIFIER que l'utilisateur existe en DB
            $verifying = "SELECT * FROM utilisateurs WHERE login = :login";

            $stmt = $this->pdo->prepare($verifying);

            $inputLogin = htmlentities($login);

            $stmt->execute(array (
                ':login' => $inputLogin
            ));
                
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($user)) {
                echo '<p style="color:red;text-transform:uppercase;">Ce compte n\'existe pas ou les informations fournies ne sont pas exactes.</p>';
                exit(1);
            }
            else if (!password_verify(htmlentities($password), $user['password'])) {
                echo '<p style="color:red;text-transform:uppercase;">Le mot de passe que vous avez fourni ne correspond pas à celui enregistré.</p>';
                exit(1);
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
                exit(1);
            }
        }

        public function delete() {
            // Supprime et déconnecte l’utilisateur.

            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Cet utilisateur n\'est pas connecté.</p>';
                exit(1);
            }
            else {
                $sql = "DELETE FROM utilisateurs WHERE id = :id";

                $stmt = $this->pdo->prepare($sql);

                $stmt->execute(array(':id' => $this->id));

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
                exit(1);
            }
            else {
                $sql = "UPDATE utilisateurs 
                        SET 
                        login = :login, 
                        password = :password, 
                        email = :email, 
                        firstname = :firstname,
                        lastname = :lastname
                        WHERE 
                        id = :id";
    
                $stmt = $this->pdo->prepare($sql);
    
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

            if (empty($this->id) && !isset($this->id)) {
                return FALSE;
            }
            else {
                return TRUE;
            }
        }

        public function getAllInfos() {
            // Retourne un tableau contenant l’ensemble des informations de l’utilisateur.
            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Le profil que vous essayez de voir les informations n\'est pas connecté.</p>';
                exit(1);
            }
            else {
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
        }

        public function getEmail() {
            // Retourne l’adresse email de l’utilisateur connecté.
            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Le profil désiré n\'est pas connecté.</p>';
                exit(1);
            }
            else
                return $this->email;
        }

        public function getFirstname() {
            // Retourne le firstname de l’utilisateur connecté.
            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Le profil désiré n\'est pas connecté.</p>';
                exit(1);
            }
            else
                return $this->firstname;
        }

        public function getLastname() {
            // Retourne le lastname de l’utilisateur connecté.
            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Le profil désiré n\'est pas connecté.</p>';
                exit(1);
            }
            else
                return $this->lastname;
        }

        public function refresh() {
            // Met à jour les attributs de la classe à partir de la base de données.
            if (empty($this->id) && !isset($this->id)) {
                echo '<p style="color:red;text-transform:uppercase;">Cet utilisateur n\'est pas connecté.</p>';
                exit(1);
            }
            else {
                $sql = "SELECT * FROM utilisateurs WHERE id = :id";

                $stmt = $this->pdo->prepare($sql);
    
                $stmt->execute([':id' => $this->id]);

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                foreach ($user as $key => $value) 
                    $this-> $key = $value;
                echo '<p style="color:green;text-transform:uppercase;">Attributs mis à jour avec succès.</p>';
            }
        }
        // public function __destruct() {
        //     $allInfoUser = [
        //         'id' => $this->id,
        //         'login' => $this->login,
        //         'password' => $this->password,
        //         'email' => $this->email,
        //         'firstname' => $this->firstname,
        //         'lastname' => $this->lastname
        //     ];
        //     /* DEBUG */
        //     print_r_pre($allInfoUser, 'RÉSUMÉ: ' . $this->login . ':');
        //     return;
        // }
    }
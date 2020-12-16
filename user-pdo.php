<?php
    require_once('functions/functions.php');

    /*
        Consignes:
        Créez un fichier nommé “user-pdo.php”. Dans ce fichier, créez une classe
        “userpdo” en vous basant sur la classe user que vous avez créé dans le job1. 
        
        => Vos requêtes SQL doivent maintenant être faites avec pdo.
    */
    class userpdo {
        private $id = FALSE;

        public $login = FALSE;
        public $password = FALSE;
        public $email = FALSE;
        public $firstname = FALSE;
        public $lastname = FALSE;

        private $pdo;
        private $logged = FALSE;
        
        public function getId() {
            return $this->id;
        }

        public function __construct() {
            $this->pdo = new PDO('mysql:host=localhost;dbname=classes', 
            'root', '');
            // See the "errors" folder for details...
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // just to verify it is working
            echo '<p style="color:green;text-transform:uppercase;">Connection: OK</p>';
        }
        public function register($login, $password, $email, $firstname, $lastname) {
            // Crée l’utilisateur en base de données. 
            // Retourne un tableau contenant l’ensemble des informations concernant l’utilisateur créé.

            // RAJOUT: 
            // vérifie si l'utilisateur existe déjà
            // Si c'est le cas, ne rajoute pas l'utilisateur en DB

            $this->login = htmlentities($login);
            $this->password = htmlentities($password);
            $this->email = htmlentities($email);
            $this->firstname = htmlentities($firstname);
            $this->lastname = htmlentities($lastname);

            // verifying if login already exists
            $verifying = "SELECT * FROM utilisateurs WHERE login = :login";

            // DEBUG: the query
            // echo "<pre>" . $verifying . "</pre>";

            $stmt = $this->pdo->prepare($verifying);

            $stmt->execute([':login' => $this->login]);

            $user = $stmt->fetchAll();

            // DEBUG: see the datas, if any exists
            // print_r_pre($user, '$user:');

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
    
                // DEBUG: verifying the query
                echo("<pre>\n".$sql."\n</pre>\n");
    
                $stmt = $this->pdo->prepare($sql);
    
                $stmt->execute(array(
                    ':login' => $this->login,
                    ':password' => hash('sha256', $this->password),
                    ':email' => $this->email,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname));
                
                // DEBUG
                echo '<p style="color:green;text-transform:uppercase;">utilisateur enregistré.</p>';

                $infoUser = [
                    'login' => $this->login,
                    'password' => $this->password,
                    'email' => $this->email,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname
                    ];
                return $infoUser;            
            }
        }
        
        public function connect($login, $password) {
            // Connecte l’utilisateur, modifie les attributs présents dans la classe et
            // retourne un tableau contenant l’ensemble de ses informations.

            // SET attributes
            $this->login = htmlentities($login);
            $this->password = htmlentities($password);

            // VERIFIER que l'utilisateur existe en DB
            $verifying = "SELECT * FROM utilisateurs WHERE login = :login AND password = :password";

            $stmt = $this->pdo->prepare($verifying);

            $stmt->execute([
                ':login' => $this->login,
                ':password' => hash('sha256', $this->password)
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // DEBUG: show data
            echo 'INSIDE connect function:';
            print_r_pre($user, $this->login);

            if (empty($user)) {
                echo '<p style="color:red;text-transform:uppercase;">Ce compte n\'existe pas.</p>';
                return FALSE;
            }
            else {
                $this->logged = TRUE;
                $user['logged'] = $this->logged;
                echo 'END of connect function';
                return $user;
            }
        }
        public function disconnect​() {
            // Déconnecte l’utilisateur.
            if ($this->logged) {
                $this->logged = false;
            }
                $this->id = false;
                $this->login = false;
                $this->password = false;
                $this->email = false;
                $this->firstname = false;
                $this->lastname = false;
        }
        public function delete() {
            // Supprime et déconnecte l’utilisateur.
            if (!$this->logged) {
                echo '<p style="color:red;text-transform:uppercase;">Cet utilisateur n\'est pas connecté.</p>';
            }
            else {
                $this->logged = FALSE;
                

                $sql = "DELETE FROM utilisateurs 
                        WHERE id = :id";

                $stmt = $this->pdo->prepare($sql);

                $stmt->execute(array(
                    ':id' => $this->id
                ));

                $this->id = false;
                $this->login = false;
                $this->password = false;
                $this->email = false;
                $this->firstname = false;
                $this->lastname = false;

                echo '<p style="color:green;text-transform:uppercase;">Profil supprimé de la Base de Données.</p>';
                return;
            }
        }
        public function update​($login, $password, $email, $firstname, $lastname) {
            // Modifie les informations de l’utilisateur en base de données.
            $sql = "UPDATE utilisateurs SET 
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
                ':password' => htmlentities($password),
                ':email' => htmlentities($email),
                ':firstname' => htmlentities($firstname),
                ':lastname' => htmlentities($lastname),
                ':id' => $this->id
            ));
        }
        public function isConnected​() {
            // Retourne un booléen permettant de savoir si un utilisateur est connecté ou non.  
            if ($this->logged)
                return TRUE;
            else 
                return FALSE;

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
            $allInfoUser = [
                'id' => $this->id,
                'login' => $this->login,
                'password' => $this->password,
                'email' => $this->email,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'logged' => $this->logged,
            ];
            // DEBUG
            // echo $this->login . ':<br>';
            echo 'END of destruct(): ';
            print_r_pre($allInfoUser, 'RÉSUMÉ: ' . $this->login);
            return;
        }
    }
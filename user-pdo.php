<?php
    
    /*
        Consignes:
        Créez un fichier nommé “user-pdo.php”. Dans ce fichier, créez une classe
        “userpdo” en vous basant sur la classe user que vous avez créé dans le
        job1. Vos requêtes SQL doivent maintenant être faites avec pdo.
    */
    class user {
        private $id = false;
        public $login = false;
        public $email = false;
        public $firstname = false;
        public $lastname = false;

        public function register($login, $email, $firstname, $lastname) {
            // Crée l’utilisateur en base de données. 
            // Retourne un tableau contenant l’ensemble des informations concernant l’utilisateur créé.
            
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
    }
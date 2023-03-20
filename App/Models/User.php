<?php

class Usern extends Connexion {
 /**
     * $conn, variable pour instancier la classe Connexion et pour faire la connexion à la bd avec la fonction connect()
     * 
     * $conn = $this->connect();
     */
    private $email;
    private $pseudo;
    private $password;
    private $confirm_password;
    private $role;
    private $timestamps;

    /**
     * verifyEmailOrName(), pour vérifier si il y a un utilisateur dans la bd ayant déjà ce genre d'email ou de nom d'utilisateur
     */
    public function verifyEmailOrName($email, $user_username) {
        $this->email = $email;
        $this->user_username = $user_username;

        $conn = $this->connect();

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `freek`.users WHERE user_email = ? OR user_username = ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->email, $this->user_username]);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * verifyAccount(), pour vérifier si il y a un utilisateur dans la bd ayant déjà cet email
     */
    public function verifyAccount($email) {
        $this->email = $email;

        $conn = $this->connect();

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `freek`.users WHERE user_email = ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->email]);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * verifyUsername(), pour vérifier si il y a un utilisateur dans la bd ayant déjà cet username
     */
    public function verifyUsername($user_username) {
        $this->user_username = $user_username;

        $conn = $this->connect();

        /**
         * $sql, pour les requêtes vers la base de données
         */
        $sql = "SELECT * FROM `freek`.users WHERE user_username = ?;";

        /**
         * $stmt, pour recupérer la requête préparée
         */
        $stmt = $conn->prepare($sql);
        $stmt->execute([$this->user_username]);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * insertUser(), pour insérer dans la bd des utilisateurs
     */
    public function insertUser($firstname, $lastname, $user_username, $email, $password, $user_image, $wordkey, $user_role, $timestamps) {

      $conn = $this->connect();

      $this->firstname = $firstname;
      $this->lastname = $lastname;
      $this->user_username = $user_username;
      $this->email = $email;
      $this->user_image = $user_image;
      $this->wordkey = $wordkey;
      $this->password = $password;
      $this->user_role = $user_role;
      $this->timestamps = $timestamps;

      /**
       * $sql, pour les requêtes vers la base de données
       */
      $sql = "INSERT INTO `freek`.users VALUES(NULL, :firstname, :lastname, :user_username, :email, :password, :user_image, :wordkey, :user_role, :timesdate)";
      
      /**
       * $stmt, pour recupérer la requête préparée
       */
      $stmt = $conn->prepare($sql);
      $stmt->execute([
         ":firstname" => $this->firstname,
          ":lastname" => $this->lastname,
          ":user_username" => $this->user_username,
          ":email" => $this->email,
          ":user_image" => $this->user_image,
          ":password" => password_hash($this->password, PASSWORD_DEFAULT),
          ":wordkey" => $this->wordkey,
          ":user_role" => $this->user_role,
          ":timesdate" => $this->timestamps
      ]);

  }
}
<?php
require_once('../App/Controllers/crypt.php');

class UserController
{
    // connexion avec la table user
    private $user;
    // déclaration des variables
    private $email;
    private $pseudo;
    private $password;
    private $confirm_password;
    private $role;
    private $timestamps;


    /**
     * register(); pour récupérer les données de l'utilisateur et agit en fonction
     */
    public function verifyInputs()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $this->pseudo = $this->sanitaze($data->pseudo);
        $this->password = $this->sanitaze($data->password);
        $this->confirm_password = $this->sanitaze($data->confirm);
        $this->emptyInputs();
    }

    /**
     * sanitaze(); pour les espacements et les injections de codes
     */
    public function sanitaze($data)
    {
        $reg = preg_replace("/\s+/", " ", $data);
        $reg = preg_replace("/^\s*/", "", $reg);
        $reg = htmlspecialchars($reg);
        $reg = stripslashes($reg);
        $data = $reg;
        return $data;
    }

    /**
     * passWord(), format des mots de passe qu'on accepte
     */
    public function passWord()
    {
        // $crypt = new Crypt();
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $data->password;
        if (preg_match("/^[a-zA-Z-\@]+[\d]+/i", $this->password) && strlen($this->password) >= 8) {
            echo json_encode("password_respect");
        } else {
            // $parent = $crypt->datacrypt('home-controller');
            // $child = $crypt->datacrypt('viewArticles');
            // $url = $parent . "~" . $child;
            // header("Location:/$url");
            // echo json_encode("/$url");
            echo json_encode("password_not_respect");
        }

    }


    /**
     * emptyInputs(), pour vérifiez si un des champs est vide
     */
    public function emptyInputs()
    {
        if (empty($this->email) || empty($this->pseudo) || empty($this->password) || empty($this->confirm_password)) {
            echo json_encode("empty_input");
        } else {
            echo json_encode("valid_input");
        }
    }

    /**
     * verifyPassword(), pour vérifiez si les deux mot de passe que l'utilisateur entre sont corrects
     */
    public function verifyPassword()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->password = $data->password;
        $this->confirm_password = $data->confirm;
        if ($this->password !== $this->confirm_password) {
            echo json_encode("password_different");
        } else {
            echo json_encode("password_identique");
        }
    }

    /**
     * verifyEmail(), pour vérifiez si l'email suis les normes pré-requises
     */
    public function verifyEmail()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $data->email;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode("email_invalid");
        } else {
            echo json_encode("email_valid");
        }
    }

    public function searchUser($email, $pseudo)
    {

    }

    public function register()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        $this->email = $this->sanitaze($data->email);
        $this->pseudo = $this->sanitaze($data->pseudo);
        $this->password = $this->sanitaze($data->password);
        $this->confirm_password = $this->sanitaze($data->confirm);
        $this->role = 1;
        $this->timestamps = date("Y-m-d h:i:s");

        $tableau = $this->searchUser($this->email,  $this->pseudo);
    }
}
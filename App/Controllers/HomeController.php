<?php

class HomeController{
    public function viewHome()
    {
        $crypt = new Crypt();
        // echo $cou = $crypt->datacrypt('Coucou');
        // echo $crypt->datadecrypt($cou);
        require_once("../App/Views/Home.phtml");
    }
    public function viewArticles()
    {
        $crypt = new Crypt();
        // echo $cou = $crypt->datacrypt('Coucou');
        // echo $crypt->datadecrypt($cou);
        require_once("../App/Views/articles.phtml");
    }
    public function viewArticle()
    {
        echo json_encode("Bon fetch réussi");
    }
}

?>
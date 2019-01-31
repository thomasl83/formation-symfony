<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    /**
     * @Route("/hello/{prenom}/age/{age}", name="hello", requirements={"age"="\d+"})
     * @Route("/hello/{prenom}", name="hello_prenom")
     * @Route("/hello", name="hello_base")
     * 
     * Montre la page qui dit bonjour
     *
     * @return void
     */
    public function hello($prenom = "anonyme", $age = 0) {
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age
            ]
        );
    }

    /** 
     * @Route("/", name="homepage")
     */
    public function home() {
        $prenoms = ["Thomas" => 26, "Camille" => 25, "Georges" => 55, "Léo" => 5];

        return $this->render(
            'home.html.twig',
            [
                'title' => "Bonjour à tous !",
                'age' => 12,
                'tableau' => $prenoms
            ]
        );
    }
     
    
}

?>
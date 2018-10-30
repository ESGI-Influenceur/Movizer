<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="movie")
     */
    public function index()
    {
        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();
        //dump($movies);

        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $movies
        ]);
    }
}

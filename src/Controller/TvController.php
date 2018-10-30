<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TvController extends AbstractController
{
    /**
     * @Route("/tv", name="tv")
     */
    public function index()
    {
        $serials = $this->getDoctrine()->getRepository('App:Tv')->findAll();
        //dump($movies);
        return $this->render('tv/index.html.twig', [
            'controller_name' => 'TvController',
            'serials' => $serials
        ]);
    }
}

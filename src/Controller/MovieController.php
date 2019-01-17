<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends Controller
{
    /**
     * @Route("/movie", name="movies")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->get("search")->getData();
            $movies = $this->getDoctrine()->getRepository('App:Movie')->findBy(['title' => $data]);

            /* @var $paginator \Knp\Component\Pager\Paginator */
            $paginator  = $this->get('knp_paginator');

            // Paginate the results of the query
            $appointments = $paginator->paginate(
            // Doctrine Query, not results
                $movies,
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                6
            );

            return $this->render('movie/index.html.twig', [
                'controller_name' => 'MovieController',
                'movies' => $appointments,
                'search' => $data,
                'form' => $form->createView(),
            ]);
        }

        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();


        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator  = $this->get('knp_paginator');

        // Paginate the results of the query
        $appointments = $paginator->paginate(
        // Doctrine Query, not results
            $movies,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            6
        );

        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $appointments,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/movie/{id}", name="show_movie")
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(string $id)
    {

        $movie = $this->getDoctrine()->getRepository('App:Movie')->find($id);
        return $this->render('movie/show.html.twig', [
            'controller_name' => 'MovieController',
            'movie' => $movie,
            'id' => $movie->getId(),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
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

            return $this->render('movie/index.html.twig', [
                'controller_name' => 'MovieController',
                'movies' => $movies,
                'search' => $data,
                'form' => $form->createView(),
            ]);
        }

        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();

        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $movies,
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
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TvController extends Controller
{
    /**
     * @Route("/tv", name="tv")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
            $serials = $this->getDoctrine()->getRepository('App:Tv')->findBy(['name' => $data]);

            /* @var $paginator \Knp\Component\Pager\Paginator */
            $paginator  = $this->get('knp_paginator');

            // Paginate the results of the query
            $appointments = $paginator->paginate(
            // Doctrine Query, not results
                $serials,
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                6
            );

            return $this->render('tv/index.html.twig', [
                'controller_name' => 'TvController',
                'serials' => $appointments,
                'search' => $data,
                'form' => $form->createView(),
            ]);
        }


        $serials = $this->getDoctrine()->getRepository('App:Tv')->findAll();

        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator  = $this->get('knp_paginator');

        // Paginate the results of the query
        $appointments = $paginator->paginate(
        // Doctrine Query, not results
            $serials,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            6
        );


        return $this->render('tv/index.html.twig', [
            'controller_name' => 'TvController',
            'serials' => $appointments,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/tv/{id}", name="show_tv")
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(string $id)
    {
        $serials = $this->getDoctrine()->getRepository('App:Tv')->find($id);
        return $this->render('tv/show.html.twig', [
            'controller_name' => 'TvController',
            'tv' => $serials,
            'id' => $serials->getId(),
        ]);
    }
}

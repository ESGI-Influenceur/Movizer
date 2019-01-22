<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\SearchType;
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
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->get("search")->getData();
            $serials = $this->getDoctrine()->getRepository('App:Tv')->searchTv($data);

            return $this->render('tv/index.html.twig', [
                'controller_name' => 'TvController',
                'serials' => $serials,
                'search' => $data,
                'form' => $form->createView(),
                'pagination' => false
            ]);
        }


        $serials = $this->getDoctrine()->getRepository('App:Tv')->findAll();

        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator  = $this->get('knp_paginator');

        // Paginate the results of the query
        $paginatedSeries = $paginator->paginate(
        // Doctrine Query, not results
            $serials,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            8
        );


        return $this->render('tv/index.html.twig', [
            'controller_name' => 'TvController',
            'serials' => $paginatedSeries,
            'form' => $form->createView(),
            'pagination' => true
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

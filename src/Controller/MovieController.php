<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->get("search")->getData();
            $movies = $this->getDoctrine()->getRepository('App:Movie')->searchMovie($data);

            return $this->render('movie/index.html.twig', [
                'controller_name' => 'MovieController',
                'movies' => $movies,
                'search' => $data,
                'form' => $form->createView(),
                'pagination' => false
            ]);
        }

        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();


        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator  = $this->get('knp_paginator');

        // Paginate the results of the query
        $paginatedMovies = $paginator->paginate(
        // Doctrine Query, not results
            $movies,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            8
        );

        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'movies' => $paginatedMovies,
            'form' => $form->createView(),
            'pagination' => true
        ]);
    }

    /**
     * @Route("/movie/{id}", name="show_movie")
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(string $id)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_movie', ['id' => $id]),
        ]);

        $movie = $this->getDoctrine()->getRepository('App:Movie')->find($id);
        return $this->render('movie/show.html.twig', [
            'controller_name' => 'MovieController',
            'movie' => $movie,
            'id' => $movie->getId(),
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/movie/comment/{id}", name="comment_movie")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handleComment(Request $request, string $id) {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $content = $form->get('content')->getData();
            $em = $this->getDoctrine()->getManager();
            $movie = $this->getDoctrine()->getRepository('App:Movie')->find($id);
            $comment->setContent($content);
            $comment->setCommentMovie($movie);
            $em->persist($comment);
            $em->flush();
        }

        return $this->redirectToRoute('show_movie', ['id' => $id]);
    }
}

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
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_tv', ['id' => $id]),
        ]);

        $serials = $this->getDoctrine()->getRepository('App:Tv')->find($id);

        $tvGenre = $serials->getGenres();
        $suggestions = [];

        if (count($tvGenre) > 0) {
            $random = rand(0, count($tvGenre) - 1);
            $suggestedGenre = $tvGenre[$random];

            $suggestedTvs = $suggestedGenre->getTvs();
            for($i = 0; $i < 5; $i++){
                if($suggestedTvs[$i] == null) {
                    break;
                }
                if(strcmp($serials->getName(), $suggestedTvs[$i]->getName()) !== 0){
                    array_push($suggestions, $suggestedTvs[$i]);
                }
            }
        }

        return $this->render('tv/show.html.twig', [
            'controller_name' => 'TvController',
            'tv' => $serials,
            'id' => $serials->getId(),
            'commentForm' => $form->createView(),
            'suggestions' => $suggestions,
        ]);
    }

    /**
     * @Route("/tv/comment/{id}", name="comment_tv")
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
            $tv = $this->getDoctrine()->getRepository('App:Tv')->find($id);
            $comment->setContent($content);
            $comment->setCommentMovie($tv);
            $em->persist($comment);
            $em->flush();
        }

        return $this->redirectToRoute('show_tv', ['id' => $id]);
    }

    /**
 * @Route("/tv/favoris/add/{id}", name="favoris_tv")
 * @param string $id
 * @return \Symfony\Component\HttpFoundation\RedirectResponse
 */
    public function handleFavoris(string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $tv = $this->getDoctrine()->getRepository('App:Tv')->find($id);

        $tv->addFavoriteUser($user);
        $em->persist($tv);
        $em->flush();

        return $this->redirectToRoute('show_tv', ['id' => $id]);
    }

    /**
     * @Route("/tv/favoris/delete/{id}", name="remove_favoris_tv")
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handleRemoveFavoris(string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $tv = $this->getDoctrine()->getRepository('App:Tv')->find($id);

        $tv->removeFavoriteUser($user);
        $em->persist($tv);
        $em->flush();

        return $this->redirectToRoute('show_tv', ['id' => $id]);
    }
}

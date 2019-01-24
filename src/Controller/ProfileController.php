<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request)
    {
        return $this->render('bundles/FOSUserBundle/Profile/show.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/profile/delete", name="delete")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAccount(Request $request)
    {

        $session = $this->get('session');
        $session = new Session();
        $session->invalidate();

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/profile/tv/delete/{id}", name="deleteTv")
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteFavoriteTv(string $id)
    {

        $em = $this->getDoctrine()->getManager();
        $serie = $this->getDoctrine()->getRepository('App:Tv')->find($id);
        $user = $this->getUser();

        $serie->removeFavoriteUser($user);
        $em->persist($serie);
        $em->flush();

        return $this->render('bundles/FOSUserBundle/Profile/show.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/profile/movie/delete/{id}", name="deleteMovie")
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteFavoriteMovie(string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $this->getDoctrine()->getRepository('App:Movie')->find($id);
        $user = $this->getUser();

        $movie->removeFavoriteUser($user);
        $em->persist($movie);
        $em->flush();

        return $this->render('bundles/FOSUserBundle/Profile/show.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
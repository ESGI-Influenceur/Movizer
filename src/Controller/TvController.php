<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TvController extends AbstractController
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

            return $this->render('tv/index.html.twig', [
                'controller_name' => 'TvController',
                'serials' => $serials,
                'search' => $data,
                'form' => $form->createView(),
            ]);
        }

        $serials = $this->getDoctrine()->getRepository('App:Tv')->findAll();

        return $this->render('tv/index.html.twig', [
            'controller_name' => 'TvController',
            'serials' => $serials,
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

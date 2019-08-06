<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artist;
use App\Form\ArtistType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        if ($this->getUser()) {
            return $this->artist();;
        } else {
            return $this->redirectToRoute('app_login');
        }
        
    }

    /**
     * @Route("/artist/{page_number}", defaults={"page_number"=1}, name="artist")
     */
    public function artist($page_number=1) {

        $repo = $this->getDoctrine()->getRepository(Artist::class);
        $page = $repo->getAll($page_number);

        $totalReturned = $page->getIterator()->count();

        $total = $page->count();
        $iterator = $page->getIterator();

        $limit = 5;
        $maxPages = ceil($total / $limit);

        
        return $this->render(
            'list_artist.html.twig',
            array(
                'title' => 'Artist',
                'maxPages' => $maxPages,
                'artists' => $page,
                'thisPage' => $page_number,
                'limit' => $limit
            )
        );
    }
    /**
     * @Route("/artist_create", name="artist_create")
     */
    public function artistCreate(Request $request)
    {

        $form = $this->createForm(ArtistType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artist_tmp = $form->getData();  
            $em = $this->getDoctrine()->getmanager();
            $em->persist($artist_tmp);
            $em->flush();
            $this->addFlash(
                'notice',
                'Artist created!'
            );
            return $this->redirectToRoute('artist');
        }

        return $this->render(
            'create.html.twig',
            array(
                'title' => 'Create Artist',
                'form' => $form->createView()
            )
        );
    }
    /**
     * @Route("/artist_update/{id}", name="artist_cupdate")
     */
    public function artistUpdate(Int $id, Request $request)
    {
        $artist = $this->getDoctrine()->getRepository(Artist::class)->find($id);
        $form = $this->createForm(ArtistType::class);
        $form->setData($artist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artist_tmp = $form->getData();  
            $em = $this->getDoctrine()->getmanager();
            $em->persist($artist_tmp);
            $em->flush();
            $this->addFlash(
                'notice',
                'Artist Updated!'
            );
            return $this->redirectToRoute('artist');
        }

        return $this->render(
            'create.html.twig',
            array(
                'title' => 'Update Artist',
                'form' => $form->createView()
            )
        );
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artist;
use App\Entity\Album;
use App\Entity\User;
use App\Form\ArtistType;
use App\Form\AlbumType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class UdemyController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        // usually you'll want to make sure the user is authenticated first
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
    
        // Call whatever methods you've added to your User class
        // For example, if you added a getFirstName() method, you can use that.
        return new Response('Well hi there '.$user->getUsername());

        //return $this->artist();;
    }

    /**
     * @Route("/artist", name="artist")
     */
    public function artist() {

        $artist = $this->getDoctrine()->getRepository(Artist::class)->findAll();
       // var_dump($artist->getName());
        return new Response('Artist <pre>'.print_r($artist));
    }
    /**
     * @Route("/artist/create", name="artist_create")
     */
    public function artistCreate(Request $request)
    {

        $form = $this->createForm(ArtistType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()) {
            $artist_tmp = $form->getData();  
            $em = $this->getDoctrine()->getmanager();
            $em->persist($artist_tmp);
            $em->flush();
        }

        return $this->render(
            'create_artist.html.twig',
            array(
                'title' => 'Create Artists',
                'form' => $form->createView()
            )
        );
    }
    /**
     * @Route("/artist/update/{id}", name="artist_cupdate")
     */
    public function artistUpdate(Int $id, Request $request)
    {
        $artist = $this->getDoctrine()->getRepository(Artist::class)->find($id);
        $form = $this->createForm(ArtistType::class);
        $form->setData($artist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()) {
            $artist_tmp = $form->getData();  
            $em = $this->getDoctrine()->getmanager();
            $em->persist($artist_tmp);
            $em->flush();
        }

        return $this->render(
            'create_artist.html.twig',
            array(
                'title' => 'Update Artists',
                'form' => $form->createView()
            )
        );
    }
    /**
     * @Route("/album", name="album")
     */
    public function album() {

        $album = $this->getDoctrine()->getRepository(Album::class)->findAll();
       // var_dump($artist->getName());
        return new Response('album <pre>'.print_r($album));
    }
    /**
     * @Route("/album/create", name="aalbum_create")
     */
    public function albumCreate(Request $request)
    {

        $form = $this->createForm(AlbumType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()) {
            $album_tmp = $form->getData();  
            $em = $this->getDoctrine()->getmanager();
            $em->persist($album_tmp);
            $em->flush();
        }

        return $this->render(
            'create_artist.html.twig',
            array(
                'title' => 'Create Album',
                'form' => $form->createView()
            )
        );
    }
    /**
     * @Route("/album/update/{id}", name="album_update")
     */
    public function albumUpdate(Int $id, Request $request)
    {
        $album = $this->getDoctrine()->getRepository(Album::class)->find($id);
        $form = $this->createForm(AlbumType::class);
        $form->setData($album);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isvalid()) {
            $album_tmp = $form->getData();  
            $em = $this->getDoctrine()->getmanager();
            $em->persist($album_tmp);
            $em->flush();
        }

        return $this->render(
            'create_artist.html.twig',
            array(
                'title' => 'Update Album',
                'form' => $form->createView()
            )
        );
    }
}

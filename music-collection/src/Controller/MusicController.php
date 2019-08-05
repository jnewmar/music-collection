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

class MusicController extends AbstractController
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
        //return new Response('Well hi there '.$user->getUsername());

        return $this->artist();;
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
    /**
     * @Route("/album/{page_number}", defaults={"page_number"=1}, name="album")
     */
    public function album($page_number) {

        $repo = $this->getDoctrine()->getRepository(Album::class);
        $page = $repo->getAll($page_number);

        $totalReturned = $page->getIterator()->count();

        $total = $page->count();
        $iterator = $page->getIterator();

        $limit = 5;
        $maxPages = ceil($total / $limit);

        
        return $this->render(
            'list_album.html.twig',
            array(
                'title' => 'Album',
                'maxPages' => $maxPages,
                'albums' => $page,
                'thisPage' => $page_number,
                'limit' => $limit
            )
        );
    }
    /**
     * @Route("/album_create", name="aalbum_create")
     */
    public function albumCreate(Request $request)
    {

        $form = $this->createForm(AlbumType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album_tmp = $form->getData();  
            $em = $this->getDoctrine()->getmanager();
            $em->persist($album_tmp);
            $em->flush();
            $this->addFlash(
                'notice',
                'Album Created!'
            );
            return $this->redirectToRoute('album');
        }

        return $this->render(
            'create.html.twig',
            array(
                'title' => 'Create Album',
                'form' => $form->createView()
            )
        );
    }
    /**
     * @Route("/album_update/{id}", name="album_update")
     */
    public function albumUpdate(Int $id, Request $request)
    {
        $album = $this->getDoctrine()->getRepository(Album::class)->find($id);
        $form = $this->createForm(AlbumType::class);
        $form->setData($album);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album_tmp = $form->getData();  
            $em = $this->getDoctrine()->getmanager();
            $em->persist($album_tmp);
            $em->flush();
            $this->addFlash(
                'notice',
                'Album Updated!'
            );
            return $this->redirectToRoute('album');
        }

        return $this->render(
            'create.html.twig',
            array(
                'title' => 'Update Album',
                'form' => $form->createView()
            )
        );
    }
}

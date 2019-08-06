<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Album;
use App\Form\AlbumType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AlbumController extends AbstractController
{
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

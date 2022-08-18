<?php

namespace App\Controller;

use App\Entity\ServerList;
use App\Form\ServerListType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServerListController extends AbstractController
{
    /**
     * @Route("/server/list/upload", name="app_server_list_upload")
     */
    public function upload(Request $request, SluggerInterface $slugger): Response
    {
        //TODO: handle deletion of old file

        $form = $this->createForm(ServerListType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serverListFile = $form->get('fileName')->getData();

            $originalFilename = pathinfo($serverListFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$serverListFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $serverListFile->move(
                    $this->getParameter('server_list_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                //TODO: handle exception if something happens during file upload
            }

            ServerList::setFileName($newFilename);

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('server_list/upload.html.twig', [
            'form' => $form,
        ]);
    }
}

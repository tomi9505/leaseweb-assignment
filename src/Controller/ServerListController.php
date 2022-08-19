<?php

namespace App\Controller;

use App\Entity\ServerList;
use App\Form\ServerListType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServerListController extends AbstractController
{
    /**
     * @Route("/server/list", name="app_server_list")
     */
    public function index(): Response
    {
        return $this->render('server_list/index.html.twig', [
            'fileName' => ServerList::getFileName()
        ]);
    }

    /**
     * @Route("/server/list/upload", name="app_server_list_upload")
     */
    public function upload(Request $request, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $serverList = new ServerList();
        $form = $this->createForm(ServerListType::class, $serverList);
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

                $serverList->setFileName($newFilename);

                $entityManager = $doctrine->getManager();

                // persist entity in database
                $entityManager->persist($serverList);
                $entityManager->flush();

                $this->addFlash('success', 'New server list file uploaded!');
                return $this->redirectToRoute('app_server_list_upload');
            } catch (FileException $e) {
                $this->addFlash('error', 'An error occurred while uploading new server list file!');
            }
        }

        return $this->renderForm('server_list/upload.html.twig', [
            'form' => $form,
        ]);
    }
}

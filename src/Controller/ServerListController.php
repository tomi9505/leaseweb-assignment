<?php

namespace App\Controller;

use App\Entity\ServerItem;
use App\Entity\ServerList;
use App\Form\ServerListType;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServerListController extends AbstractController
{
    /**
     * @Route("/server/list", name="app_server_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $latestServerListFileName = null;
        try {
            $latestServerListFileName = $doctrine->getRepository(ServerList::class)
                ->findOneByCreatedAtLatest()
                ->getFileName();
        } catch (NoResultException $e) {
            $this->addFlash('info', 'Currently, the server list file is not set so please upload one.');
        }

        return $this->render('server_list/index.html.twig', [
            'fileName' => $latestServerListFileName
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
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $serverListFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $serverListFile->move(
                    $this->getParameter('server_list_directory'),
                    $newFilename
                );

                $serverList->setFileName($newFilename);

                // persist entity in database
                $entityManager = $doctrine->getManager();
                $entityManager->getRepository(ServerList::class)->add($serverList, true);

                // delete all ServerItem entities
                $entityManager->getRepository(ServerItem::class)->removeAll();

                //TODO parse data from uploaded Excel
                $this->parseUploadedExcel($this->getParameter('server_list_directory'), $newFilename);

                //TODO insert parsed data into server_item table0

                $this->addFlash('success', 'New server list file uploaded!');
                return $this->redirectToRoute('app_server_list');
            } catch (Exception $e) {
                $this->addFlash('error', 'An error occurred while uploading new server list file!');
            }
        }

        return $this->renderForm('server_list/upload.html.twig', [
            'form' => $form,
        ]);
    }


    /* Helper functions */
    /**
     * @throws Exception
     */
    private function parseUploadedExcel(string $filePath, string $fileName)
    {
        $spreadsheet = IOFactory::load($filePath . $fileName);
        $headerRow = $spreadsheet->getActiveSheet()->removeRow(1);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }
}

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

                // Persist entity in database
                $entityManager = $doctrine->getManager();
                $entityManager->getRepository(ServerList::class)->add($serverList, true);

                // Delete all ServerItem entities
                $entityManager->getRepository(ServerItem::class)->removeAll();

                $this->parseUploadedExcel($doctrine, $this->getParameter('server_list_directory'), $newFilename);

                // Persist newly created ServerItems in the DB
                $entityManager->flush();

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
    private function parseUploadedExcel(ManagerRegistry $doctrine, string $filePath, string $fileName)
    {
        $repository = $doctrine->getManager()->getRepository(ServerItem::class);

        // Open Excel sheet
        $spreadsheet = IOFactory::load($filePath . DIRECTORY_SEPARATOR . $fileName);
        $spreadsheet->getActiveSheet()->removeRow(1);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Add each row as a new ServerItem
        foreach ($sheetData as $row) {
            $serverItem = new ServerItem();
            // Model
            $serverItem->setModel($row['A']);
            // RAM
            if (preg_match('/^(\d+)GB(.+)$/', $row['B'], $matches) && count($matches) == 3) {
                $serverItem->setRam(intval($matches[1]));
                $serverItem->setRamType($matches[2]);
            } else {
                throw new Exception("An error occurred during parsing the RAM value of '{$row['B']}'");
            }
            // HDD
            if (preg_match('/^(\d+)x(\d+)([GT]B)(\D*)\d?$/', $row['C'], $matches) && count($matches) == 5) {
                $hddCapacity = intval($matches[2]);
                if ($matches[3] == 'TB') {
                    $hddCapacity = $hddCapacity * 1024;
                }
                $serverItem->setHddCount(intval($matches[1]));
                $serverItem->setHddStorageCapacity($hddCapacity);
                $serverItem->setHddType($matches[4]);
            } else {
                throw new Exception("An error occurred during parsing the HDD value of '{$row['C']}'");
            }
            // Location
            $serverItem->setLocation($row['D']);
            // Price
            if (preg_match('/^(\D+)(\d+\.\d+)$/', $row['E'], $matches) && count($matches) == 3) {
                $serverItem->setPrice(floatval($matches[2]));
                $serverItem->setCurrency($matches[1]);
            } else {
                throw new Exception("An error occurred during parsing the Price value of '{$row['D']}'");
            }

            $repository->add($serverItem, false);
        }
    }
}

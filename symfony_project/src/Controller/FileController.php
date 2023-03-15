<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Project;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    #[Route('/addfile/{id}', name: 'app_add_file')]
    public function add(Request $request, EntityManagerInterface $entityManagerInterface, ManagerRegistry $doctrine, int $id): Response
    {
        $file = new File();
        $project = $doctrine->getRepository(Project::class)->find($id);
        $current_user = $this->getUser();


        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    }
}

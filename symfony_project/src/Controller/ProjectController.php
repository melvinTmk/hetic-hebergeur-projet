<?php

namespace App\Controller;

use App\Entity\Project;

use App\Repository\ProjectRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    #[Route('/project/{id}', name: 'app_show_project')]
    public function show(ProjectRepository $projectRepository, ManagerRegistry $doctrine, int $id): Response
    {
        $project = $doctrine->getRepository(Project::class)->find($id);
        $files = $project->getFiles();
        
        return $this->render('project/project.html.twig', [
            'controller_name' => 'ProjectController',
            'project' => $project,
            'files' => $files,
        ]);
    }
}

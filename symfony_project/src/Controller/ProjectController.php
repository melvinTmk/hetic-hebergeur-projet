<?php

namespace App\Controller;

use App\Entity\Project;

use App\Repository\ProjectRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\File;

use Doctrine\Persistence\ManagerRegistry;

class ProjectController extends AbstractController
{
    #[Route('/project/{id}', name: 'app_project_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $project = $doctrine->getRepository(Project::class)->find($id);
        

        if (!$project) {
            throw $this->createNotFoundException(
                'No project found for id '.$id
            );
        }
        
        $files = $doctrine->getRepository(File::class)->findById($id);

        //Change the route to your twig file to show a specific Project
        return $this->render('base.html.twig', ['project' => $project, 'files' => $files]);

    }

    //entity manager interface
    #[Route('/', name: 'app_project_show_all')]
    public function show_all(ManagerRegistry $doctrine): Response
    {
        $projects = $doctrine->getRepository(Project::class)->findAll();
        if (!$projects) {
            throw $this->createNotFoundException(
                'No projects found'
            );
        }

        return $this->render('project/index.html.twig', ['projects' => $projects]);

       
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

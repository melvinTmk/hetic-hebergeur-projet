<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\File;

use App\Command\CreateDatabaseCommand;

use App\Repository\UserRepository;

use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProjectType;
use Doctrine\Persistence\ManagerRegistry;

class ProjectController extends AbstractController
{
    #[Route('/project/{id}', name: 'app_show_project')]
    public function show(ProjectRepository $projectRepository, ManagerRegistry $doctrine, 
                        EntityManagerInterface $entityManagerInterface, Request $request, int $id): Response
    {
        $project = $doctrine->getRepository(Project::class)->find($id);
        $files = $project->getFiles();


        $form = $this->createFormBuilder()
            ->add('file', FileType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            //var_dump($file->getSize());
            //die;
            $newfile = new File();
            $newfile->setName($file->getClientOriginalName());
            $newfile->setUrl($file->getPath());
            $newfile->setProject($project);
            $newfile->setSize($file->getSize());
            $newfile->setCreatedAt(new \DateTime());
            

            $entityManagerInterface->persist($newfile);
            $entityManagerInterface->flush();

            return $this->render('project/project.html.twig', [
                'controller_name' => 'ProjectController',
                'project' => $project,
                'files' => $files,
                'form' => $form->createView()
            ]);
        }

        
        return $this->render('project/project.html.twig', [
            'project' => $project,
            'files' => $files,
            'form' => $form->createView()
        ]);
    }

    #[Route('/', name: 'app_project_show_all')]
    public function show_all(ManagerRegistry $doctrine): Response
    {
        $current_user = $this->getUser();
        $projects = $doctrine->getRepository(Project::class)->findAll();

        return $this->render('project/index.html.twig', [
            'user' => $current_user,
            'projects' => $projects,
        ]);
    }

    #[Route('/projects', name: 'app_project_user')]
    public function show_user_project(ManagerRegistry $doctrine): Response
    {
        $current_user = $this->getUser();

        $projects = $doctrine->getRepository(Project::class)->findByUser($current_user);
        if (!$projects) {
            throw $this->createNotFoundException(
                'No projects found'
            );
        }

        return $this->render('project/index.html.twig', [
            'user' => $current_user,
            'projects' => $projects,
        ]);
    }

    #[Route('/add_project', name: 'app_add_project')]
    public function add_project(Request $request, EntityManagerInterface $entityManagerInterface, ManagerRegistry $doctrine, UserRepository $userRepository) { 
        $project = new Project();
        $current_user = $this->getUser();

        $form = $this->createFormBuilder($project)
        ->add("name", TextType::class,[
            "label"=> "Nom",
            "attr"=>[
                'placeholder' => 'Exemple : little friend',
                "class"=> "project-title"
            ]
        ])
        ->add("submit", SubmitType::class, [
            "label"=> "Ajouter",
            "attr"=>[
                "class"=> "project-submit"
            ]
        ])
        ->getForm();
        
        $project->setOwner($current_user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($project);
            $entityManagerInterface->flush();

            $projects = $doctrine->getRepository(Project::class)->findByUser($current_user);
            if (!$projects) {
                throw $this->createNotFoundException(
                    'No projects found'
                );
            }

            CreateDatabaseCommand::execute();

            return $this->render('project/index.html.twig', [
                'user' => $current_user,
                'projects' => $projects,
            ]);
        }

        return $this->render('project/addproject.html.twig', [
            "form" => $form->createView()
        ]);
    }
}



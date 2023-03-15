<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;



class ProjectController extends AbstractController  
{
    #[Route('/project', name: 'app_project')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer tous les projets de l'utilisateur
        $projects = $doctrine
            ->getRepository(Project::class)
            ->findBy(['owner' => $user]);

        // Afficher la liste des projets
        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

     /**
     * @Route("/project/create", name="create_project")
     */
    public function create(Request $request): Response
    {
        // On crée une nouvelle instance de Project
        $project = new Project();
    
        // On récupère l'utilisateur connecté
        $user = $this->getUser();
    
        // On lie le projet à l'utilisateur connecté
        $project->setOwner($user);
    
        // On récupère le formulaire de création de projet
        $form = $this->createForm(ProjectType::class, $project);
    
        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On enregistre le nouveau projet en base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
    
            // On redirige l'utilisateur vers la page de liste des projets
            return $this->redirectToRoute('app_project');
        }
    
        // On affiche le formulaire de création de projet
        return $this->render('project/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

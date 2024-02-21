<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Repository\ReponseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;

class ReponseController extends AbstractController
{
    #[Route('/reponse', name: 'app_reponse')]
    public function index(): Response
    {
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }
    #[Route('/addreponse', name: 'add_Rep')]
    public function addRep(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();
        $reclamationId = $request->query->get('id');
        $reclamation = $em->getRepository(Reclamation::class)->find($reclamationId);
    
        if (!$reclamation) {
            throw $this->createNotFoundException('Réclamation non trouvée.');
        }
    
        $reponse = new Reponse();
        $reponse->setReclamation($reclamation);
    
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reponse);
            $em->flush();
    
            
            $reclamation->setEtat(1);
            $em->flush();
    
            return $this->redirectToRoute('listback_Reclamation');
        }
    
        return $this->renderForm('reponse/addrep.html.twig', [
            'form' => $form,
            'reclamation' => $reclamation,
        ]);
    }
    #[Route('/editrep/{id}', name: 'rep_edit')]
    public function editrep(Request $request, ManagerRegistry $manager, $id, ReponseRepository $reprepository): Response
    {
        $em = $manager->getManager();

        $rep = $repepository->find($id);
        $form = $this->createForm(ReponseType::class, $rep);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($rep);
            $em->flush();
            return $this->redirectToRoute('listback_Reclamation');
        }
        return $this->renderForm('reponse/editrep.html.twig', ['form' => $form]);

    }
}


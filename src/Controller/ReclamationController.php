<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ReclamationController extends AbstractController
{
    #[Route('/index', name: 'app_reclamation')]
    public function index(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();

        $reclam = new Reclamation();

        $form = $this->createForm(ReclamationType::class, $reclam);
        $form->handleRequest($request);
        if (($form->isSubmitted() && $form->isValid()))
        {
            $reclam->setEtat(0);
            $em->persist($reclam);
            $em->flush();

            return $this->redirectToRoute('add_Reclam');
        
    }
    return $this->render('reclamation/index.html.twig', ['form' => $form->createView(),]);
}
    #[Route('/showReclamation/{name}', name: 'show_Reclamation')]
 public function showReclamation($name)
    {
        return $this->render('reclamation/showReclamation.html.twig', [
            'name' => $name,
        ]);
    }
   
    
    #[Route('/reclamation/{id}', name: 'Reclamtion_details')]
    public function ReclamationDetails($id)
    {
        $reclam = null;
        
        foreach ($this->reclamations as $reclamData) {
            if ($reclamData['id'] == $id) {
                $reclam = $reclamData;
            };
        };
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclam,
            'id' => $id
        ]);
    }
   
    #[Route('/addReclam', name: 'add_Reclam')]
    public function addReclam(ManagerRegistry $manager, Request $request): Response
    {
        $em = $manager->getManager();

        $reclam = new Reclamation();

        $form = $this->createForm(ReclamationType::class, $reclam);
        $form->handleRequest($request);
        if (($form->isSubmitted() && $form->isValid()))
        {
            $reclam->setEtat(0);
            $em->persist($reclam);
            $em->flush();

            return $this->redirectToRoute('add_Reclam');
        }
        return $this->renderForm('reclamation/index.html.twig', ['form' => $form]);
    }
    #[Route('/list', name: 'list_Reclamation')]
    public function listReclamtion(ReclamationRepository $reclamrepository): Response
    {
        return $this->render('reclamation\list.html.twig', [
            'reclamations' => $reclamrepository->findAll(),
        ]);
    }
    #[Route('/editreclamation/{id}', name: 'reclamation_edit')]
    public function editreclamation(Request $request, ManagerRegistry $manager, $id, ReclamationRepository $reclamrepository): Response
    {
        $em = $manager->getManager();

        $reclam = $reclamrepository->find($id);
        $form = $this->createForm(ReclamationType::class, $reclam);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($reclam);
            $em->flush();
            return $this->redirectToRoute('list_Reclamation');
        }
        return $this->renderForm('reclamation/editreclam.html.twig', ['form' => $form]);

    }
    #[Route('/deleteReclamation/{id}', name: 'Reclamation_delete')]
    public function deleteReclam(Request $request, $id, ManagerRegistry $manager, ReclamationRepository $reclamrepository): Response
    {
        $em = $manager->getManager();
        $reclam = $reclamrepository->find($id);
        
            $em->remove($reclam);
            $em->flush();

        return $this->render('reclamation/delete.html.twig');
    }
    // DQL: Question 3
    #[Route('/RechercheDQL', name:'Search')]
    function RechercheDQL(ReclamationRepository $repo,Request $request){
        $min=$request->get('min');
        $max=$request->get('max');
        $reclam=$repo->SearchreclamationDQL($min,$max);
        return $this->render('reclamation/listReclamation.html.twig', [
            'reclamations' => $reclam,
        ]);
    }
    //DQL: Question 4
    #[Route('/DeleteDQL', name:'DD')]
    function DeleteDQL(AuthorRepository $repo){
        $repo->DeleteAuthor();
        return $this->redirectToRoute('list_Reclamation');
    }

    //Query Builder: Question 1              
    //http://localhost:8000/author/list/OrderByEmail
    #[Route('/reclamation/list/OrderBytype', name: 'app_reclamation_list_ordered', methods: ['GET'])]
    public function listAuthorOrderByEmail(ReclalmationRepository $reclamRepository): Response
    {
        return $this->render('reclamation/orderedList.html.twig', [
            'reclamations' => $reclamRepository->showAllReclamationOrderBytype(),
        ]);
    }
    #[Route('/listback', name: 'listback_Reclamation')]
    public function listbackReclamtion(ReclamationRepository $reclamrepository): Response
    {
        return $this->render('reponse\listback.html.twig', [
            'reclamations' => $reclamrepository->findAll(),
        ]);
    }
    #[Route('/showReponse/{id}', name: 'show_Reponse')]
    public function showReponse($id)
       {
      
           return $this->render('reponse/showReponse.html.twig', [
               'id' => $id,
           ]);

       }
}

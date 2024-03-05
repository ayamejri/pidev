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
use Twilio\Rest\Client;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


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
            
$accountSid = 'AC15ea41bd50c111744636d34f048787b2';
$authToken = '3ad2d5851a7db94610f4578ef7fa543e';
$client = new Client($accountSid, $authToken);

$message = $client->messages->create(
    '+21621182685', 
    [
        'from' => '+15072463455', 
        'body' => 'nouvelle reclamation de la par de  ' . $form->get('name')->getData(). '  il/elle dit:' . $form->get('description')->getData(),
    ]
);

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
    #[Route('/reclamation/lis', name: 'app_reclamation_list_ordered', methods: ['GET'])]
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
       #[Route('/generate-pdf', name: 'generate_pdf')]
       public function pdf(ReclamationRepository $ReclamationRepository)
       {
           // Configure Dompdf according to your needs
           $pdfOptions = new Options();
           $pdfOptions->set('defaultFont', 'Arial');
       
           // Instantiate Dompdf with our options
           $dompdf = new Dompdf($pdfOptions);
           $statistics = $this->calculateStatistics($ReclamationRepository->findAll());
           // Retrieve the HTML generated in our twig file
           $html = $this->renderView('reponse/pdf_template.html.twig', [
               'reclamations' => $ReclamationRepository->findAll(),
               'statistics' => $statistics,
           ]);
       
           // Load HTML to Dompdf
           $dompdf->loadHtml($html);
       
           // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
           $dompdf->setPaper('A4', 'portrait');
       
           // Render the HTML as PDF
           $dompdf->render();
       
           // Get the generated PDF content
           $output = $dompdf->output();
       
           // Create a Symfony Response with the PDF content
           $response = new Response($output);
       
           // Set the response headers
           $response->headers->set('Content-Type', 'application/pdf');
           $response->headers->set('Content-Disposition', 'inline; filename="ListeDesreclamations.pdf"');
       
           return $response;
       }
 private function calculateStatistics($reclamations)
{
    $statistics = [];

    foreach ($reclamations as $reclamation) {
        $type = $reclamation->getType();
        $statistics[$type] = isset($statistics[$type]) ? $statistics[$type] + 1 : 1;
    }

    return $statistics;
}
}

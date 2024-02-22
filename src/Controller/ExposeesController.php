<?php

namespace App\Controller;

use App\Form\ExposeesType;
use App\Repository\ExposeesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Exposees;

#[Route('/exposees')]
class ExposeesController extends AbstractController
{
    
    #[Route('/', name: 'app_exposees_index', methods: ['GET'])]
    public function index(ExposeesRepository $exposeesRepository): Response
    {
        return $this->render('exposees/index.html.twig', [
            'exposees' => $exposeesRepository->findAll(),
        ]);
    }
    #[Route('/front', name: 'app_exposee_Front_page', methods: ['GET'])]
    public function Front_page(ExposeesRepository $exposeeRepository): Response
    {
        return $this->render('exposees/Front_page.html.twig', [
            'exposees' => $exposeeRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_exposees_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exposee = new Exposees();
        $form = $this->createForm(ExposeesType::class, $exposee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $exposee->getImageExposees();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'), $filename);
            $exposee->setImageExposees($filename);

            $entityManager->persist($exposee);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_exposees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exposees/new.html.twig', [
            'exposee' => $exposee,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_exposees_show', methods: ['GET'])]
    public function show(Exposees $exposee): Response
    {
        return $this->render('exposees/show.html.twig', [
            'exposee' => $exposee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exposees_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exposees $exposee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExposeesType::class, $exposee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $exposee->getImageExposees();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'), $filename);
            $exposee->setImageExposees($filename);
            
            $entityManager->flush();
            return $this->redirectToRoute('app_exposees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exposees/edit.html.twig', [
            'exposee' => $exposee,
            'form' => $form->createView(),
        ]);
    }
#[Route('/{id}', name: 'app_exposees_delete', methods: ['POST'])]
public function delete(Request $request, Exposees $exposee, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$exposee->getId(), $request->request->get('_token'))) {
        $entityManager->remove($exposee);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_exposees_index', [], Response::HTTP_SEE_OTHER);
}

}

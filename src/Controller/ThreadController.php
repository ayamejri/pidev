<?php

namespace App\Controller;

use App\Entity\Thread;
use App\Form\ThreadType;
use App\Repository\ThreadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/thread')]
class ThreadController extends AbstractController
{
    #[Route('/', name: 'app_thread_index', methods: ['GET'])]
    public function index(ThreadRepository $threadRepository, Request $request): Response
    {
        $keyword = $request->query->get('keyword');
        $sortBy = $request->query->get('sortBy');

        if ($keyword) {
            $threads = $threadRepository->searchByKeyword($keyword);
        } elseif ($sortBy === 'createdAtDescending') {
            $threads = $threadRepository->sortByCreatedAtDescending();
        } else {
            $threads = $threadRepository->findAll();
        }
        

        return $this->render('thread/index.html.twig', [
            'threads' => $threads,
        ]);
    }
    #[Route('/threadf', name: 'app_thread_indexf', methods: ['GET'])]
    public function indexf(ThreadRepository $threadRepository, Request $request): Response
    {
        $keyword = $request->query->get('keyword');
        $sortBy = $request->query->get('sortBy');

        if ($keyword) {
            $threads = $threadRepository->searchByKeyword($keyword);
        } elseif ($sortBy === 'createdAtDescending') {
            $threads = $threadRepository->sortByCreatedAtDescending();
        } else {
            $threads = $threadRepository->findAll();
        }

        return $this->render('thread/indexf.html.twig', [
            'threads' => $threads,
        ]);
    }

    #[Route('/new', name: 'app_thread_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $thread = new Thread();
        $form = $this->createForm(ThreadType::class, $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($thread);
            $entityManager->flush();

            return $this->redirectToRoute('app_thread_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('thread/new.html.twig', [
            'thread' => $thread,
            'form' => $form,
        ]);
    }
    #[Route('threadf/newf', name: 'app_thread_newf', methods: ['GET', 'POST'])]
    public function newf(Request $request, EntityManagerInterface $entityManager): Response
    {
        $thread = new Thread();
        $form = $this->createForm(ThreadType::class, $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($thread);
            $entityManager->flush();

            return $this->redirectToRoute('app_thread_indexf', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('thread/newf.html.twig', [
            'thread' => $thread,
            'form' => $form,
        ]);
    }

    #[Route('/threadf/{id}', name: 'app_thread_showf', methods: ['GET'])]
    public function showf(Thread $thread, ThreadRepository $threadRepository): Response
    {
        // Fetch the thread entity
        $thread = $threadRepository->find($thread->getId());
        
        // Fetch the related posts for the thread
        $posts = $thread->getRelation();

        return $this->render('thread/showf.html.twig', [
            'thread' => $thread,
            'posts' => $posts,
        ]);
    }
    #[Route('/{id}', name: 'app_thread_show', methods: ['GET'])]
    public function show(Thread $thread, ThreadRepository $threadRepository): Response
    {
        // Fetch the thread entity
        $thread = $threadRepository->find($thread->getId());
        
        // Fetch the related posts for the thread
        $posts = $thread->getRelation();

        return $this->render('thread/show.html.twig', [
            'thread' => $thread,
            'posts' => $posts,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_thread_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Thread $thread, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThreadType::class, $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_thread_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('thread/edit.html.twig', [
            'thread' => $thread,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/editf', name: 'app_thread_editf', methods: ['GET', 'POST'])]
    public function editf(Request $request, Thread $thread, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThreadType::class, $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_thread_indexf', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('thread/editf.html.twig', [
            'thread' => $thread,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_thread_delete', methods: ['POST'])]
public function delete(Request $request, Thread $thread, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$thread->getId(), $request->request->get('_token'))) {
        // Fetch related posts
        $posts = $thread->getRelation();
        
        // Delete each related post
        foreach ($posts as $post) {
            $entityManager->remove($post);
        }

        // Now delete the thread
        $entityManager->remove($thread);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_thread_index', [], Response::HTTP_SEE_OTHER);
}
#[Route('/threadf/{id}', name: 'app_thread_deletef', methods: ['POST'])]
public function deletef(Request $request, Thread $thread, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$thread->getId(), $request->request->get('_token'))) {
        // Fetch related posts
        $posts = $thread->getRelation();
        
        // Delete each related post
        foreach ($posts as $post) {
            $entityManager->remove($post);
        }

        // Now delete the thread
        $entityManager->remove($thread);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_thread_indexf', [], Response::HTTP_SEE_OTHER);
}
#[Route('/threadf', name: 'app_thread_like', methods: ['POST'])]
    public function likeThread(Thread $thread, EntityManagerInterface $entityManager): Response
    {
        // Implement your logic to handle liking a thread here
        
        // For example, you might increment a 'likes' counter for the thread
        $thread->incrementLikes();
        
        // Persist the changes to the database
        $entityManager->flush();
        
        // Return a response, e.g., a JSON response indicating success
        return $this->json(['message' => 'Thread liked successfully']);
    }

    #[Route('/threadf', name: 'app_thread_dislike', methods: ['POST'])]
    public function dislikeThread(Thread $thread, EntityManagerInterface $entityManager): Response
    {
        // Implement your logic to handle disliking a thread here
        
        // For example, you might decrement a 'likes' counter for the thread
        $thread->decrementLikes();
        
        // Persist the changes to the database
        $entityManager->flush();
        
        // Return a response, e.g., a JSON response indicating success
        return $this->json(['message' => 'Thread disliked successfully']);
    }

    
}


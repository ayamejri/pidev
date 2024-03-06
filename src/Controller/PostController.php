<?php

namespace App\Controller;
use App\Entity\Thread;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, Request $request): Response
    {
        $keyword = $request->query->get('keyword');
        $sortBy = $request->query->get('sortBy');

        if ($keyword) {
            $posts = $postRepository->searchByKeyword($keyword);
        } elseif ($sortBy === 'createdAtDescending') {
            $posts = $postRepository->sortByCreatedAtDescending();
        } else {
            $posts = $postRepository->findAll();
        }

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    #[Route('/postf', name: 'app_post_indexf', methods: ['GET'])]
    public function indexfront(PostRepository $postRepository, Request $request): Response
    {
        $keyword = $request->query->get('keyword');
        $sortBy = $request->query->get('sortBy');

        if ($keyword) {
            $posts = $postRepository->searchByKeyword($keyword);
        } elseif ($sortBy === 'createdAtDescending') {
            $posts = $postRepository->sortByCreatedAtDescending();
        } else {
            $posts = $postRepository->findAll();
        }

        return $this->render('post/indexfront.html.twig', [
            'posts' => $posts,
        ]);
    }
    

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }
        #[Route('/post/postf/newf', name: 'app_post_newf', methods: ['GET', 'POST'])]
    public function newf(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            $email = (new Email())
            ->from('bekir.emna@esprit.tn')
            ->To('hannachi.oussama@esprit.tn')
            ->subject('new post')
            ->text("new post has been added to thakafa's Blog ");
            $mailer->send($email);

            return $this->redirectToRoute('app_post_indexf', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/newf.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
    #[Route('post/postf/{id}', name: 'app_post_showf', methods: ['GET'])]
    public function showf(Post $post): Response
    {
        return $this->render('post/showf.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }
    #[Route('post/postf/{id}/editf', name: 'app_post_editf', methods: ['GET', 'POST'])]
    public function editf(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_indexf', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/editf.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/pdf/{id}', name: 'app_post_pdf', methods: ['GET'])]
    
    public function generatePdf(PostRepository $postRepository): Response
{
    // Fetch all posts from the repository
    $posts = $postRepository->findAll();

    // Create a new instance of Dompdf
    $dompdf = new Dompdf();

    // Load options for the PDF
    $options = new Options();
    $options->set('defaultFont', 'Arial');

    // Set options
    $dompdf->setOptions($options);

    // Render the PDF content using the provided HTML template
    $html = $this->renderView('post/pdf.html.twig', [
        'posts' => $posts,
    ]);

    // Load HTML to Dompdf
    $dompdf->loadHtml($html);

    // Render PDF
    $dompdf->render();

    // Output PDF
    return new Response($dompdf->output(), Response::HTTP_OK, [
        'Content-Type' => 'application/pdf',
    ]);
}
}





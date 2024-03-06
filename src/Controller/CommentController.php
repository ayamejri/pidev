<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comments', name: 'app_comments')]
    public function index(): Response
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://jsonplaceholder.typicode.com/comments');
        $comments = $response->toArray();

        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }
    #[Route('/', name: 'app_comments')]
    public function index2(): Response
    {

        return $this->render('security/home.html.twig');
    }
}

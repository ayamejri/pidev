<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class GlobalController extends AbstractController
{
    #[Route('/global', name: 'app_global')]
    public function index(TokenStorageInterface $tokenStorage): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");

        /** @var User $user */
        $user = $this->getUser();
        $roles = $user->getRoles();

        // Check if the user has both "ROLE_ADMIN" and "ROLE_USER"
        if (in_array('ROLE_ADMIN', $roles) && in_array('ROLE_USER', $roles)) {
            // Redirect to UserController
            return $this->redirectToRoute('app_user_index'); 

        }  
        else {
            return match ($user->isVerified()) {
                true => $this->render("global/index.html.twig"),
                
               false => $this->render("global/please-verify-email.html.twig"),
            };
        }
    }
    
    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        return $this->render('global/homepage.html.twig');
    }

    
}

 
    

   /* 
    public function index(): Response
    {
        return $this->render('global/index.html.twig', [
            'controller_name' => 'GlobalController',
        ]);*/
        

        
    

  // le test li kanou mahtoutin kbal ma tabda tbarbech 
  /*
  {
            return match ($user->isVerified()) {
                true => $this->render("global/index.html.twig"),
                false => $this->render("global/please-verify-email.html.twig"),
            };
        }
        */
    


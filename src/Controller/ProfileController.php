<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; // Corrected namespace import
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;


class ProfileController extends AbstractController 


{
    /**
 * @Route("/edit", name="User.edit", methods={"GET", "POST"})
 */


    #[Route('/edit', name: 'User.edit', methods: ['GET', 'POST'])]
    public function editProfile(Request $request , ManagerRegistry $Manag)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $Manag->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_user_Profil');
            
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/Profil', name: 'app_user_Profil', methods: ['GET'])]

    public function Profil(UserRepository $userRepository): Response
    {
        return $this->render('profile/PageProfil.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/editpass', name: 'User.editpass', methods: ['GET', 'POST'])]
    public function editPass(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $manag)
{
    if ($request->isMethod('POST')) {
        $em = $manag->getManager();
        $user = $this->getUser();

        // On vérifie si les 2 mots de passe sont identiques
        if ($request->request->get('pass') == $request->request->get('pass2')) {
            $user->setPassword($passwordHasher->hashPassword($user, $request->request->get('pass')));
            $em->flush();
            $this->addFlash('message', 'Mot de passe mis à jour avec succès');

            return $this->redirectToRoute('app_user_Profil');
        } else {
            $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
        }
    }

    return $this->render('profile/editpass.html.twig');
}
}
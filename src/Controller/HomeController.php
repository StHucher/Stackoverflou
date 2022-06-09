<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route ("/", name="main_page")
     */
    public function main(): Response
    {
        return $this->render ('home/main.html.twig', []);
    }


    /**
     * @Route("/subscribe", name="app_subscribe", methods={"GET", "POST"})
     */

     public function newUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder):Response
     {
         $user = new User();
         $form = $this->createForm(UserType::class, $user);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $user->setPassword($encoder->hashPassword($user, $user->getPassword()));

             $entityManager->persist($user);
             $entityManager->flush();

             return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
         }

         //Display the form
         return $this->renderForm('home/index.html.twig', [
         'user' => $user,
         'form' => $form,
        ]);
     }
}
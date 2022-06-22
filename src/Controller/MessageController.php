<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="app_message")
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/all.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }


    /**
     * @Route("/message/new", name="message_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_message', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    /**
     * @Route("message/{id}", name="message_show", methods={"GET"})
     * 
     */
    public function show(MessageRepository $messageRepository, $id): Response
    {
        $messageId = $id;
        $message = $messageRepository->find($id);
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("message/{id}/edit", name="message_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //TODO mettre un message flash de réussite//

            $entityManager->flush();
            return $this->redirectToRoute('app_message', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/edit.html.twig', [
            'form' => $form,
            'message' => $message,
        ]);        
    }

    /**
     * @Route("message/{id}", name="message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message', [], Response::HTTP_SEE_OTHER);
    }
}

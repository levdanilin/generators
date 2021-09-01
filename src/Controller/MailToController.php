<?php

namespace App\Controller;

use App\DTO\MailTo;
use App\Form\Type\MailToType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailToController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route ("/mailto/", name="mailto")
     */
    public function generate(Request $request): Response
    {
        $submit = false;
        $mailTo = new MailTo();
        $form = $this->createForm(MailToType::class, $mailTo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $submit = true;
        }

        return $this->render('MailTo/mailTo.html.twig', [
            'form' => $form->createView(),
            'mailTo' => $mailTo,
            'submit' => $submit,
        ]);

    }

}
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
        $mailTo = new MailTo();
        $form = $this->createForm(MailToType::class, $mailTo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $mailToLink = 'mailto:' . $mailTo->getAddress() .'?' . 'subject=' . $mailTo->getSubject();

            if($mailTo->getCc() !== null)
            {
                $mailToLink .= '&cc=' . $mailTo->getCc();
            }
            if($mailTo->getBcc() !== null)
            {
                $mailToLink .= '&bcc=' . $mailTo->getBcc();
            }
            if($mailTo->getBody() !== null)
            {
                $mailToLink .= '&body=' . $mailTo->getBody();
            }
            $mailTo->setLink($mailToLink);
        }

        return $this->render('MailTo/mailTo.html.twig', [
            'form' => $form->createView(),
            'mailTo' => $mailTo,
        ]);

    }

}
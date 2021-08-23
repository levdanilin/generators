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
            /*$data = [];
            $validData = [];
            $data['address'] = $mailTo->getAddress();
            $data['cc'] = $mailTo->getCc();
            $data['bcc'] = $mailTo->getBcc();
            $data['subject'] = $mailTo->getSubject();
            $data['body'] = $mailTo->getBody();
            foreach($data as $key => $dataValue)
            {
                if($dataValue != null)
                {
                    $validData[$key] = $dataValue;
                }
            }*/
        }

        return $this->render('MailTo/mailTo.html.twig', [
            'form' => $form->createView(),
//          'validData' => $validData,
            'mailTo' => $mailTo,
        ]);

    }

}
<?php

namespace App\Controller;

use App\Entity\BasicAuth;
use App\Form\Type\BasicAuthType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasicAuthController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route ("/basicauth/", name="basicauth")
     */
    public function generate(Request $request): Response
    {
        $basicAuth = new BasicAuth();
        $form = $this->createForm(BasicAuthType::class, $basicAuth);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $passwordEncrypted = password_hash($basicAuth->getPassword(), PASSWORD_BCRYPT);
            $basicAuth->setPassword($passwordEncrypted);
        }

        return $this->render('BasicAuth/basicAuth.html.twig', [
            'form' => $form->createView(),
            'basicAuth' => $basicAuth,
        ]);
    }
}
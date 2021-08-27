<?php

namespace App\Controller;

use App\DTO\UserData;
use App\Entity\BasicAuth;
use App\Form\Type\BasicAuthType;
use Exception;
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
     * @throws Exception
     */
    public function generate(Request $request): Response
    {
        $basicAuth = new BasicAuth();
        $userData = new UserData();
        $basicAuth->addUserData($userData);
        $form = $this->createForm(BasicAuthType::class, $basicAuth);
        $form->handleRequest($request);
        $verifyStatus = false;
        if ($form->isSubmitted() && $form->isValid())
        {
            foreach($basicAuth->getUserData() as $data)
            {
                $hashedPassword = password_hash($data->getPassword(), PASSWORD_BCRYPT);

                if(!password_verify($data->getPassword(), $hashedPassword))
                {
                    throw new Exception('Password is not verified!');
                }
                $verifyStatus = true;
                $data->setPassword($hashedPassword);
            }

        }
        return $this->render('BasicAuth/basicAuthEmbed.html.twig', [
            'form' => $form->createView(),
            'basicAuth' => $basicAuth,
            'verifyStatus' => $verifyStatus,
        ]);
    }
}
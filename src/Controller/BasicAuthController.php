<?php

namespace App\Controller;

use App\DTO\UserData;
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
        //dump($basicAuth);die;
        /*$userData = (new UserData())->setUserName('bla')->setPassword('test');
        $basicAuth->getUserData()->add($userData);*/
        $userData = new UserData();
        $userData1 = new UserData();
        $basicAuth->addUserData($userData);
        $basicAuth->addUserData($userData1);
        $form = $this->createForm(BasicAuthType::class, $basicAuth);
        $form->handleRequest($request);
        //dump($request);die;
        if($form->isSubmitted() && $form->isValid()) {
            dump($basicAuth, $userData, $userData1);die;
          /*  foreach ($basicAuth->getUserData() as $data)
            {dump($data);die;}*/
            //dump($basicAuth->getUserData());die;
            $passwordEncrypted = password_hash($userData->getPassword(), PASSWORD_BCRYPT);
            $userData->setPassword($passwordEncrypted);
            dump($basicAuth, $userData, $userData1);die;
        }

        return $this->render('BasicAuth/basicAuthEmbed.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
<?php

namespace App\Controller;

use App\DTO\PasswordGenerator;
use App\Form\Type\PasswordGeneratorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class PasswordGeneratorController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route ("/passwordgenerator/", name="passwordgenerator")
     */
    public function generate(Request $request, FlashBagInterface $flashBag): Response
    {
        $passwordGenerator = new PasswordGenerator();
        $form = $this->createForm(PasswordGeneratorType::class, $passwordGenerator);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $computerPasswordGenerator = new ComputerPasswordGenerator();
            $computerPasswordGenerator->setLength($passwordGenerator->getLength());
            if(!$passwordGenerator->hasUpperCase()) {
                $computerPasswordGenerator->setOptionValue(ComputerPasswordGenerator::OPTION_UPPER_CASE, false);
            }
            if (!$passwordGenerator->hasLowerCase()) {
                $computerPasswordGenerator->setOptionValue(ComputerPasswordGenerator::OPTION_LOWER_CASE, false);
            }
            if ($passwordGenerator->hasSymbols()) {
                $computerPasswordGenerator->setOptionValue(ComputerPasswordGenerator::OPTION_SYMBOLS, true);
            }
            if (!$passwordGenerator->hasNumbers()) {
                $computerPasswordGenerator->setOptionValue(ComputerPasswordGenerator::OPTION_NUMBERS, false);
            }
            if(!$passwordGenerator->hasUpperCase() && !$passwordGenerator->hasLowerCase() && !$passwordGenerator->hasSymbols() && !$passwordGenerator->hasNumbers())
            {
                $flashBag->add('warning','Please select at least one parameter' );
            } else {
                $passwordGenerator->setPassword($computerPasswordGenerator->generatePassword());
            }


        }
        return $this->render('PasswordGenerator/passwordGenerator.html.twig',[
            'form' => $form->createView(),
            'password' => $passwordGenerator->getPassword(),
        ]);
    }
}
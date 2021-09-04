<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Form\Type\ImageType;
use App\Repository\ImageRepository;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;



class ImageResolverController extends AbstractController
{
    /**
     * @param Request $request
     * @param SluggerInterface $slugger
     * @return Response
     * @Route ("/imageuploader/", name="imageuploader")
     */
    public function upload(Request $request, SluggerInterface $slugger): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $imageFile = $form->get('image')->getData();
            if($imageFile)
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move($this->getParameter('images_directory'),
                    $newFilename);
                } catch (FileException $e) {
                    echo $e->getMessage();
                }
                $path = '/uploads/images/' . $newFilename;
                $image->setPath($path);
                $image->setFilename($newFilename);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($image);
                $entityManager->flush();
            }
        }
        return $this->render('ImageResolver/imageUploader.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/imageresolver/", name="imageresolver")
     */
    public function getImage(Request $request, ImageRepository $imageRepository): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            //dump($form->isValid());die;
            try {
                $randomImage = $imageRepository->findRandomByCategories($request->get('image')['categories']);
                $image->setPath($randomImage->getPath());
                $image->setFilename($randomImage->getFilename());
                $image->setId($randomImage->getId());
            } catch (Exception | \Doctrine\DBAL\Exception $e) {
                //echo $e->getMessage();
            }
            //dump($image);die;
        }
        return $this->render('ImageResolver/imageResolver.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
            ]);
    }
}
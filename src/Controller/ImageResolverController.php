<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Form\Type\ImageType;
use App\Repository\ImageRepository;
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
                $path = '/public/uploads/images/' . $newFilename;
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
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);
        /*$categoryRepository = $this->getDoctrine()->getManager()->getRepository(Category::class);
        $categories = $categoryRepository->findAll();*/
        if($form->isSubmitted())
        {
            $imageRepository->findRandomByCategories($request->get('image')['categories']);
        }
        return $this->render('ImageResolver/imageResolver.html.twig', [
//            'categories' => $categories]);
        'form' => $form->createView()]);
    }
}
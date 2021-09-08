<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Form\Type\GetImageType;
use App\Form\Type\UploadImageType;
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
        $form = $this->createForm(UploadImageType::class, $image);
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
                    $this->addFlash('warning', $e->getMessage());
                }
                $path = '/uploads/images/' . $newFilename;
                $image->setPath($path);
                $image->setFilename($newFilename);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($image);
                $entityManager->flush();
                $this->addFlash('success', 'You have successfully uploaded an image!');
            }
        }
        return $this->render('ImageResolver/imageUploader.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param ImageRepository $imageRepository
     * @return Response
     * @Route ("/imageresolver/", name="imageresolver")
     */
    public function getImage(Request $request, ImageRepository $imageRepository): Response
    {
        $form = $this->createForm(GetImageType::class);
        $form->handleRequest($request);
        $image = null;

        if($form->isSubmitted() && $form->isValid())
        {

            $categories = $form->getData()->getCategories();

            $categoryIds = array_map(function(Category $category) {
                return $category->getId();
            }, $categories->toArray());

            try {
                $image = $imageRepository->findRandomByCategories($categoryIds);
                if($image)
                {
                    $image->setCategories($categories);
                }else {
                    $this->addFlash('warning', 'There is no Images under this category yet');
                }

            } catch (Exception | \Doctrine\DBAL\Exception $e) {
                    $this->addFlash('warning', $e->getMessage());
            }

        }

        return $this->render('ImageResolver/imageResolver.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
            ]);
    }
}
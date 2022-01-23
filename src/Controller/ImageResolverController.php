<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Form\Type\GetImageType;
use App\Form\Type\UploadImageType;
use App\Repository\ImageRepository;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ManagerRegistry;


class ImageResolverController extends AbstractController
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

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

                $entityManager = $this->managerRegistry->getManager();
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

    /**
     * @Route ("/imagegallery/", name="imagegallery")
     * @return Response
     */
    public function showAllImages(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->showAllImages();
        if(empty($images))
        {
            $this->addFlash('success', 'You have no images yet!');
        }
        return $this->render('ImageResolver/imageGallery.html.twig', [
            'images' => $images,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @Route ("/imagegallery/delete/{id}", name="imagegallery_delete")
     */
    public function deleteImage($id): Response
    {
        $em = $this->managerRegistry->getManager();
        $imageRepository = $em->getRepository(Image::class);
        $image = $imageRepository->find($id);
        if(!$image) {
            throw $this->createNotFoundException('Image ' . $id . ' was not found');
        }
        $filename = $image->getFilename();
        $filesystem = new Filesystem();
        $filesystem->remove($this->getParameter('public_directory') . '/uploads/images/' . $filename);
        $em->remove($image);
        $em->flush();
        $this->addFlash('success', 'Image was successfully removed! ');
        return $this->redirectToRoute('imagegallery');
    }

    /**
     * @Route ("/imagegallery/deleteall", name="imagegallery_delete_all")
     * @return Response
     */
    public function deleteAllImages(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->showAllImages();
        if(empty($images)) {
            throw $this->createNotFoundException('You have no images yet');
        }
        $em = $this->managerRegistry->getManager();
        $filesystem = new Filesystem();
        foreach($images as $image) {
            $filesystem->remove($this->getParameter('public_directory') . '/uploads/images/' . $image->getFilename());
            $em->remove($image);
        }
        $em->flush();
        $this->addFlash('success', 'All images were successfully removed! ');
        return $this->redirectToRoute('imagegallery');
    }
}
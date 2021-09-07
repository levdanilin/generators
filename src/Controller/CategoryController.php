<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/imageuploader/category/new", name="imagecategory_new")
     */
    public function addCategory(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository(Category::class);
        $categories = $categoryRepository->findAll();
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($category);
            $em->flush();
        }
        return $this->render('ImageResolver/imageCategories.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    /**
     * @param $id
     * @Route ("/imageuploader/category/delete/{id}", name="imagecategory_delete")
     */
    public function deleteCategory($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository(Category::class);
        $category = $categoryRepository->find($id);
        if(!$category) {
            throw $this->createNotFoundException('Category with id ' . $id . ' was not found');
        }
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('imagecategory_new');
    }
}
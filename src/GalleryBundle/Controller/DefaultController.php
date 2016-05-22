<?php

namespace GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('GalleryBundle:Category')->findAll();

        return $this->render('GalleryBundle:Default:index.html.twig', [
            'categories' => $categories
        ]);
    }

    public function getHeaderCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('GalleryBundle:Category')->findAll();

        return $this->render('category/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/api/main/", name="get_last_images")
     */
    public function getImagesForMainPageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $category \GalleryBundle\Entity\Category
         */
        $images = $em->getRepository('GalleryBundle:Image')->findBy(['isMain' => 1],
            ['id' => 'DESC'],
            20,
            0
        );

        return new JsonResponse(['images' => $images, 'header' => 'main', 'count' => count($images)]);
    }

    /**
     * @param Request $request
     *
     * @Route("/api/category/{id}", name="get_images_by_category")
     */
    public function getImagesByCategoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $category \GalleryBundle\Entity\Category
         */
        $category = $em->getRepository('GalleryBundle:Category')->findOneById($id);

        $images = $category->getImages()->toArray();

        return new JsonResponse(['images' => $images, 'header' => $category->getHeader(), 'count' => count($images)]);
    }
}

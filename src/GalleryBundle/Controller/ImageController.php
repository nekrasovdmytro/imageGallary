<?php

namespace GalleryBundle\Controller;

use GalleryBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GalleryBundle\Entity\Image;
use GalleryBundle\Form\ImageType;

/**
 * Image controller.
 *
 * @Route("/admin/image")
 */
class ImageController extends Controller
{
    /**
     * Lists all Image entities.
     *
     * @Route("/", name="image_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('GalleryBundle:Image')->findAll();
        $categories = $em->getRepository('GalleryBundle:Category')->findAll();

        return $this->render('image/index.html.twig', array(
            'images' => $images,
            'categories' => $categories
        ));
    }

    /**
     * Lists all Image entities.
     *
     * @Route("/upload_many", name="image_upload_many")
     * @Method("POST")
     */
    public function uploadImagesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $photoshotHash = md5(time());

        /**
         * @var \GalleryBundle\Entity\Category $category
         */
        $category = $em->getRepository('GalleryBundle:Category')->findOneById($request->get('categoryId'));

        foreach ($request->files->get('files') as $file) {
            /**
             * @var \GalleryBundle\Entity\Image $image
             */
            $image = new Image();
            $image->addCategory($category);
            $image->setName($request->get('text'));
            $image->setDescription($request->get('text'));
            $image->setSort(0);
            $image->setIsMain(0);
            $image->setFile($file);
            $image->setPhotoshootHash($photoshotHash);

            $em->persist($image);
        }

        /**
         * @var \GalleryBundle\GalleryPusher\GalleryPusher $pusher
         */
        $pusher = $this->get('gallery.pusher');
        $data = [
            'category_id' => $category->getId()
        ];

        $em->flush();
        $pusher->triggerMessage('update_images', $data);

        return $this->redirectToRoute('image_index');
    }

    /**
     * Creates a new Image entity.
     *
     * @Route("/new", name="image_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $image = new Image();
        $form = $this->createForm('GalleryBundle\Form\ImageType', $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('image_show', array('id' => $image->getId()));
        }

        return $this->render('image/new.html.twig', array(
            'image' => $image,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Image entity.
     *
     * @Route("/{id}", name="image_show")
     * @Method("GET")
     */
    public function showAction(Image $image)
    {
        $deleteForm = $this->createDeleteForm($image);

        return $this->render('image/show.html.twig', array(
            'image' => $image,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     * @Route("/{id}/edit", name="image_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Image $image)
    {
        $deleteForm = $this->createDeleteForm($image);
        $editForm = $this->createForm('GalleryBundle\Form\ImageType', $image);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('image_edit', array('id' => $image->getId()));
        }

        return $this->render('image/edit.html.twig', array(
            'image' => $image,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/{id}", name="image_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Image $image)
    {
        $form = $this->createDeleteForm($image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
        }

        return $this->redirectToRoute('image_index');
    }

    /**
     * Creates a form to delete a Image entity.
     *
     * @param Image $image The Image entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Image $image)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('image_delete', array('id' => $image->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

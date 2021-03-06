<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hostel;
use AppBundle\Entity\HostelImage;
use AppBundle\Form\HostelImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HostelImageController
 * @package AppBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" = "%app.locales%"})
 */
class HostelImageController extends Controller
{
    /**
     * @Route("/hostel/{slug}/image/list", name="hostel_image_list")
     */
    public function indexAction(Request $request, Hostel $hostel)
    {
        return $this->render('hostel_image/index.html.twig', [
            'hostel' => $hostel
        ]);
    }

    /**
     * @Route("/hostel/image/edit/{id}", name="hostel_image_edit")
     */
    public function editAction(Request $request, HostelImage $image)
    {
        $this->denyAccessUnlessGranted('edit', $image->getHostel());
        $form = $this->createForm(HostelImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveInDatabase($image);
            return $this->redirectToRoute('hostel_image_list', [
                'slug' => $image->getHostel()->getSlug()
            ]);
        }

        return $this->render('hostel_image/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/hostel/image/remove/{id}", name="hostel_image_remove")
     */
    public function removeAction(Request $request, HostelImage $image)
    {
        $this->denyAccessUnlessGranted('edit', $image->getHostel());
        $em = $this->getDoctrine()->getManager();
        $hostel = $image->getHostel();

        $em->remove($image);
        $em->flush();

        return $this->redirectToRoute('hostel_image_list', [
            'slug' => $hostel->getSlug()
        ]);
    }

    /**
     * @Route("/hostel/{slug}/image/new", name="hostel_image_new")
     */
    public function newAction(Request $request, Hostel $hostel)
    {
        $image = new HostelImage();
        $image->setHostel($hostel);

        $this->denyAccessUnlessGranted('create', $hostel);

        $form = $this->createForm(HostelImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveInDatabase($image);
            return $this->redirectToRoute('hostel_image_list', [
                'slug' => $hostel->getSlug()
            ]);
        }

        return $this->render('hostel_image/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function saveInDatabase($entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }

    public function getRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:HostelImage');
    }

}

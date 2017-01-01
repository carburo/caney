<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Language;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TranslationController
 * @package AppBundle\Controller
 * @Route("admin/{_locale}", requirements={"_locale" = "%app.locales%"})
 */
class TranslationController extends Controller
{
    /**
     * @Route("/translation/room_services/{language}", name="roomServicesTranslation")
     */
    public function roomServiceAction(Request $request, Language $language) {
        return $this->handleTranslationForm($request, $language, 'AppBundle:RoomService');
    }

    /**
     * @Route("/translation/services/{language}", name="servicesTranslation")
     */
    public function serviceAction(Request $request, Language $language) {
        return $this->handleTranslationForm($request, $language, 'AppBundle:Service');
    }

    /**
     * @Route("/translation/service_classifications/{language}", name="serviceClassificationsTranslation")
     */
    public function serviceClassificationAction(Request $request, Language $language) {
        return $this->handleTranslationForm($request, $language, 'AppBundle:ServiceClassification');
    }

    private function createTranslationMapping($entities) {
        $mapping = [];
        foreach ($entities as $entity) {
            $id = $entity->getId();
            $mapping[$id] = $entity;
        }

        return $mapping;
    }

    private function createTranslationForm($entities, $locale) {
        $em = $this->getDoctrine()->getEntityManager();
        $formBuilder = $this->createFormBuilder();

        foreach ($entities as $entity) {
            $entity->setLocale('en');
            $em->refresh($entity);

            $key = $entity->__toString();
            $id = $entity->getId();

            $entity->setLocale($locale);
            $em->refresh($entity);
            $value = $entity->__toString();

            $formBuilder->add($id, TextType::class, [
                'data' => $value,
                'label' => $key,
            ]);
        }

        return $formBuilder->getForm();
    }

    private function handleTranslationForm(Request $request, Language $language, $entityName) {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $this->getDoctrine()->getRepository($entityName);
        $entities = $repo->findAll();

        $mapping = $this->createTranslationMapping($entities);

        $form = $this->createTranslationForm($entities, $language->getIsoCode());
        $form->handleRequest($request);

        if($form->isValid()) {
            $data = $form->getData();
            foreach ($mapping as $key => $entity) {
                $entity->setLocale($language->getIsoCode());
                $entity->setName($data[$key]);
                $em->persist($entity);
                $em->flush();
            }
        }

        return $this->render('translations/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

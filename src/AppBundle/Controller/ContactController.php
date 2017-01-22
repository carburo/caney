<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
// use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
// use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactController
 * @package AppBundle\Controller
 * @Route("/{_locale}", requirements={"_locale" = "%app.locales%"})
 */
class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
//         if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
//             $form->add('recaptcha', EWZRecaptchaType::class, array(
//                 'mapped' => false,
//                 'constraints' => array(
//                     new RecaptchaTrue()
//                 )
//             ));
//         }

        $form->handleRequest($request);

        if($form->isValid()) {
            $this->sendEmail($contact);
            $this->saveInDatabase($contact);

            if($request->isXmlHttpRequest()) {
                $status = array(
                    'type'=>'success',
                    'message'=>'Email sent!'
                );
                return new JsonResponse($status);
            } else {
                unset($contact);
                unset($form);
                $contact = new Contact();
                $form = $this->createForm(ContactType::class, $contact);
            }
        }
        return $this->render('contact/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function sendEmail(Contact $contact) {
        $message = \Swift_Message::newInstance()
            ->setSubject('Nuevo mensaje de caneylodging.com')
            ->setFrom($this->getParameter('sender.email'))
            ->setTo($this->getParameter('addressee.email'))
            ->setBody($this->renderView(
                'contact/mail.html.twig',
                array('contact' => $contact)
            ), 'text/html')
        ;
        $this->get('mailer')->send($message);
    }

    private function saveInDatabase($contact) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();
    }
}

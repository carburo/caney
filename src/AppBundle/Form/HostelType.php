<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class HostelType extends AbstractType
{

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // grab the user, do a quick sanity check that one exists
        $user = $this->tokenStorage->getToken()->getUser();
        if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($user) {
                $form = $event->getForm();
                $form
                    ->add('active')
                    ->add('owner')
                ;
            });
        }

        $builder
            ->add('hostelName')
            ->add('description', TextareaType::class)
            ->add('address')
            ->add('website', UrlType::class, [
                'required' => false
            ])
            ->add('hostLanguages', null, [
                'expanded' => 'true',
            ])
            ->add('location')
            ->add('offerType', ChoiceType::class, [
                'choices' => [
                    'SINGLE_ROOM' => 'SINGLE_ROOM',
                    'WHOLE_HOUSE' => 'WHOLE_HOUSE',
                ]
            ])
            ->add('priceInLow')
            ->add('priceInHigh')
            ->add('services', null, [
                'expanded' => 'true',
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Hostel'
        ));
    }
}

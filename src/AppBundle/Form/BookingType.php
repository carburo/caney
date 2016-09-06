<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hostel')
            ->add('user')
            ->add('startDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('numberOfPersons')
            ->add('arrivalMeans', null, [
                'placeholder' => 'label.arrivalMeans'
            ])
            ->add('comments', TextareaType::class, [
                'required' => false,
            ])
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $booking = $event->getData();

                $hostel = $booking->getHostel();
                $rooms = null === $hostel ? [] : $hostel->getRooms();

                $form->add('rooms', EntityType::class, [
                    'multiple' => true,
                    'class' => 'AppBundle:Room',
                    'expanded' => 'true',
                    'choices' => $rooms,
                    'translation_domain' => false,
                ]);
            }
        );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Booking'
        ));
    }
}

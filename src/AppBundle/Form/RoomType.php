<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('description')
            ->add('capacity')
            ->add('priceInHigh', MoneyType::class, [
                'currency' => 'CUC'
            ])
            ->add('priceInLow', MoneyType::class, [
                'currency' => 'CUC'
            ])
            ->add('privateBathroom')
            ->add('hotWater')
            ->add('airConditioner')
            ->add('voltage120')
            ->add('voltage240')
            ->add('privateEntrance')
            ->add('safe')
            ->add('terrace')
            ->add('minibar')
            ->add('hairDryer')
            ->add('television')
            ->add('hostel')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Room'
        ));
    }
}

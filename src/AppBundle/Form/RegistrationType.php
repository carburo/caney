<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 12/06/16
 * Time: 18:55
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('forename', null, ['label' => 'form.forename'])
            ->add('surname', null, ['label' => 'form.surname'])
            ->add('phoneNumber', HiddenType::class, [
                'label' => 'form.phoneNumber',
                'required' => false
            ])
            ->add('country', CountryType::class, [
                'label' => 'form.country',
                'required' => false,
            ])
            ->add('owner', HiddenType::class, ['label' => 'form.owner'])
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}
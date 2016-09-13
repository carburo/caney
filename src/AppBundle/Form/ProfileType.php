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
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'required'      => false,
                'allow_delete'  => false,
                'download_link' => false,
            ])
            ->add('forename', null, ['label' => 'form.forename'])
            ->add('surname', null, ['label' => 'form.surname'])
            ->add('phoneNumber', null, ['label' => 'form.phoneNumber'])
            ->add('country', CountryType::class, [
                'label' => 'form.country',
                'required' => false,
            ])
            ->add('owner', null, ['label' => 'form.owner'])
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}
<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class RoomAdmin extends AbstractAdmin {
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
            ->add('name')
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
            ->add('type')
            ->add('hostel');
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('name');
	}
	
	protected function configureListFields(ListMapper $listMapper)
	{
        $listMapper->addIdentifier('hostel');
		$listMapper->addIdentifier('name');
	}
}
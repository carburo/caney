<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RoomAdmin extends AbstractAdmin {
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
            ->add('hostel')
            ->add('name')
            ->add('type')
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('capacity')
            ->add('priceInHigh', MoneyType::class, [
                'currency' => 'CUC'
            ])
            ->add('priceInLow', MoneyType::class, [
                'currency' => 'CUC'
            ])
            ->add('services', null, array(
                'expanded' => 'true',
            ))
            ;
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
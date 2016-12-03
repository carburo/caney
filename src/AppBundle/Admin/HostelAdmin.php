<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class HostelAdmin extends AbstractAdmin {
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper->add('hostelName')
            ->add('active')
            ->add('description', TextareaType::class)
            ->add('owner')
            ->add('address')
            ->add('website', UrlType::class)
            ->add('hostLanguages')
            ->add('breakfast')
            ->add('breakfastPrice', MoneyType::class, [
                'currency' => 'CUC'
            ])
            ->add('dinner')
            ->add('dinnerPrice', MoneyType::class, [
                'currency' => 'CUC'
            ])
            ->add('cocktails')
            ->add('childrenAccepted')
            ->add('garage')
            ->add('garagePrice', MoneyType::class, [
                'currency' => 'CUC'
            ])
            ->add('swimmingPool')
            ->add('laundry')
            ->add('internet')
            ->add('wifi')
            ->add('location')
            ->add('rooms', 'sonata_type_collection', [
            ])
            ->add('images', 'sonata_type_collection', [
            ]);
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('hostelName');
	}
	
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper->addIdentifier('hostelName');
	}
}
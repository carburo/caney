<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ServiceClassificationAdmin extends AbstractAdmin {
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
            ->add('name')
            ->add('icon', null, [
                'required' => false
            ])
            ->end()->end()
            ->tab('Services')
                ->add('services', 'sonata_type_collection')
            ->end()->end()
            ;
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('name');
	}
	
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper->addIdentifier('name');
	}
}
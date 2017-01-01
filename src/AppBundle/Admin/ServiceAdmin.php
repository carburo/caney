<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ServiceAdmin extends AbstractAdmin {
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
            ->add('name')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'boolean' => 'boolean',
                    'priced' => 'priced'
                ]
            ])
            ->add('icon', null, [
                'required' => false
            ])
            ->add('classification')
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
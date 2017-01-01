<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageAdmin extends AbstractAdmin {
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
            ->add('imageFile', VichImageType::class, [
                'required'      => false,
                'allow_delete'  => false,
                'download_link' => false
            ])
            ->add('description');
	}
	
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper->add('description');
	}
	
	protected function configureListFields(ListMapper $listMapper)
	{
        $listMapper->addIdentifier('description');
	}
}
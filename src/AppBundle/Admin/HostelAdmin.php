<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class HostelAdmin extends AbstractAdmin {
	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
            ->tab('Hostel')
                ->add('hostelName')
                ->add('active')
                ->add('description', TextareaType::class)
                ->add('owner')
                ->add('address')
                ->add('website', UrlType::class, [
                    'required' => false
                ])
                ->add('hostLanguages')
                ->add('location')
                ->add('offerType', ChoiceType::class, [
                    'choices' => [
                        'SINGLE_ROOM' => 'SINGLE_ROOM',
                        'WHOLE_HOUSE' => 'WHOLE_HOUSE',
                    ]
                ])
                ->add('priceInLow')
                ->add('priceInHigh')
                ->add('services')
            ->end()->end()
            ->tab('Rooms')
                ->add('rooms', 'sonata_type_collection')
            ->end()->end()
            ->tab('Images')
                ->add('images', 'sonata_type_collection')
            ->end()
        ;
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
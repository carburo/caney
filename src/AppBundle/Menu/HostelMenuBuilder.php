<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 29/08/16
 * Time: 22:28
 */

namespace AppBundle\Menu;


use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class HostelMenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem("root");
        $menu->setChildrenAttribute('class', 'nav nav-sidebar');
        $hostel = $options['hostel'];

        $menu->addChild('general', [
            'route' => 'hostel_edit',
            'routeParameters' => ['slug' => $hostel->getSlug()]
        ]);

        $menu->addChild('rooms', [
            'route' => 'hostel_rooms_edit',
            'routeParameters' => ['slug' => $hostel->getSlug()]
        ]);

        $menu->addChild('pictures', [
            'route' => 'fos_user_security_login'
        ]);

        return $menu;
    }

}
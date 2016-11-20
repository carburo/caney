<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Intl\Intl;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('menu.homepage', [
            'route' => 'homepage'
        ]);

        $this->addDestinationMenu($menu);
        
        $menu->addChild('menu.contact', [
            'route' => 'contact'
        ]);

        $this->addUserMenu($menu);
        $this->addLanguageMenu($menu, $options);
        
        return $menu;
    }

    private function addDestinationMenu(ItemInterface $root)
    {
        // create another menu item
        $menu = $root->addChild('destinations', [
            'label' => 'menu.destinations'
        ])->setAttribute('dropdown', true);

        $repo = $this->container->get('doctrine')->getRepository('AppBundle\Entity\Location');
        $locations = $repo->findAll();
        foreach ($locations as $location) {
            if(!$location->getHostels()->isEmpty()) {
                $menu->addChild($location->getName(), [
                    'route' => "hostelsByDestination",
                    'routeParameters' => ['slug' => $location->getSlug()]
                ])->setAttribute('dropdown_item', true);
            }
        }
    }
    
    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        $this->addUserMenu($menu);
    
        return $menu;
    }
    
    public function addUserMenu(ItemInterface $root)
    {
        $securityChecker = $this->container->get('security.authorization_checker');
        $translator = $this->container->get('translator');
        if ($securityChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $securityContext = $this->container->get('security.token_storage');
            $user = $securityContext->getToken()->getUser();
        
            $userMessage = $translator->trans('menu.welcome.message', [
                '%visitor%' => $user->getForename()
            ]);
        
            // create another menu item
            $menu = $root->addChild('User', [
                'label' => $userMessage
            ])->setAttribute('dropdown', true);
        
            $menu->addChild('menu.user.edit', [
                'route' => 'fos_user_profile_edit'
            ])
                ->setAttribute('icon', 'icon icon-edit')
                ->setAttribute('dropdown_item', true);
            
            $menu->addChild('menu.user.changePassword', [
                'route' => 'fos_user_change_password'
            ])
                ->setAttribute('icon', 'icon icon-key')
                ->setAttribute('dropdown_item', true);

            if($user->isOwner())
            {
                $menu->addChild('menu.hostel.register', [
                    'route' => 'hostel_registration'
                ])->setAttribute('dropdown_item', true);
            }
        
            $menu->addChild($translator->trans('layout.logout', [], 'FOSUserBundle'), [
                'route' => 'fos_user_security_logout'
            ])
                ->setAttribute('icon', 'icon icon-sign-out')
                ->setAttribute('dropdown_item', true);

        } else {
            $root->addChild($translator->trans('layout.login', [], 'FOSUserBundle'), [
                'route' => 'fos_user_security_login'
            ])->setAttribute('icon', 'icon icon-sign-in');
        }
    }
    
    public function languageMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
    
        $this->addLanguageMenu($menu, $options);
    
        return $menu;
    }

    private function addLanguageMenu(ItemInterface $root, array $options)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $requestLocale = $request->getLocale();
        $locales = explode('|', $this->container->getParameter('app.locales'));

        $menu = $root->addChild('Language', [
            'label' => $this->localeName($requestLocale, $requestLocale)
        ])->setAttribute('dropdown', true);
        
        $route = $request->attributes->get('_route');
        if($route != null) {
            $routeParameters = $request->attributes->get('_route_params');
            $locales = array_filter($locales, function($elem) use ($requestLocale) {
               return $elem != $requestLocale; 
            });
            foreach ($locales as $locale) {
                $menu->addChild($this->localeName($locale, $locale), [
                    'route' => $route,
                    'routeParameters' => array_merge($routeParameters, ['_locale' => $locale])
                ])->setAttribute('dropdown_item', true);
            }
        }

        return $menu;
    }
    
    private function localeName($locale) {
        return ucfirst(Intl::getLocaleBundle()->getLocaleName($locale, $locale));
    }
    
    public function user2Menu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-sidebar');
    
        $securityChecker = $this->container->get('security.authorization_checker');
        $translator = $this->container->get('translator');
        if ($securityChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
    
            $menu->addChild($translator->trans('menu.user.edit'), [
                'route' => 'fos_user_profile_edit'
            ]);
    
            $menu->addChild($translator->trans('menu.user.changePassword'), [
                'route' => 'fos_user_change_password'
            ]);
    
            $menu->addChild($translator->trans('layout.logout', [], 'FOSUserBundle'), [
                'route' => 'fos_user_security_logout'
            ]);
        } else {
            $menu->addChild($translator->trans('layout.login', [], 'FOSUserBundle'), [
                'route' => 'fos_user_security_login'
            ]);
        }
    
        return $menu;
    }

}
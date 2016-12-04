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

        $menu->addChild('menu.home', [
            'route' => 'homepage'
        ]);

        $this->addBookingsMenu($menu);
        
        $menu->addChild('menu.contact', [
            'route' => 'contact'
        ]);

        $this->addUserMenu($menu);
        $this->addLanguageMenu($menu, $options);
        
        return $menu;
    }

    private function addBookingsMenu(ItemInterface $root)
    {
        if ($this->isUserAuthenticated())
        {
            $root->addChild('menu.bookings', [
                'route' => 'user_bookings'
            ]);
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
        if($this->isUserAuthenticated()) {
            $securityContext = $this->container->get('security.token_storage');
            $user = $securityContext->getToken()->getUser();

            $menu = $root->addChild('menu.settings')
                ->setAttribute('material-icon', 'settings')
                ->setAttribute('dropdown', true);

//            $menu->addChild('person.full_name', [
//                'uri' => "#"
//            ])
//                ->setExtra('translation_params', [
//                    '%forename%' => $user->getForename(),
//                    '%surname%' => $user->getSurname()
//                ])
//                ->setAttribute('dropdown_item', true);
        
            $menu->addChild('menu.user.edit', [
                'route' => 'fos_user_profile_edit'
            ])
                ->setAttribute('icon', 'fa fa-edit')
                ->setAttribute('dropdown_item', true);
            
            $menu->addChild('menu.user.changePassword', [
                'route' => 'fos_user_change_password'
            ])
                ->setAttribute('icon', 'fa fa-key')
                ->setAttribute('dropdown_item', true);

            if($user->isOwner())
            {
                $menu->addChild('menu.hostel.register', [
                    'route' => 'hostel_registration'
                ])->setAttribute('dropdown_item', true);
            }
        
            $menu->addChild('layout.logout', [
                'route' => 'fos_user_security_logout'
            ])
                ->setExtra('translation_domain', 'FOSUserBundle')
                ->setAttribute('icon', 'fa fa-sign-out')
                ->setAttribute('dropdown_item', true);

        } else {
            $root->addChild('layout.login', [
                'route' => 'fos_user_security_login'
            ])
                ->setExtra('translation_domain', 'FOSUserBundle')
                ->setAttribute('icon', 'fa fa-sign-in');
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
        ])
            ->setExtra('translation_domain', false)
            ->setAttribute('material-icon', 'translate')
            ->setAttribute('dropdown', true);
        
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
                ])
                    ->setExtra('translation_domain', false)
                    ->setAttribute('dropdown_item', true);
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

        if ($this->isUserAuthenticated()) {
    
            $menu->addChild('menu.user.edit', [
                'route' => 'fos_user_profile_edit'
            ]);
    
            $menu->addChild('menu.user.changePassword', [
                'route' => 'fos_user_change_password'
            ]);
    
            $menu->addChild('layout.logout', [
                'route' => 'fos_user_security_logout'
            ])->setExtra('translation_domain', 'FOSUserBundle');
        } else {
            $menu->addChild('layout.login', [
                'route' => 'fos_user_security_login'
            ])->setExtra('translation_domain', 'FOSUserBundle');
        }
    
        return $menu;
    }

    private function isUserAuthenticated() {
        $securityChecker = $this->container->get('security.authorization_checker');
        return $securityChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
    }
}
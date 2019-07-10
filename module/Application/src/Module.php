<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;


class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);
        $params = $matchedRoute->getParams();

       if(isset($params['lang']) && $params['lang'] !== '') {

       $translator = $e->getApplication()->getServiceManager()->get('MvcTranslator');

       if($params['lang'] == 'en') {
           $translator->setLocale('en_US');
       } elseif ($params['lang'] == 'fr'){
           $translator->setLocale('fr_FR');
       } elseif ($params['lang'] == 'de'){
           $translator->setLocale('de_DE');
       }

       }

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);


    }
}

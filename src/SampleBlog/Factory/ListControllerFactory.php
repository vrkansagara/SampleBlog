<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 1:02 AM
 */

namespace SampleBlog\Factory;


use SampleBlog\Controller\ListController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $postService = $realServiceLocator->get('SampleBlog\Service\PostServiceInterface');

        return new ListController($postService);
    }

}
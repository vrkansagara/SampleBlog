<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 2:23 AM
 */

namespace SampleBlog\Factory;


use SampleBlog\Service\PostService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PostService($serviceLocator->get('SampleBlog\Mapper\PostMapperInterface'));
    }

}
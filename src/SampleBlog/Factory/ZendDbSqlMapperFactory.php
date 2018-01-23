<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 2:52 AM
 */

namespace SampleBlog\Factory;


use SampleBlog\Mapper\ZendDbSqlMapper;
use SampleBlog\Model\Post;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ZendDbSqlMapperFactory implements FactoryInterface
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
        return new ZendDbSqlMapper(
            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
            new ClassMethods(false),
            new Post()
        );
    }
}
<?php

namespace SampleBlog\Factory;

use SampleBlog\Mapper\ZendDbSqliteMapper;
use SampleBlog\Model\Post;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class ZendDbSqliteMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = array(
            'driver' => 'Pdo_Sqlite',
            'database' => __DIR__ . '/../../../data/post.db'
        );
        $adapter = new \Zend\Db\Adapter\Adapter($dbAdapter);
        return new ZendDbSqliteMapper(
            $adapter,
            new ClassMethods(),
            new Post()
        );
    }
}
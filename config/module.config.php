<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'controllers' => array(
        'factories' => array(
            'SampleBlog\Controller\List' => 'SampleBlog\Factory\ListControllerFactory'
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'SampleBlog\Service\PostServiceInterface' => 'SampleBlog\Factory\PostServiceFactory',
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
//            'SampleBlog\Mapper\PostMapperInterface' => 'SampleBlog\Factory\ZendDbSqlMapperFactory',
            'SampleBlog\Mapper\PostMapperInterface' => 'SampleBlog\Factory\ZendDbSqliteMapperFactory',//Uncomment while you want to use db-engine as Sqlite.
        )
    ),

    // This lines opens the configuration for the RouteManager
    'router' => array(
        // Open configuration for all possible routes
        'routes' => array(
            // Define a new route called "post"
            'sampleblog' => array(
                // Define the routes type to be "Zend\Mvc\Router\Http\Literal", which is basically just a string
                'type' => 'Segment',
                // Configure the route itself
                'options' => array(
                    // Listen to "/blog" as uri
                    'route' => '/sampleblog[/action/:action][/id/:id][/page/:page][/status/:status]',
                    // Define default controller and action to be called when this route is matched
                    'defaults' => array(
                        '__NAMESPACE__' => 'SampleBlog\Controller',
                        'controller' => 'List',
                        'action' => 'index',
                        'page' => 1,
                        'status' => 1,
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                        'page' => '[0-9]*',
                        'status' => '[0-2]', //[Inactive,Active,Both]
                    ),
                )
            )
        )
    )
);
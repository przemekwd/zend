<?php

namespace Album;

use Zend\Db\Adapter\AdapterInterface as AdapterInterface;
use Zend\Db\ResultSet\ResultSet as ResultSet;
use Zend\Db\TableGateway\TableGateway as TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface as ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AlbumTable::class => function($container) {
                    $tableGateway = $container->get(Model\AlbumTableGateway::class);
                    return new Model\AlbumTable($tableGateway);
                },
                Model\AlbumTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
                Model\ArtistTable::class => function($container) {
                    $tableGateway = $container->get(Model\ArtistTableGateway::class);
                    return new Model\ArtistTable($tableGateway);
                },
                Model\ArtistTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Artist());
                    return new TableGateway('artist', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlbumController::class => function($container) {
                    return new Controller\AlbumController(
                        $container->get(Model\AlbumTable::class)
                    );
                },
                Controller\ArtistController::class => function($container) {
                    return new Controller\ArtistController(
                        $container->get(Model\ArtistTable::class)
                    );
                }
            ],
        ];
    }
}


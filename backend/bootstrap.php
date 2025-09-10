<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;

$config = require_once __DIR__ . '/config.php';

// Create a simple "default" Doctrine ORM configuration for Attributes
$isDevMode = true;

$paths = [__DIR__ . "/DB/Entities"];

$configORM = new Configuration();

$driver = new AttributeDriver($paths);

$driverChain = new MappingDriverChain();
$driverChain->addDriver($driver, 'DB\Entities');

$configORM->setMetadataDriverImpl($driverChain);
$configORM->setProxyDir(__DIR__ . '/Proxies');
$configORM->setProxyNamespace('Proxies');
$configORM->setAutoGenerateProxyClasses($isDevMode);

// database configuration parameters
$conn = DriverManager::getConnection($config);

use Doctrine\ORM\EntityManagerInterface;

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $configORM);

return $entityManager;

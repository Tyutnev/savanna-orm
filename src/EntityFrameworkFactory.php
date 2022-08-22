<?php

namespace Tyutnev\SavannaOrm;

use Symfony\Component\Yaml\Yaml;
use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;
use Tyutnev\SavannaOrm\Type\ConnectionContextInterface;
use Tyutnev\SavannaOrm\Type\ConnectionFactoryInterface;

class EntityFrameworkFactory
{
    /**
     * @throws EntityFrameworkException
     */
    public function factory(?string $connectionName = null, string $configPath = '/config/savanna-orm.yaml'): EntityFramework
    {
        $result = Yaml::parseFile(__DIR__ . '/..' . $configPath);

        if (!isset($result['orm'])) {
            throw new EntityFrameworkException('Config root key "orm" not defined in ' . $configPath);
        }

        $orm = $result['orm'];


        if ($connectionName === null && !isset($orm['default_connection'])) {
            throw new EntityFrameworkException('Config key "default_connection" not defined in ' . $configPath);
        }

        if ($connectionName === null && isset($orm['default_connection'])) {
            $connectionName = $orm['default_connection'];
        }

        if (!isset($orm['connections'])) {
            throw new EntityFrameworkException('Config key "connections" not defined in ' . $configPath);
        }

        $connections = $orm['connections'];
        if (!isset($connections[$connectionName])) {
            throw new EntityFrameworkException(
                sprintf(
                    'Connection name %s not defined in %s',
                    $connectionName,
                    $configPath
                )
            );
        }

        $connection = $connections[$connectionName];
        if (!isset($connection['handler'])) {
            throw new EntityFrameworkException('Config key "handler" in connection not defined in ' . $configPath);
        }

        $handler = $connection['handler'];
        unset($connection['handler']);

        $typeProvider = new TypeProvider();
        foreach ($this->getEntityFrameworkModules() as $module) {
            $namespace = $handler . '\\' . $module;

            if ($module === 'ConnectionContext') {
                /** @var ConnectionContextInterface $connectionContext */
                $connectionContext = new $namespace();
                $typeProvider->setConnectionContext($connectionContext);
            }

            if ($module === 'ConnectionFactory') {
                /** @var ConnectionFactoryInterface $connectionFactory */
                $connectionFactory = new $namespace(...$connection);
                $typeProvider->setConnectionEntry($connectionFactory->factory());
            }

            if ($module === 'LexicalConverter') {
                $lexicalConverter = new $namespace();
                $typeProvider->setLexicalConverter($lexicalConverter);
            }
        }

        return new EntityFramework($typeProvider);
    }

    private function getEntityFrameworkModules(): array
    {
        return [
            'ConnectionContext',
            'ConnectionFactory',
            'LexicalConverter',
        ];
    }
}
<?php

namespace App;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function getCacheDir()
    {
        return $this->getProjectDir().'/var/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return $this->getProjectDir().'/var/log';
    }

    public function registerBundles()
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir().'/config';
        $loader->load($confDir.'/packages/*'.self::CONFIG_EXTS, 'glob');
        if (is_dir($confDir.'/packages/'.$this->environment)) {
            $loader->load($confDir.'/packages/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        }
        $loader->load($confDir.'/services'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/services_'.$this->environment.self::CONFIG_EXTS, 'glob');
        $loader->load($this->getProjectDir().'/src/*/Infrastructure/Application/Command/command_handlers'.self::CONFIG_EXTS, 'glob');
        $loader->load($this->getProjectDir().'/src/*/Infrastructure/Application/Query/services'.self::CONFIG_EXTS, 'glob');

        $this->loadMappingsDoctrine($container);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir().'/config';
        if (is_dir($confDir.'/routes/')) {
            $routes->import($confDir.'/routes/*'.self::CONFIG_EXTS, '/', 'glob');
        }
        if (is_dir($confDir.'/routes/'.$this->environment)) {
            $routes->import($confDir.'/routes/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        }
        $routes->import($confDir.'/routes'.self::CONFIG_EXTS, '/', 'glob');
        // ADD API routes
        $routes->import($this->getProjectDir().'/src/*/Infrastructure/UI/API/Controller/routes.yaml', '/api', 'glob');
    }

    private function loadMappingsDoctrine(ContainerBuilder $container)
    {
        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        $finder = new Finder();
        $mappings = array();
        $alias = array();

        $finder->directories()->in($this->getProjectDir().'/src/');
        foreach ($finder as $dir) {
            if (file_exists($dir->getRealpath().'/Infrastructure/Persistence/Doctrine/Types')) {

            }
            if (file_exists($dir->getRealpath().'/Infrastructure/Persistence/Doctrine/Mapping')) {
                $mappings[$dir->getRealpath().'/Infrastructure/Persistence/Doctrine'] = 'App\\'.$dir->getFilename().'\\Domain\\Model';
                $alias[$dir->getFilename()] = 'App\\'.$dir->getFilename().'\\Domain\\Model';
            }
        }

        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createYamlMappingDriver(
                    $mappings,
                    array(),
                    false,
                    $alias
                )
            );
        }
    }
}

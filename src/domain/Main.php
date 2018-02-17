<?php
namespace EE\Gutenberg\domain;

use DomainException;
use EE\Gutenberg\domain\services\RegisterBlocks;
use EE_Addon;
use EE_Dependency_Map;
use EE_Error;
use EE_Register_Addon;
use EventEspresso\core\exceptions\InvalidDataTypeException;
use EventEspresso\core\exceptions\InvalidInterfaceException;
use EventEspresso\core\services\loaders\LoaderFactory;
use InvalidArgumentException;
use ReflectionException;

/**
 * Main
 * Main controller for the EE Gutenberg Experiments plugin
 *
 * @package EventEspresso\Gutenberg\domain
 * @author  Darren Ethier
 * @since   1.0.0
 */
class Main extends EE_Addon
{
    /**
     * @param Domain $domain
     * @throws DomainException
     * @throws EE_Error
     * @throws InvalidDataTypeException
     * @throws InvalidInterfaceException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public static function registerAddon(Domain $domain)
    {
        EE_Register_Addon::register(
            'EventEspresso_Gutenberg',
            array(
                'class_name' => self::class,
                'version' => EE_GUT_VERSION,
                'plugin_slug' => 'eea_saas_subscription_management',
                'min_core_version' => Domain::CORE_VERSION_REQUIRED,
                'main_file_path' => $domain->pluginFile(),
                'domain_fqcn' => Domain::class
            )
        );
    }


    public function after_registration()
    {
        $this->registerDependencies();
        add_action('AHEE__EE_System__core_loaded_and_ready', function () {
            LoaderFactory::getLoader()->getShared(RegisterBlocks::class);
        });
    }


    protected function registerDependencies()
    {
        $this->dependencyMap()->registerDependencies(
            RegisterBlocks::class,
            array(
                Domain::class => EE_Dependency_Map::load_from_cache
            )
        );
    }
}

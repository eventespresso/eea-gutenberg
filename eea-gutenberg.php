<?php
/**
 * Plugin Name: Gutenberg - Event Espresso Integration
 * Plugin URI: https://eventespresso.com
 * Description: Add-on for experiments with Event Espresso - Gutenberg integration.
 * Version: 1.2.1.rc.001
 * Author: Darren Ethier
 * Author URI: http://roughsmootheng.in
 * Copyright 2018 Event Espresso (email: support@eventespresso.com)
 */

use EventEspresso\core\domain\DomainFactory;
use EventEspresso\core\domain\values\FilePath;
use EventEspresso\core\domain\values\FullyQualifiedName;
use EventEspresso\core\domain\values\Version;
use EE\Gutenberg\domain\Domain as AddonDomain;
use EE\Gutenberg\domain\Main;
use EventEspresso\core\exceptions\InvalidClassException;
use EventEspresso\core\exceptions\InvalidDataTypeException;
use EventEspresso\core\exceptions\InvalidFilePathException;
use EventEspresso\core\exceptions\InvalidInterfaceException;

//define versions and this file
define('EE_GUT_VERSION', '1.0.1');
define('EE_GUT_PLUGIN_FILE', __FILE__);

include 'vendor/autoload.php';

/**
 *    captures plugin activation errors for debugging
 */
function eeGutenbergPluginActivationErrors()
{
    if (WP_DEBUG && ob_get_length() > 0) {
        $activation_errors = ob_get_contents();
        file_put_contents(
            EVENT_ESPRESSO_UPLOAD_DIR . 'logs' . DS . 'eea-gutenberg.html',
            $activation_errors
        );
    }
}

add_action('activated_plugin', 'eeGutenbergPluginActivationErrors');

/**
 * @throws DomainException
 * @throws EE_Error
 * @throws InvalidArgumentException
 * @throws ReflectionException
 * @throws InvalidClassException
 * @throws InvalidDataTypeException
 * @throws InvalidFilePathException
 * @throws InvalidInterfaceException
 */
function loadEeGutenberg()
{
    if (
        defined('GUTENBERG_VERSION')
        && class_exists('EE_Addon')
        && version_compare(EVENT_ESPRESSO_VERSION, '4.9.57.p', '>')
    ) {
        //register dependencies for main Addon class
        EE_Dependency_Map::register_dependencies(
            Main::class,
            array(
                EE_Dependency_Map::class => EE_Dependency_Map::load_from_cache,
                AddonDomain::class => EE_Dependency_Map::load_from_cache
            )
        );
        Main::registerAddon(
            DomainFactory::getShared(
                new FullyQualifiedName(AddonDomain::class),
                array(
                    new FilePath(EE_GUT_PLUGIN_FILE),
                    Version::fromString(EE_GUT_VERSION)
                )
            )
        );
    } else {
        add_action('admin_notices', 'eeGutenbergActivationError');
    }
}
add_action('AHEE__EE_System__load_espresso_addons', 'loadEeGutenberg');


function eeGutenbergVerifyEventEspressoActivatedCheck()
{
    if (! did_action('AHEE__EE_System__load_espresso_addons')) {
        add_action('admin_notices', 'eeGutenbergActivationError');
    }
}
add_action('init', 'eeGutenbergVerifyEventEspressoactivatedCheck', 1);


function eeGutenbergActivationError()
{
    unset($_GET['activate'], $_REQUEST['activate']);
    if (! function_exists('deactivate_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    deactivate_plugins(plugin_basename(EE_GUT_PLUGIN_FILE));
    ?>
    <div class="error">
        <p><?php printf(
                esc_html__(
                    'EE Gutenberg Experiments could not be activated. Please ensure that the Gutenberg plugin is activated and Event Espresso version %1$s or higher is active on your site.',
                    'event_espresso'
                ),
                '4.9.57.p'
            );
            ?></p>
    </div>
    <?php
}

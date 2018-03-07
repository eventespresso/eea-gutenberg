<?php
namespace EE\Gutenberg\domain\services;

use EE\Gutenberg\domain\Domain;
use EE_Error;
use EventEspresso\core\domain\entities\shortcodes\EspressoEvents;
use EventEspresso\core\exceptions\InvalidDataTypeException;
use EventEspresso\core\exceptions\InvalidInterfaceException;
use EventEspresso\core\services\loaders\LoaderFactory;
use InvalidArgumentException;
use WP_Block_Type;

/**
 * RegisterBlocks
 * Takes care of registering custom EE blocks and necessary scripts.
 *
 * @package EE\Gutenberg\domain\services
 * @author  Darren Ethier
 * @since   1.0.0
 */
class RegisterBlocks
{

    /**
     * @var Domain
     */
    private $domain;

    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
        $this->init();
    }


    private function init()
    {
        wp_register_script(
            'ee-shortcode-blocks',
            $this->domain->assetsUrl() . 'dist/ee-shortcode-blocks.dist.js',
            array('wp-blocks'),
            filemtime($this->domain->pluginPath() . 'src/assets/dist/ee-shortcode-blocks.dist.js')
        );

        wp_register_script(
            'ee-event-editor-blocks',
            $this->domain->assetsUrl() . 'dist/ee-event-editor-blocks.dist.js',
            array('wp-blocks'),
            filemtime($this->domain->pluginPath() . 'src/assets/dist/ee-event-editor-blocks.dist.js')
        );

        wp_register_style(
            'ee-block-styles',
            $this->domain->assetsUrl() . 'dist/style.css',
            array(),
            filemtime($this->domain->pluginPath() . 'src/assets/dist/style.css')
        );

        register_block_type(
            new WP_Block_Type(
                'ee-event-editor/ticket-editor-container',
                array(
                    'editor_script' => 'ee-event-editor-blocks',
                    'editor_style' => 'ee-block-styles',
                    'attributes' => array(),
                )
            )
        );

        register_block_type(
            new WP_Block_Type(
                'ee-event-editor/venue-container',
                array(
                    'editor_script' => 'ee-event-editor-blocks',
                    'editor_style' => 'ee-block-styles',
                    'attributes' => array(),
                )
            )
        );

    }

}

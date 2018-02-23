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

        register_block_type(
            new WP_Block_Type(
                'ee-shortcodes/events-list',
                array(
                    'editor_script' => 'ee-shortcode-blocks',
                    'editor_style' => 'ee-block-styles',
                    'render_callback' => array($this, 'eventListRender'),
                    'attributes' => array(
                        'title' => array(
                            'type' => 'string'
                        ),
                        'limit' => array(
                            'type' => 'integer',
                            'default' => 10
                        ),
                        'cssClass' => array(
                            'type' => 'string'
                        ),
                        'showExpired' => array(
                            'type' => 'boolean',
                            'default' => false
                        ),
                        'month' => array(
                            'type' => 'string',
                        ),
                        'categorySlug' => array(
                            'type' => 'string',
                        ),
                        'orderBy' => array(
                            'type' => 'string',
                            'enum' => array('start_date', 'ticket_start', 'ticket_end', 'venue_title', 'city', 'state'),
                            'default' => 'start_date'
                        ),
                        'order' => array(
                            'type' => 'string',
                            'default' => 'ASC',
                            'enum' => array('ASC', 'DESC')
                        ),
                        'showTitle' => array(
                            'type' => 'boolean',
                            'default' => true
                        )
                    )
                )
            )
        );
    }


    /**
     * @param array $attributes
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidDataTypeException
     * @throws InvalidInterfaceException
     * @throws EE_Error
     */
    public function eventListRender(array $attributes = array())
    {
        /** @var EspressoEvents $shortcode */
        $shortcode = LoaderFactory::getLoader()->getShared(EspressoEvents::class);
        $attributes = $this->mapAttributes($attributes);
        return $shortcode->processShortcodeCallback($attributes);
    }


    /**
     * Maps new style block attributes to old style shortcode attribute keys.
     * @param array $attributes
     * @return array
     */
    private function mapAttributes(array $attributes)
    {
        $replacements = array(
            'cssClass' => 'css_class',
            'showExpired' => 'show_expired',
            'categorySlug' => 'category_slug',
            'orderBy' => 'order_by',
            'order' => 'sort',
            'showTitle' => 'show_title'
        );
        $new_attributes = array();
        array_walk($attributes, function ($value, $key) use (&$new_attributes, $replacements) {
            $new_key = isset($replacements[$key]) ? $replacements[$key] : $key;
            $value = $value === 'none' ? null : $value;
            $new_attributes[$new_key] = $value;
        });
        return $new_attributes;
    }
}

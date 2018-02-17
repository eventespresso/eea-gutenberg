<?php
namespace EE\Gutenberg\domain\services;

use EE\Gutenberg\domain\Domain;
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
            'ee-shortcodes-events-list',
            $this->domain->assetsUrl() . 'dist/ee-blocks.dist.js',
            array('wp-blocks'),
            filemtime($this->domain->pluginPath() . 'src/assets/dist/ee-blocks.dist.js')
        );

        register_block_type(
            new WP_Block_Type(
                'ee-shortcodes/events-list',
                array(
                    'editor_script' => 'ee-shortcodes-events-list',
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


    public function eventListRender($attributes)
    {
        //@todo connect this with the existing shortcode render, from the shortcodes class but remember attributes will
        //be what is defined (see above).
    }
}

<?php
namespace EE\Gutenberg\domain\services;

use EE\Gutenberg\domain\Domain;
use WP_Post_Type;

/**
 * Initialize
 * This sets all the hooks required for Gutenberg integration with various aspects of EE.
 *
 * @package EE\Gutenberg\domain\services
 * @author  Darren Ethier
 * @since   1.0.0
 */
class Initialize
{

    /**
     * @var Domain
     */
    private $domain;


    /**
     * Initialize constructor.
     *
     * @param Domain $domain
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
        $this->init();
    }


    private function init()
    {
        //replace EE_CPT editors with gutenberg
        add_action('AHEE__EE_System__load_CPTs_and_session__complete', array($this, 'earlySetupForGutenberg'));
        add_filter(
            'FHEE__EE_Admin_Page_CPT___create_new_cpt_item__replace_editor',
            array($this, 'gutenbergInit'),
            10,
            2
        );
        add_action('admin_url', array($this, 'coerceEeCptEditorUrlForGutenberg'), 10, 3);/**/
    }




    public function earlySetupForGutenberg()
    {
        $this->manipulateEePostTypeForGutenberg();
    }


    /**
     * Integrate gutenberg with the post editor.
     *
     * @param $return
     * @param $post
     * @return bool
     */
    public function gutenbergInit($return, $post)
    {
        if (isset($_GET['with_gutenberg']) && function_exists('gutenberg_init')) {
            gutenberg_init($return, $post);
            return true;
        }
        return $return;
    }


    /**
     * Manipulate globals related to EE Post Type so gutenberg loads.
     */
    private function manipulateEePostTypeForGutenberg()
    {
        global $wp_post_types, $_wp_post_type_features;
        $post_types_to_edit = array(
            'espresso_events',
            'espresso_venues',
            'espresso_attendees'
        );
        foreach ($post_types_to_edit as $post_type) {
            $_wp_post_type_features[$post_type]['editor'] = true;
            $post_type_object = ! empty($wp_post_types[$post_type]) && $wp_post_types[$post_type] instanceof WP_Post_Type
                ? $wp_post_types[$post_type]
                : null;
            if ($post_type_object instanceof WP_Post_Type) {
                $post_type_object->show_in_rest = true;
            }
        }
    }


    public function coerceEeCptEditorUrlForGutenberg($url, $path, $blog_id)
    {
        if (isset($_REQUEST['page'], $_REQUEST['action'])
            && $_REQUEST['page'] === 'espresso_events'
            && ($_REQUEST['action'] === 'edit'
                || $_REQUEST['action'] === 'create_new'
            )
            && strpos($path, 'post.php') !== false
        ) {
            return add_query_arg(
                array(
                    'page' => $_REQUEST['page'],
                    'action' => $_REQUEST['action']
                ),
                get_site_url($blog_id)
            );
        }
        return $url;
    }
}
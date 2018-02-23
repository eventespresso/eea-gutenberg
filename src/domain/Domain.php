<?php
namespace EE\Gutenberg\domain;

use EventEspresso\core\domain\DomainBase;

/**
 * Domain
 *
 *
 * @package EE\Gutenberg\domain
 * @author  Darren Ethier
 * @since   1.0.0
 */
class Domain extends DomainBase
{
    const CORE_VERSION_REQUIRED = '4.9.57.p';

    /**
     * @return string
     */
    public function assetsUrl()
    {
        return $this->pluginUrl() . 'src/assets/';
    }
}
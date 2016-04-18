<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 8:01 PM
 */

class ProductsPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Products');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'David Cannon';
    }

    function getDeveloperUrl()
    {
        return 'http://www.creditcards.com';
    }

    function getDocumentationUrl() {
        return 'http://confluence.in.creditcards.com';
    }

    public function hasCpSection()
    {
        return true;
    }

    public function registerCpRoutes()
    {
        return array(
            'products' => 'products/products/index',
            'products/edit' => 'products/products/edit',
            'products/update' => 'products/products/update'
        );
    }
}
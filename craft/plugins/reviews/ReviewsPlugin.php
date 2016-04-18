<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 8:01 PM
 */

class ReviewsPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Reviews');
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
            'reviews'                               => array('action' => 'reviews/dashboard/index'),
            'reviews/dashboard/index'               => array('action' => 'reviews/dashboard/index'),

            'reviews/issuers/index'                 => array('action' => 'reviews/issuer/index'),
            'reviews/issuers/new'                   => 'reviews/issuers/create',
            'reviews/issuers/edit'                  => array('action' => 'reviews/issuer/edit'),
            'reviews/issuers/save'                  => array('action' => 'reviews/issuer/save'),
            'reviews/issuers/delete'                => array('action' => 'reviews/issuer/delete'),

            'reviews/maps/index'                     => array('action' => 'reviews/idMap/index'),
            'reviews/maps/new'                      => 'reviews/maps/create',
            'reviews/maps/edit'                     => array('action' => 'reviews/idMap/edit'),
            'reviews/maps/save'                     => array('action' => 'reviews/idMap/save'),
            'reviews/maps/delete'                   => array('action' => 'reviews/idMap/delete'),

            'reviews/parsers/index'                 => array('action' => 'reviews/parser/index'),
            'reviews/parsers/new'                   => 'reviews/parsers/create',
            'reviews/parsers/edit'                  => array('action' => 'reviews/parser/edit'),
            'reviews/parsers/save'                  => array('action' => 'reviews/parser/save'),
            'reviews/parsers/delete'                => array('action' => 'reviews/parser/delete'),
        );
    }
}
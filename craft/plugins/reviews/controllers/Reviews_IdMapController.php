<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Reviews_IdMapController extends BaseController
{

    protected $allowAnonymous = false;

    /**
     * @throws HttpException
     */
    public function actionIndex() {
        $maps = craft()->reviews_idMap->getMaps();

        $mapArray = [];
        foreach($maps as $map) {
            $attributes = [];
            foreach($map->getAttributes() as $key=>$value) {
                $attributes[$key]=$value;
            }
            $attributes['reviews'] = craft()->reviews_review->getReviewCount(['Product ID'=>$attributes['alt_id']]);
            $mapArray[]=$attributes;

        }

        $this->renderTemplate('reviews/maps/index', ['maps'=>$mapArray]);
    }

    /**
     * @throws HttpException
     */
    public function actionEdit()
    {
        $mapId = craft()->request->getParam('id');

        $variables['map'] = craft()->reviews_idMap->getMapById($mapId);

        if (!$variables['map'])
        {
            throw new HttpException(404);
        }

        $variables['title'] = $variables['map']->name;

        $variables['crumbs'] = array(
            array('label' => Craft::t('Maps'), 'url' => UrlHelper::getUrl('maps')),
        );

        $this->renderTemplate('reviews/maps/edit', $variables);

    }

    /**
     * Saves a map
     */
    public function actionSave()
    {
        $this->requirePostRequest();

        $mapId = craft()->request->getPost('id');

        if($mapId) {
            $map = craft()->reviews_idMap->getMapById($mapId);
        }
        else {
            $map = new Reviews_IdMapModel();
        }

        // Shared attributes
        $map->name      = craft()->request->getPost('name');
        $map->card_id   = craft()->request->getPost('card_id');
        $map->alt_id    = craft()->request->getPost('alt_id');
        $map->active    = craft()->request->getPost('active');

        // Save it
        if (craft()->reviews_idMap->saveMap($map))
        {
            craft()->userSession->setNotice(Craft::t('Map saved.'));
            $this->redirectToPostedUrl($map);
        }
        else
        {
            craft()->userSession->setError(Craft::t('Couldn’t save map.'));
        }

        // Send the calendar back to the template
        craft()->urlManager->setRouteVariables(array(
            'map' => $map
        ));
    }

    /**
     * Deletes a map.
     */
    public function actionDelete()
    {
        $this->requirePostRequest();
        $this->requireAjaxRequest();

        $mapId = craft()->request->getRequiredPost('id');

        craft()->reviews_idMap->deleteMapById($mapId);

        $this->returnJson(array('success' => true));
    }

}
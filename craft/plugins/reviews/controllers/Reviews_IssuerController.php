<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Reviews_IssuerController extends BaseController
{
    protected $allowAnonymous = false;


    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        $issuers = craft()->reviews_issuer->getIssuers();

        $issuerArray = [];
        foreach($issuers as $issuer) {
            $attributes = [];
            foreach($issuer->getAttributes() as $key=>$value) {
                $attributes[$key]=$value;
            }
            $attributes['reviews'] = craft()->reviews_review->getReviewCount(['issuer'=>$attributes['name']]);
            $issuerArray[]=$attributes;

        }

        $this->renderTemplate('reviews/issuers/index', ['issuers'=>$issuerArray]);
    }


    /**
     * Edit Issuer
     * @throws HttpException
     */
    public function actionEdit()
    {
        $issuerId = craft()->request->getParam('id');

        $variables['issuer'] = craft()->reviews_issuer->getIssuerById($issuerId);

        if (!$variables['issuer'])
        {
            throw new HttpException(404);
        }

        $variables['title'] = $variables['issuer']->name;

        $variables['crumbs'] = array(
            array('label' => Craft::t('issuers'), 'url' => UrlHelper::getUrl('reviews/issuers/index')),
        );

        $this->renderTemplate('reviews/issuers/edit', $variables);

    }

    /**
     * Saves a issuer
     */
    public function actionSave()
    {
        $this->requirePostRequest();

        $issuerId = craft()->request->getPost('id');

        if($issuerId) {
            $issuer = craft()->reviews_issuer->getIssuerById($issuerId);
        }
        else {
            $issuer = new Reviews_IssuerModel();
        }

        // Shared attributes
        $issuer->name       = craft()->request->getPost('name');
        $issuer->active     = craft()->request->getPost('active');

        // Save it
        if (craft()->reviews_issuer->saveIssuer($issuer))
        {
            craft()->userSession->setNotice(Craft::t('Issuer saved.'));
            $this->redirectToPostedUrl($issuer);
        }
        else
        {
            craft()->userSession->setError(Craft::t('Couldn’t save issuer.'));
        }

        // Send the calendar back to the template
        craft()->urlManager->setRouteVariables(array(
            'issuer' => $issuer
        ));
    }

    /**
     * Deletes a issuer.
     */
    public function actionDelete()
    {
        $this->requirePostRequest();
        $this->requireAjaxRequest();

        $issuerId = craft()->request->getRequiredPost('id');

        craft()->reviews_issuer->deleteIssuerById($issuerId);

        $this->returnJson(array('success' => true));
    }
}
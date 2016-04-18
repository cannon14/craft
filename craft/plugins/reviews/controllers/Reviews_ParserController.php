<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Reviews_ParserController extends BaseController
{
    protected $allowAnonymous = false;


    /**
     * Saves a issuer
     */
    public function actionSave()
    {
        $this->requirePostRequest();

        $parserId = craft()->request->getPost('id');

        if($parserId) {
            $parser = craft()->reviews_parser->getParserById($parserId);
        }
        else {
            $parser = new Reviews_ParserModel();
        }

        // Shared attributes
        $parser->name       = craft()->request->getPost('name');
        $parser->issuer_id       = craft()->request->getPost('issuer_id');
        $parser->description       = craft()->request->getPost('description');
        $parser->active     = craft()->request->getPost('active');

        $columns = [];
        $index = 1;
        do {
            $columns[] = craft()->request->getPost('column'.$index);
            $index++;
        }
        while(null != craft()->request->getPost('column'.$index));

        $parser->columns = json_encode($columns);

        // Save it
        if (craft()->reviews_parser->saveParser($parser))
        {
            craft()->userSession->setNotice(Craft::t('Parser saved.'));
            $this->redirectToPostedUrl($parser);
        }
        else
        {
            craft()->userSession->setError(Craft::t('Couldn’t save parser.'));
        }

        // Send the calendar back to the template
        craft()->urlManager->setRouteVariables(array(
            'parser' => $parser
        ));
    }

    /**
     * Edit Parser
     * @throws HttpException
     */
    public function actionEdit()
    {
        $parserId = craft()->request->getParam('id');

        $parser = craft()->reviews_parser->getParserById($parserId);
        $parser->columns = json_decode($parser->columns, true);

        $variables['parser'] = $parser;

        if (!$variables['parser'])
        {
            throw new HttpException(404);
        }

        $variables['title'] = $variables['parser']->name;

        $variables['crumbs'] = array(
            array('label' => Craft::t('Parsers'), 'url' => UrlHelper::getUrl('parsers')),
        );

        $this->renderTemplate('reviews/parsers/edit', $variables);

    }

    /**
     * Deletes a parser.
     */
    public function actionDelete()
    {
        $this->requirePostRequest();
        $this->requireAjaxRequest();

        $parserId = craft()->request->getRequiredPost('id');

        craft()->reviews_parser->deleteParserById($parserId);

        $this->returnJson(array('success' => true));
    }
}
<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class ProductFeeds_FeedController extends BaseController
{
    protected $allowAnonymous = false;

    private $feedService;

    function __construct() {
        $this->feedService = new ProductFeeds_FeedService();
    }

    /**
     * Feeds Index Page
     * @throws HttpException
     */
    public function actionIndex() {

        $feeds = craft()->productFeeds_feed->getFeeds();

        $this->renderTemplate('productFeeds/index.html', ['feeds'=>$feeds]);

    }

    /**
     * Display feed creation form.
     * @throws HttpException
     */
    public function actionCreate() {

        $this->renderTemplate('productFeeds/create.html');

    }

    /**
     * Store newly created feed
     * @throws HttpException
     */
    public function actionStore() {
        $this->requirePostRequest();

        $params['id'] = craft()->request->getPost('id');
        $params['name'] = craft()->request->getPost('name');
        $params['url'] = craft()->request->getPost('url');
        $params['key'] = craft()->request->getPost('key');
        $params['active'] = craft()->request->getPost('status');

        //Create a feed model
        $feed = new ProductFeeds_FeedModel();

        //Attempt to store the feed
        if ($this->feedService->store($params))
        {
            craft()->userSession->setNotice(Craft::t('Feed Created.'));
            $this->redirectToPostedUrl();
        }
        else
        {
            // Prepare a flash error message for the user.
            craft()->userSession->setError(Craft::t('Couldn’t create Feed.'));

            // Make the feed model available to the template as a 'feed' variable,
            // since it contains the user's dumb input as well as the validation errors.
            craft()->urlManager->setRouteVariables(array(
                'feed' => $feed
            ));
        }
    }

    public function actionEdit() {
        $feedId = craft()->request->getRequiredParam('id');

        $feed = craft()->productFeeds_feed->getFeed($feedId);

        $this->renderTemplate('productFeeds/edit.html', ['feed'=>$feed]);

    }

    public function actionUpdate() {

        $params['id'] = craft()->request->getPost('id');
        $params['name'] = craft()->request->getPost('name');
        $params['url'] = craft()->request->getPost('url');
        $params['key'] = craft()->request->getPost('key');
        $params['active'] = craft()->request->getPost('status');

        $feed = new ProductFeeds_FeedModel();
        $feed = $feed->populateModel($params);

        if ($this->feedService->update($params))
        {
            craft()->userSession->setNotice(Craft::t('Feed updated.'));
            $this->redirectToPostedUrl();
        }
        else
        {
            // Prepare a flash error message for the user.
            craft()->userSession->setError(Craft::t('Couldn’t save feed.'));

            // Make the ingredient model available to the template as an 'ingredient' variable,
            // since it contains the user's dumb input as well as the validation errors.
            craft()->urlManager->setRouteVariables(array(
                'feed' => $feed
            ));
        }
    }

    public function actionDelete() {
        $feedId = craft()->request->getRequiredParam('id');

        if ($this->feedService->delete($feedId))
        {
            craft()->userSession->setNotice(Craft::t('Feed Deleted.'));
            $this->redirectToPostedUrl();
        }

    }
}
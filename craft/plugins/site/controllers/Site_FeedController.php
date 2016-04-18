<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Site_FeedController extends BaseController
{
    protected $allowAnonymous = false;

    public function actionPullCards() {

        $categories = craft()->elements->getCriteria(ElementType::Category)->find();

        $feedService = new Site_FeedService();
        $errors = $feedService->pullCreditCardsFromFeed();

        if(empty($errors)) {
            craft()->userSession->setNotice(Craft::t('Cards Updated from feed.'));
            $this->redirectToPostedUrl();
        }
        else {
            // Prepare a flash error message for the user.
            craft()->userSession->setError(Craft::t("Couldn’t update card."));

            // Make the ingredient model available to the template as an 'ingredient' variable,
            // since it contains the user's dumb input as well as the validation errors.
            craft()->urlManager->setRouteVariables(array(
                'errors' => $errors
            ));
        }

    }

    public function actionPullCategories() {
        $feedService = new Site_FeedService();
        $status = $feedService->pullCreditcardsCategoriesFromFeed();

        craft()->userSession->setNotice(Craft::t('Category Card Rankings Updated from feed.'));

        $this->redirectToPostedUrl();
    }
}
<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Products_CreditcardController extends BaseController
{
    protected $allowAnonymous = true;

    /**
     * Edit a card
     * @throws HttpException
     */
    public function actionEdit()
    {
        $cardId = craft()->request->getRequiredParam('id');

        $card = craft()->products_creditcard->getCard($cardId);

        $this->renderTemplate('products/products/edit', ['card' => $card]);
    }

    /**
     * Update a card
     * @throws HttpException
     */
    public function actionUpdate()
    {
        $this->requirePostRequest();

        $model = new Products_CreditcardModel();
        $card = $model->populateModel($_POST);

        if($card->validate()) {
            if (craft()->products_creditcard->update($card)) {
                craft()->userSession->setNotice(Craft::t('Card updated.'));
                $this->redirectToPostedUrl();
            } else {
                // Prepare a flash error message for the user.
                craft()->userSession->setError(Craft::t("Couldn’t update card."));

                // Make the ingredient model available to the template as an 'ingredient' variable,
                // since it contains the user's dumb input as well as the validation errors.
                craft()->urlManager->setRouteVariables(array(
                    'card' => $card
                ));
            }
        }
        else {
            // Here's a list of all the errors, grouped by attribute:
            $errors = $card->getErrors();

            craft()->urlManager->setRouteVariables(array(
                'card' => $card,
                'errors' => $errors
            ));
        }
    }
}
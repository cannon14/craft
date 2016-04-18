<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Reviews_ReviewController extends BaseController
{
    protected $allowAnonymous = false;

    protected $valid_extensions = array('csv');
    protected $assetSourceId = 1;

    /**
     * Upload a file
     *
     * @throws HttpException
     */
    public function actionUpload()
    {
        $this->requireAjaxRequest();
        $file = null;
        $errors = array();
        $success = array();

        $issuer = craft()->request->getPost('issuer');
        $uploadDir = __DIR__.'/../uploads/';
        $filename = null;

        foreach ($_FILES as $file)
        {
            if (!$file['error'][0])
            {
                $filename = $file['name'][0];
                $file = $file['tmp_name'][0];
                $extension = IOHelper::getExtension($filename);
                if (!in_array($extension, $this->valid_extensions))
                {
                    $errors[] = "$filename has an invalid extension.";
                    continue;
                }


                if (IOHelper::copyFile($file, $uploadDir . $filename))
                {
                    IOHelper::deleteFile($file);
                    $success[] = "$filename was saved.";
                }
                else
                {
                    $errors[] = "$filename was unable to be saved.";
                    continue;
                }
            }
        }

        $status = craft()->reviews_review->parseFile($issuer, $uploadDir . $filename);

        $this->returnJSON(compact('success', 'errors'));
    }

    /**
     * Disable reviews;
     * @throws HttpException
     */
    public function actionDisable() {
        $this->requireAjaxRequest();

        $issuer = craft()->request->getPost('issuer');

        if(empty($issuer)) {
            $this->returnErrorJson('Select an Issuer');
        }

        $filter=[];
        if($issuer != 'all') {
            $filter['issuer']=$issuer;
        }

        $status = craft()->reviews_review->disable($filter);

        $success = [
            'success' => $status->isAcknowledged(),
            'found' => $status->getMatchedCount(),
            'modified' => $status->getModifiedCount()
        ];

        $this->returnJson($success);
    }

    /**
     * Delete reviews;
     * @throws HttpException
     */
    public function actionDelete() {
        $this->requireAjaxRequest();

        $issuer = craft()->request->getPost('issuer');

        if(empty($issuer)) {
            $this->returnErrorJson('Select an Issuer');
        }

        $filter=[];
        if($issuer != 'all') {
            $filter['issuer']=$issuer;
        }

        $status = craft()->reviews_review->delete($filter);

        $success['count']=$status->getDeletedCount();
        $success['success']=$status->isAcknowledged();

        $this->returnJson($success);
    }
}
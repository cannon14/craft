<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */

/**
 * Class Reviews_IssuerService
 * @package Craft
 */
class Reviews_IssuerService extends BaseApplicationComponent
{
    private $issuers;
    private $fetchedAllIssuers;

    /**
     * Get Issuers
     *
     * @param null $page
     * @param null $limit
     * @return array
     */
    public function getIssuers($page=null, $limit=null) {

        $criteria['order'] = 'name asc';

        if(!is_null($page)) {
            $criteria['offset'] = $page;
        }

        if(!is_null($limit)) {
            $criteria['limit'] = $limit;
        }

        $issuerRecords = Reviews_IssuerRecord::model()->findAll($criteria);
        $issuers = Reviews_IssuerModel::populateModels($issuerRecords, 'id');

        return $issuers;
    }

    /**
     * @param $id
     * @return BaseModel
     */
    public function getIssuerById($id) {
        $issuerRecord = Reviews_IssuerRecord::model()->findByPk($id);
        $issuer = Reviews_IssuerModel::populateModel($issuerRecord);

        return $issuer;
    }

    /**
     * Returns all issuers.
     *
     * @param string|null $indexBy
     * @return array
     */
    public function getAllIssuers($indexBy = null)
    {
        if (!$this->fetchedAllIssuers)
        {
            $issuerRecords = Reviews_IssuerRecord::model()->ordered()->findAll();
            $this->issuers = Reviews_IssuerModel::populateModels($issuerRecords, 'id');
            $this->fetchedAllIssuers = true;
        }

        if ($indexBy == 'id')
        {
            return $this->issuers;
        }
        else if (!$indexBy)
        {
            return array_values($this->issuers);
        }
        else
        {
            $issuers = array();

            foreach ($this->issuers as $issuer)
            {
                $issuers[$issuer->$indexBy] = $issuer;
            }

            return $issuers;
        }
    }

    /**
     * Saves an issuer.
     *
     * @param Reviews_IssuerModel $issuer
     * @throws \Exception
     * @return bool
     */
    public function saveIssuer(Reviews_IssuerModel $issuer)
    {
        if ($issuer->id)
        {
            $issuerRecord = Reviews_IssuerRecord::model()->findById($issuer->id);

            if (!$issuerRecord)
            {
                throw new Exception(Craft::t('No issuer exists with the ID “{id}”', array('id' => $issuer->id)));
            }

            $oldIssuer = Reviews_IssuerModel::populateModel($issuerRecord);
            $isNewIssuer = false;
        }
        else
        {
            $issuerRecord = new Reviews_IssuerRecord();
            $isNewIssuer = true;
        }

        $issuerRecord->name       = $issuer->name;
        $issuerRecord->active     = $issuer->active;

        $issuerRecord->validate();
        $issuer->addErrors($issuerRecord->getErrors());

        if (!$issuer->hasErrors())
        {
            $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
            try
            {
                // Save it!
                $issuerRecord->save(false);

                // Now that we have a calendar ID, save it on the model
                if (!$issuer->id)
                {
                    $issuer->id = $issuerRecord->id;
                }

                // Might as well update our cache of the issuer while we have it.
                $this->issuers[$issuer->id] = $issuer;

                if ($transaction !== null)
                {
                    $transaction->commit();
                }
            }
            catch (\Exception $e)
            {
                if ($transaction !== null)
                {
                    $transaction->rollback();
                }

                throw $e;
            }

            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Deletes a map by its ID.
     *
     * @param int $issuerId
     * @throws \Exception
     * @return bool
     */
    public function deleteIssuerById($issuerId)
    {
        if (!$issuerId)
        {
            return false;
        }

        $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
        try
        {
            $affectedRows = craft()->db->createCommand()->delete('reviews_issuers', array('id' => $issuerId));

            if ($transaction !== null)
            {
                $transaction->commit();
            }

            return (bool) $affectedRows;
        }
        catch (\Exception $e)
        {
            if ($transaction !== null)
            {
                $transaction->rollback();
            }

            throw $e;
        }
    }
}
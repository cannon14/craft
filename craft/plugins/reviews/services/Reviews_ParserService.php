<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */

/**
 * Class Reviews_ParserService
 * @package Craft
 */
class Reviews_ParserService extends BaseApplicationComponent
{

    private $parsers;

    /**
     * Get Parsers
     *
     * @param null $page
     * @param null $limit
     * @return array
     */
    public function getParsers($page=null, $limit=null) {

        $criteria['order'] = 'name asc';

        if(!is_null($page)) {
            $criteria['offset'] = $page;
        }

        if(!is_null($limit)) {
            $criteria['limit'] = $limit;
        }

        $parserRecords = Reviews_ParserRecord::model()->findAll($criteria);
        $parsers = Reviews_ParserModel::populateModels($parserRecords, 'id');

        return $parsers;
    }

    /**
     * Get a parser by ID
     * @param $id
     * @return BaseModel
     */
    public function getParserById($id) {
        $parserRecord = Reviews_ParserRecord::model()->findByPk($id);
        $parser = Reviews_ParserModel::populateModel($parserRecord);

        return $parser;
    }

    /**
     * Saves an parser.
     *
     * @param Reviews_ParserModel $parser
     * @throws \Exception
     * @return bool
     */
    public function saveParser(Reviews_ParserModel $parser)
    {
        if ($parser->id)
        {
            $parserRecord = Reviews_ParserRecord::model()->findById($parser->id);

            if (!$parserRecord)
            {
                throw new Exception(Craft::t('No parser exists with the ID “{id}”', array('id' => $parser->id)));
            }
        }
        else
        {
            $parserRecord = new Reviews_ParserRecord();
        }

        $parserRecord->name       = $parser->name;
        $parserRecord->issuer_id  = $parser->issuer_id;
        $parserRecord->description = $parser->description;
        $parserRecord->columns = $parser->columns;
        $parserRecord->active     = $parser->active;

        $parserRecord->validate();
        $parser->addErrors($parserRecord->getErrors());

        if (!$parser->hasErrors())
        {
            $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
            try
            {
                // Save it!
                $parserRecord->save(false);

                // Now that we have a calendar ID, save it on the model
                if (!$parser->id)
                {
                    $parser->id = $parserRecord->id;
                }

                // Might as well update our cache of the issuer while we have it.
                $this->parsers[$parser->id] = $parser;

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
     * Deletes a parser by its ID.
     *
     * @param int $parserId
     * @throws \Exception
     * @return bool
     */
    public function deleteParserById($parserId)
    {
        if (!$parserId)
        {
            return false;
        }

        $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
        try
        {
            $affectedRows = craft()->db->createCommand()->delete('reviews_parsers', array('id' => $parserId));

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
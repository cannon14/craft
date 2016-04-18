<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 4/9/16
 * Time: 9:21 PM
 */

/**
 * Class Reviews_IdMapService
 * @package Craft
 */
class Reviews_IdMapService extends BaseApplicationComponent
{

    private $maps;
    private $fetchedAllMaps;

    public function getMaps($page=null, $limit=null) {

        $criteria['order'] = 'id asc';

        if(!is_null($page)) {
            $criteria['offset'] = $page;
        }

        if(!is_null($limit)) {
            $criteria['limit'] = $limit;
        }

        $mapRecords = Reviews_IdMapRecord::model()->findAll($criteria);
        $maps = Reviews_IdMapModel::populateModels($mapRecords, 'id');

        return $maps;
    }

    /**
     * Returns all maps.
     *
     * @param string|null $indexBy
     * @return array
     */
    public function getAllMaps($indexBy = null)
    {
        if (!$this->fetchedAllMaps)
        {
            $mapRecords = Reviews_IdMapRecord::model()->ordered()->findAll();
            $this->maps = Reviews_IdMapModel::populateModels($mapRecords, 'id');
            $this->fetchedAllMaps = true;
        }

        if ($indexBy == 'id')
        {
            return $this->maps;
        }
        else if (!$indexBy)
        {
            return array_values($this->maps);
        }
        else
        {
            $maps = array();

            foreach ($this->maps as $map)
            {
                $maps[$map->$indexBy] = $map;
            }

            return $maps;
        }
    }

    /**
     * Get a map by id
     *
     * @param $id
     * @return BaseModel
     */
    public function getMapById($id) {
        $mapRecord = Reviews_IdMapRecord::model()->findByPk($id);
        $map = Reviews_IdMapModel::populateModel($mapRecord);

        return $map;
    }

    /**
     * Saves a map
     * @param Reviews_IdMapModel $map
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public function saveMap(Reviews_IdMapModel $map)
    {
        if ($map->id)
        {
            $mapRecord = Reviews_IdMapRecord::model()->findById($map->id);

            if (!$mapRecord)
            {
                throw new Exception(Craft::t('No map exists with the ID “{id}”', array('id' => $map->id)));
            }
        }
        else
        {
            $mapRecord = new Reviews_IdMapRecord();
        }

        $mapRecord->name       = $map->name;
        $mapRecord->card_id    = $map->card_id;
        $mapRecord->alt_id     = $map->alt_id;
        $mapRecord->active     = $map->active;

        $mapRecord->validate();
        $map->addErrors($mapRecord->getErrors());

        if (!$map->hasErrors())
        {
            $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
            try
            {
                // Save it!
                $mapRecord->save(false);

                // Now that we have a map ID, save it on the model
                if (!$map->id)
                {
                    $map->id = $mapRecord->id;
                }

                // Might as well update our cache of the map while we have it.
                $this->maps[$map->id] = $map;

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
     * @param int $calendarId
     * @throws \Exception
     * @return bool
     */
    public function deleteMapById($mapId)
    {
        if (!$mapId)
        {
            return false;
        }

        $transaction = craft()->db->getCurrentTransaction() === null ? craft()->db->beginTransaction() : null;
        try
        {
            $affectedRows = craft()->db->createCommand()->delete('reviews_id_map', array('id' => $mapId));

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
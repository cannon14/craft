<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */
class ProductFeeds_FeedService extends BaseApplicationComponent
{

    /**
     * @param $id
     * @return mixed
     */
    public function getFeed($id) {
        // create new model
        $feedModel = new ProductFeeds_FeedModel();

        // get record from DB
        $feedRecord = ProductFeeds_FeedRecord::model()->findByAttributes(array('id' => $id));

        if ($feedRecord)
        {
            // populate model from record
            $feedModel = ProductFeeds_FeedModel::populateModel($feedRecord);
        }

        return $feedModel;
    }

    /**
     * Retrieve all feeds
     * @return array|mixed|null
     */
    public function getFeeds() {
        return ProductFeeds_FeedRecord::model()->findAll();
    }

    /**
     * @param $attributes
     * @return bool
     * @throws \CDbException
     */
    public function store($attributes) {
        $feed = new ProductFeeds_FeedRecord();

        $feed->name = $attributes['name'];
        $feed->url = $attributes['url'];
        $feed->key = $attributes['key'];
        $feed->active = $attributes['active'];

        $feed->save();

    }

    public function update($attributes) {
        $feed = ProductFeeds_FeedRecord::model()
            ->findByPk($attributes['id']);

        $feed->name = $attributes['name'];
        $feed->url = $attributes['url'];
        $feed->key = $attributes['key'];
        $feed->active = $attributes['active'];

        return $feed->save();

    }

    public function delete($id) {
        return ProductFeeds_FeedRecord::model()
            ->deleteByPk($id);
    }
}
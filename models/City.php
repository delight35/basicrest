<?php

namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;

/**
 * This is the model class for collection "cities".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $slug
 * @property mixed $organisationSlug
 * @property mixed $organisationId
 * @property mixed $citySlug
 * @property mixed $name
 * @property mixed $city
 * @property mixed $street
 * @property mixed $house
 * @property mixed $category
 * @property mixed $subcategory
 * @property mixed $avatar
 * @property mixed $logo
 * @property mixed $albums
 * @property mixed $menus
 * @property mixed $followerCount
 * @property mixed $followers
 * @property mixed $status
 * @property mixed $moderationStatus
 */
class City extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['tbdb', 'cities'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'slug',
            'name',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name'
        ];
    }
}

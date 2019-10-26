<?php

namespace app\modules\v1\resources;

use app\models\Post;
use app\modules\v1\resources\UserResource;
use app\modules\v1\resources\PlaceResource;
use app\modules\v1\resources\OrganisationResource;

class PostResource extends Post
{
    public function fields()
    {
        return [
            'id' => '_id',
            'user' => function (Post $model)
            {
                $user = $model->user;
                return ($user) ? new UserResource($user) : null;                
            },         
            'organisation' => function (Post $model)
            {
                $organisation = $model->organisation;
                return ($organisation) ? new OrganisationResource($organisation) : null;                
            },
            'place' => function (Post $model)
            {
                $place = $model->place;
                return ($place) ? new PlaceResource($place) : null;
            },
            'text',
            'rating',                    
            'timePassed' => function (Post $model)
            {
                $mongoObject = new \MongoDB\BSON\ObjectId($model->_id);
                $mongoObjectDt = date("Y-m-d H:i:s", $mongoObject->getTimestamp());                
                $mongoObjectDtCreate = \DateTime::createFromFormat("Y-m-d H:i:s", $mongoObjectDt);
                $nowDt = new \DateTime();
                $interval = $nowDt->diff($mongoObjectDtCreate);
                $seconds = $interval->y*365*24*60*60+$interval->d*24*60*60+$interval->h*60*60+$interval->i*60+$interval->s;                                
                return $seconds;
            }
        ];
    }
}

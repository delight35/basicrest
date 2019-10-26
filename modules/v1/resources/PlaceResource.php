<?php

namespace app\modules\v1\resources;

use app\models\Place;

class PlaceResource extends Place
{
    public function fields()
    {
        return [
            'id' => '_id',
            'name',
            'city',      
            'street',
            'category',
            'subcategory',
        ];
    }
}

<?php

namespace app\modules\v1\resources;

use app\models\Organisation;

class OrganisationResource extends Organisation
{
    public function fields()
    {
        return [
            'id' => '_id',
            'name',
            'category',
            'city'
        ];
    }
}

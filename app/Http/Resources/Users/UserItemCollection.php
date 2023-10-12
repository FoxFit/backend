<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserItemCollection extends ResourceCollection
{
    public $collects = UserItem::class;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataUser extends Model
{
    protected $visible = [
        'id', 'name', 'mail', 'image', 'imagename', 'id_image'
    ];
    protected $primary_key = 'id';
    protected $table = 'tb_user';
}

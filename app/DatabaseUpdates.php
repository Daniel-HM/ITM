<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatabaseUpdates extends Model
{
    protected $table = 'database_updates';

    public $fillable = ['type', 'info'];
}

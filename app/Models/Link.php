<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //
    public $table = "link";
    protected $fillable = ['url', 'key'];

    public function histories()
    {
        return $this->hasMany(LinkHistory::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkHistory extends Model
{
    //
    public $table = "linkhistory";
    protected $fillable = ['link_id'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}

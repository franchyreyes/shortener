<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkHistory extends Model
{
    // Table name
    public $table = "linkhistory";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['link_id'];

    /**
     * Get the link for the history
     */
    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}

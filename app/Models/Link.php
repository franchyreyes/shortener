<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    // table name
    public $table = "link";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['url', 'key'];


    /**
     * Get the histories for the link
     */
    public function histories()
    {
        return $this->hasMany(LinkHistory::class);
    }
}

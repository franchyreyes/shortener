<?php
namespace App\Repositories;

use App\Models\Link;

class LinkRepository implements IRepository
{
    public function getTop()
    {
        return Link::withCount('histories')
            ->orderBy('histories_count', 'desc')
            ->take(100)
            ->get();
    }

    public function search($field, $condition, $data)
    {
        return Link::where($field, $condition, $data)->first();
    }
}

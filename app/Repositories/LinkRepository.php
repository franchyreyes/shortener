<?php
namespace App\Repositories;

use App\Models\Link;

class LinkRepository implements IRepository
{

    /**
     * Get the top 100 most accessed url(link)
     */

    public function getTop()
    {
        return Link::withCount('histories')
            ->orderBy('histories_count', 'desc')
            ->take(100)
            ->get();
    }


    /**
     * Search for a specific url(Just One)
     *
     * @param  string $field     
     * @param  string $condition     
     * @param  string $data     
     */
    public function search($field, $condition, $data)
    {
        return Link::where($field, $condition, $data)->first();
    }
}

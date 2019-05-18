<?php

namespace App\Http\Controllers;


use App\Models\LinkHistory;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Repositories\IRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LinkRequest;

class LinkController extends Controller
{
    private $linkRepository;

    public function __construct(IRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    public function create(LinkRequest $request)
    {

        $data = $request->validated();

        $link = new Link();

        $linkFinded =  $this->linkRepository->search('url', '=', $data['url']);

        if ($linkFinded) {
            $link = $linkFinded;
        } else {

            $link->url = $data['url'];

            $link->save();

            $link->refresh();

            $link->key = generateKey($link->id);

            $link->save();
        }
        return response()->json([
            'key' => $link->key,
            'generated-url' => url("/{$link->key}"),
            'original-url' => $link->url,
        ], 201);
    }

    public function get($key)
    {
        $link = $this->linkRepository->search('key', 'LIKE BINARY', $key);

        $link->histories()->save(new LinkHistory());

        return redirect()->to($link->url);
    }

    public function getTop()
    {
        $links = $this->linkRepository->getTop();
        return response()->json([
            'links' => $links
        ], 200);
    }
}

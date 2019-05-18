<?php

namespace App\Http\Controllers;


use App\Models\LinkHistory;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Repositories\IRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LinkRequest;
use App\Http\Resources\Link as LinkResource;
use App\Http\Resources\LinkHistory as LinkHistoryResource;
use App\Exceptions\ModelNotFoundException;

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

        $linkFound =  $this->linkRepository->search('url', '=', $data['url']);

        if ($linkFound) {
            $link = $linkFound;
        } else {

            $link->url = $data['url'];

            $link->save();

            $link->refresh();

            $link->key = generateKey($link->id);

            $link->save();
        }

        return response()->json(["url" => new LinkResource($link)], 201);
    }

    public function get($key)
    {
        $link = $this->linkRepository->search('key', 'LIKE BINARY', $key);

        if (!$link) {
            throw new ModelNotFoundException();
        }

        $link->histories()->save(new LinkHistory());

        return redirect()->to($link->url);
    }

    public function getTop()
    {
        $links = $this->linkRepository->getTop();

        return response()->json(
            ['links' => LinkHistoryResource::collection($links)],
            200
        );
    }
}

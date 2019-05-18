<?php

namespace App\Http\Controllers;


use App\Models\LinkHistory;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Repositories\IRepository;


class LinkController extends Controller
{
    private $linkRepository;

    public function __construct(IRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
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

    public function create(Request $request)
    {
        /*$validate = Validator::make($request->input('url'), [
            'url' => 'required|max:255',
        ]);*/

        $link = new Link();

        $link->fill([
            'url' => $request->input('url')
        ]);

        /*if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 400);
        }*/

        $linkFinded =  $this->linkRepository->search('url', '=', $link->url);

        if ($linkFinded) {
            $link = $linkFinded;
        } else {

            $link->save();

            $link->refresh();

            $link->key = generateKey($link->id);

            $link->save();
        }
        return response()->json([
            'key' => $link->key,
            'generated-url' => url("/{$link->code}"),
            'original-url' => $link->url,
        ], 201);
    }
}

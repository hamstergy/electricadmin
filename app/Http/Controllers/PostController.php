<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class PostController extends Controller
{
    /**
     * Bike instance.
     *
     * @var mixed
     */
    public $model;

    /**
     * Create a new ElectricBike instance.
     *
     * @return void
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Show post list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function posts()
    {
        $bikes = $this->model->orderBy('make')->get(['id', 'name']);

        return response()->json([
            'bikes' => $bikes
        ]);
    }

    /**
     * Show electric bikes list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $query = ElectricBike::query()->where('active', '!=', 0)->orderByDesc('active');

        if ($request->has('make')) {
            $query->where('make', str_replace('-', ' ', $request->input('make')))->orWhere('make', $request->input('make'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'))->first();
        }

        if ($request->has('priceFrom')) {
            $query->where('price', '>=', $request->input('priceFrom'))->first();
        }

        if ($request->has('priceTo')) {
            $query->where('price', '<=', $request->input('priceTo'))->first();
        }

        if ($request->has('excludeBySlug')) {
            $query->where('slug', "!=", $request->input('excludeBySlug'))->first();
        }

        $objects = $query->paginate(20);

        return response()->json([
            'data' => $objects->items(),
            'current_page' => $objects->currentPage(),
            'last_page' => $objects->lastPage(),
        ]);
    }

    public function singlePost(Post $post, $slug)
    {
        return response()->json(Post::where('slug', $slug)->first());
    }

    public function index()
    {
        $posts = Post::all()->reverse();
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $validated = $request->validate([
            'title' => 'required|string',
            'body' => 'string|nullable',
            'short_description' => 'string|nullable',
            'date' => 'date|nullable',
            'tags' => 'string|nullable',
            'slug' => 'string|nullable'
        ]);
        if (isset($data['id'])) {
            $post = post::find($data['id']);
            $post->update($validated);
        } else {
            $post = Post::create([
                'title' => $validated['title'],
                'body' => $validated['body'],
                'short_description' => $validated['short_description'],
                'date' => $validated['date'],
                'tags' => $validated['tags'],
                'slug' => $validated['slug']
            ]);
        }
        return response()->json([$post, 201]);
    }
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect(route('posts.index'))->with('notification', '"' . $post->title . '" deleted!');
    }
    public function create()
    {
        return view('posts.create');
    }
}
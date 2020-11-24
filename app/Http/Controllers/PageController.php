<?php

namespace App\Http\Controllers;

use App\Zen\System\Model\Post;
use Illuminate\Http\Request;
use Wink\WinkAuthor;
use Wink\WinkPage;
use Wink\WinkPost;
use Wink\WinkTag;

class PageController extends Controller
{


    /**
     * Show blog homepage.
     *
     * @return View
     */
    public function index()
    {
        $data = [
            'posts' => WinkPost::with('tags')
                ->live()
                ->orderBy('publish_date', 'DESC')
                ->simplePaginate(12)
        ];

        return view('website.views.pages.home', compact('data'));
    }

    /**
     * Show Welcome page.
     *
     * @return View
     */
    public function welcome()
    {
        return view('website.views.pages.home');
    }

    /**
     * Show Register page.
     *
     * @return View
     */
    public function register()
    {
        return view('spark::auth.custom-register');
    }

    /**
     * Show blog homepage.
     *
     * @return View
     */
    public function blog(Request $request)
    {
        $data = [
            'posts' => WinkPost::with('tags', 'author')
                ->live()
                ->orderBy('publish_date', 'DESC')
                ->paginate(9),
            'tags' => WinkTag::all()->pluck('name')
        ];
        if ($request->has('ajax')) {
            if($request->has('author') && $request->author != 'nonAuthor'){
                $authorSlug=$request->author;
                $data = [
                    'posts' => WinkPost::with(['tags', 'author'=> function($q) use($authorSlug) {
                        // Query the name field in status table
                        $q->where('slug', '=', $authorSlug);
                    }])
                        ->live()
                        ->orderBy('publish_date', 'DESC')
                        ->paginate(12)
                    ,
                    'tags' => WinkTag::all()->pluck('name')
                ];
            }
            return compact('data');
        }
        return view('website.views.pages.blog-listing', compact('data'));
    }


    public function searchBlogByTitle(Request $request)
    {
        if($request->has('search')){
            $posts= Post::search($request->search)->get();
            $posts->load('author', 'tags');
            return $posts;
        }
        return [];
    }


    /**
     * Show a post given a slug.
     *
     * @param string $slug
     * @return View
     */
    public function findPostBySlug(string $slug)
    {
        $posts = WinkPost::with('tags')
            ->live()->get();

        $post = $posts->firstWhere('slug', $slug);

        if (optional($post)->published) {

            $next = $posts->sortByDesc('publish_date')->firstWhere('publish_date', '>', optional($post)->publish_date);
            $prev = $posts->sortByDesc('publish_date')->firstWhere('publish_date', '<', optional($post)->publish_date);

            $data = [
                'author' => $post->author,
                'post' => $post,
                'meta' => $post->meta,
                'next' => $next,
                'prev' => $prev,
            ];

            return view('website.views.pages.single-blog', compact('data'));
        }

        abort(404);
    }

    /**
     * Show posts of an Author given by a slug.
     *
     * @param string $name
     * @return View
     */
    public function findPostByAuthor(string $slug)
    {
        $data= ['posts'=>WinkAuthor::firstOrFail()->where('slug', $slug)->get()];
        return view('website.views.pages.author', compact('data'));
    }

    /**
     * Show posts of an Author given by a slug.
     *
     * @param string $name
     * @return View
     */
    public function findPageBySlug(string $slug)
    {
        $data= ['post'=>WinkPage::firstOrFail()->where('slug', $slug)->get()];
        return view('website.views.pages.page', compact('data'));
    }


    /**
     * Update indexed articles.
     *
     * @return string
     */
    public function updateIndexedArticles()
    {
        $data = collect(WinkPost::live()
            ->orderBy('publish_date', 'DESC')
            ->get())->map(function ($item, $key) {
            return [
                "title" => $item->title,
                "link" => post_url($item->slug),
                "snippet" => $item->excerpt
            ];
        });

        $file_path = public_path('index.json');

        file_put_contents($file_path, $data->toJson());

        return "Indexed articles updated for live search";
    }
}


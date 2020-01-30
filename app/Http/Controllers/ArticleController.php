<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Article::orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // @todo: validate fields...
        $post = new Article;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->tags = $request->tags;
        $post->save();

        return response()->json(['status' => 'success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $articleId
     * @return \Illuminate\Http\Response
     */
    public function show($articleId)
    {
        $article = Article::find($articleId);

        if (!is_null($article)) {
            return response()->json([
                'status' => 'success',
                'data' => $article
            ]);
        }
        return response()->json(['status' => 'not_found'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * @param  string $articleId
     * @return \Illuminate\Http\Response
     */
    public function destroy($articleId)
    {
        $article = Article::find($articleId);
        if (!is_null($article)) {
            $article->delete();
            return response()->json(['status' => 'success'], 200);
        }
        return response()->json(['status' => 'not_found'], 400);
    }
}

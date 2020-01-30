<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $v = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'body' => 'required'
            ]
        );

        if ($v->fails()) {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }

        $post = new Article;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->tags = $request->tags;
        // @todo: Would need to change if multiple users can create posts...
        $post->created_by = User::ADMIN_NAME;
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
     * @param  string $articleId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $articleId)
    {
        $v = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'body' => 'required'
            ]
        );

        if ($v->fails()) {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }

        /** @var Article $article */
        $article = Article::find($articleId);
        if (is_null($article)) {
            return response()->json(['status' => 'not_found'], 400);
        }

        $article->title = $request->get('title');
        $article->body = $request->get('body');
        $article->save();
        return response()->json(['status' => 'success'], 200);
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

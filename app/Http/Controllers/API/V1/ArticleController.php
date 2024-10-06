<?php

namespace App\Http\Controllers\API\V1;

use App\Services\MyServices;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'message' => 'Token not exists, please login first'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $query = Article::query()->orderBy('publish_date', 'desc');

        if (request('title')) {
            $query->where("title", "like", "%" . request("title") . "%");
        }

        $articles = $query->paginate(2);

        // $customPaginate = MyServices::customPaginate($articles);

        if ($articles->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Articles Empty'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return new ArticleCollection($articles);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'message' => 'Token not exists, please login first'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = $request->validated();

        try {
            Article::create($data);

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Data stored to dbd'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error storing data :' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed Data stored to dbd'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Article $article)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'message' => 'Token not exists, please login first'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'data' => new ArticleResource($article),
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'message' => 'Token not exists update failed, please login first'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = $request->validated();

        $origin = Article::where('id', $article->id)->first();

        $article->update($data);

        try {
            return response()->json([
                'data' => new ArticleResource($article),
                'message' => "Article '$origin->title' has been changed  '$article->title'",
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error updated data :' . $e->getMessage());
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed Data updated to dbd'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Article $article)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'message' => 'Token not exists delete failed, please login first'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $article->delete();

        try {
            return response()->json([
                'message' => "Article '$article->title' has been deleted",
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error updated data :' . $e->getMessage());
            return response()->json([
                'message' => "Failed Data deleted",
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function unauthenticated(Request $request)
    {
        # code...
    }
}

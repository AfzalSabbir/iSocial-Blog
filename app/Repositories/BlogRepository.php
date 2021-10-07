<?php

namespace App\Repositories;

use App\Helpers\ImageHelper;
use App\Models\Blog;
use App\Repositories\Interfaces\BlogInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogRepository implements BlogInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $blogs = Blog::query()->latest()->with('category')->get();
        return response()->json($blogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $blogData           = $request->all();
        $blogData['slug']   = Str::slug($request->name) . '-' . time();
        $blogData['banner'] = ImageHelper::uploadImage($request);
        $blog               = Blog::query()->create($blogData);
        return response()->json($blog);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $blog = Blog::query()
            ->where('id', $id)
            ->with('category')
            ->with('comments', function ($q) {
                $q->whereNull('parent_id')->latest()->with('children');
            })
            ->firstOrFail();
        return response()->json($blog);
    }

    /**
     * Update the specified resozurce in storage.
     *
     * @param Request $request
     * @param Blog $blog
     * @return JsonResponse
     */
    public function update(Request $request, Blog $blog): JsonResponse
    {
        $blogData = $request->except('old_banner');

        if ($blogData['banner'] !== $request->old_banner) {
            $blogData['banner'] = ImageHelper::uploadImage($request, true);
        }

        if ($blogData['name'] !== $blog->name) {
            $blogData['slug'] = Str::slug($blogData['name']) . '-' . time();
        }

        $blog->update($blogData);

        return response()->json($blog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return bool|null
     */
    public function destroy(Blog $blog)
    {
        (new ImageHelper)->deleteImage($blog->banner);
        return $blog->delete();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function imageStore(Request $request): JsonResponse
    {
        $url = ImageHelper::uploadImage($request, false, 'upload');
        return response()->json([
            'url' => $url
        ]);
    }
}

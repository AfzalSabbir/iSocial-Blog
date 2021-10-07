<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $blogs = Blog::query()->with('category')->get();

        return response()->json($blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Builder|Model
     */
    public function show($id)
    {
        return Blog::query()
            ->where('id', $id)
            ->with('category')
            ->with('comments', function ($q) {
                $q->whereNull('parent_id')->with('children');
            })
            ->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return bool|null
     */
    public function destroy(Blog $blog)
    {
        return $blog->delete();
    }
}

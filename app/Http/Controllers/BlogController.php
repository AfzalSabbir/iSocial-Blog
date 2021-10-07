<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Repositories\Interfaces\BlogInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * @var BlogInterface
     */
    private $blogRepository;

    /**
     * BlogController constructor.
     *
     * @param BlogInterface $blogRepository
     */
    public function __construct(BlogInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->blogRepository->list();
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->blogRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->blogRepository->show($id);
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
     * Update the specified resozurce in storage.
     *
     * @param Request $request
     * @param Blog $blog
     * @return JsonResponse
     */
    public function update(Request $request, Blog $blog): JsonResponse
    {
        return $this->blogRepository->update($request, $blog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog
     * @return bool|null
     */
    public function destroy(Blog $blog)
    {
        return $this->blogRepository->destroy($blog);
    }
}

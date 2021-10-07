<?php

namespace App\Repositories\Interfaces;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface BlogInterface
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse;

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse;

    /**
     * @param Request $request
     * @param Blog $blog
     * @return JsonResponse
     */
    public function update(Request $request, Blog $blog): JsonResponse;

    /**
     * @param Blog $blog
     * @return mixed
     */
    public function destroy(Blog $blog);

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function imageStore(Request $request): JsonResponse;
}

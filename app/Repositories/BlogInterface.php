<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface BlogInterface
{
    public function list(): JsonResponse;

    public function store(Request $request): JsonResponse;

    public function show($id): JsonResponse;

    public function update(Request $request, Blog $blog): JsonResponse;

    public function destroy(Blog $blog): ?bool;
}

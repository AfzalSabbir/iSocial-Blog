<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommentRepository implements CommentInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Builder|Model
     */
    public function store(Request $request)
    {
        $comment           = Comment::query()->create($request->all());
        $comment->children = [];
        return $comment;
    }
}

<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface CommentInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);
}

<?php

namespace App\Exceptions;

use Exception;

class TaskAlreadyCompletedException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Task is already completed'
        ], 400);
    }
}

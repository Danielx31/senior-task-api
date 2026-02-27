<?php

namespace App\Exceptions;

use Exception;

class TaskAlreadyCompletedException extends Exception
{
    protected $message = 'Task is already completed';
}

<?php

use Core\BoundedContext\Course\Infrastructure\Controllers\{
    CreateCoursePostController,
};

Route::post("courses", CreateCoursePostController::class);

<?php

use Core\BoundedContext\Course\Infrastructure\Controllers\{
    CreateCoursePostController,
    ListCoursesGetController
};

Route::get("courses", ListCoursesGetController::class);
Route::post("courses", CreateCoursePostController::class);

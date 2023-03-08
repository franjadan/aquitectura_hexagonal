<?php

namespace App\Providers;

use Core\BoundedContext\Course\Domain\CourseRepository;
use Core\BoundedContext\Course\Infrastructure\Persistence\Eloquent\CourseRepository as EloquentCourseRepository;
use Illuminate\Support\ServiceProvider;

class CourseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CourseRepository::class,
            EloquentCourseRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace Core\BoundedContext\Course\Infrastructure\Persistence\Eloquent;

use Core\BoundedContext\Course\Domain\{
    Course,
    Courses,
    CourseRepository as CourseRepositoryContract,
    ValueObjects\CourseId,
    CourseAlreadyExists,
};

use Core\Shared\Infrastructure\Persistence\Eloquent\EloquentException;
use Exception;
use Illuminate\Support\Facades\DB;

final class CourseRepository implements CourseRepositoryContract {
    public function __construct(private CourseModel $model) {}

    public function find(CourseId $id): ?Course {
        $courseModel = $this->model->find($id->value());

        if (null === $courseModel) {
            return null;
        }

        return $this->toDomain($courseModel);
    }

    private function toDomain(CourseModel $eloquentCourseModel): Course {
        return Course::fromPrimitives(
            $eloquentCourseModel->id,
            $eloquentCourseModel->name,
        );
    }

    public function list(): Courses {
        $eloquentCourses = $this->model->all();

        $courses = $eloquentCourses->map(
            function (CourseModel $eloquentCourse) {
                return $this->toDomain($eloquentCourse);
            }
        )->toArray();

        return new Courses($courses);
    }

    /**
     * @throws EloquentException
     */
    public function save(Course $course): void {
        $courseModel = $this->model->find($course->id()->value());

        if (null === $courseModel) {
            $courseModel = new CourseModel();
            $courseModel->id = $course->id()->value();
        }
        $courseModel->name = $course->name()->value();

        DB::beginTransaction();
        try {
            $courseModel->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new EloquentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
    }

    public function delete(CourseId $id): void {
        $course = $this->model->find($id->value());

        if (null === $course) {
            throw new CourseAlreadyExists;
        }

        $course->delete();
    }
}

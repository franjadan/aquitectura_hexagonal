<?php

namespace Core\BoundedContext\Course\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Core\BoundedContext\Course\Application\Actions\CreateCourse;
use Core\BoundedContext\Course\Infrastructure\Persistence\Eloquent\CourseRepository;
use Core\Shared\Domain\UuidGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

final class CreateCoursePostController extends Controller {
    public function __construct(
        private UuidGenerator $uuidGenerator,
        private CourseRepository $repository,
    ) {}

    /**
     * @throws
     */
    public function __invoke(Request $request): JsonResponse {
        $id = $request->get('id', $this->uuidGenerator->generate());

        $courseResponse = (new CreateCourse($this->repository))(
            $id,
            $request->get("name"),
        );

        return new JsonResponse(
            [
                'course' => $courseResponse->toArray(),
            ],
            ResponseAlias::HTTP_OK,
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lesson\CreateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LessonController extends Controller
{
    /**
     * Страница  создания
     * @param  Course  $course
     * @param  Lesson  $lesson
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Course $course, Lesson $lesson)
    {
        return view('lessons.create', compact(['course', 'lesson']));
    }

    /**
     * Сохрание обьекта
     * @param  CreateLessonRequest  $request
     * @param  Course  $course
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(CreateLessonRequest $request, Course $course)
    {
        $validated = $request->validated();

        if ($course->lessons()->count() >= 5) {
            throw ValidationException::withMessages(['name' => 'You can not make more than 5 lessons']);
        }

        $course->lessons()->create($validated);

        return redirect()->route('courses.show', compact('course'))->with('success', 'Урок создан!');
    }

    /**
     * Страница редактирования
     * @param  Course  $course
     * @param  Lesson  $lesson
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Course $course, Lesson $lesson)
    {
        return view('lessons.edit', compact(['course', 'lesson']));
    }

    /**
     * Обноваление обьекта
     * @param  CreateLessonRequest  $request
     * @param  Course  $course
     * @param  Lesson  $lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateLessonRequest $request, Course $course, Lesson $lesson)
    {
        $validated = $request->validated();
        $lesson->update($validated);
        return redirect()->route('courses.show', compact(['course', 'lesson']))->with('success', 'Урок обновлен!');
    }

    /**
     * Удаление
     * @param  Course  $course
     * @param  Lesson  $lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('courses.show', compact(['course', 'lesson']))->with('success', 'Урок удалён!');
    }

    /**
     * Список уроков для api
     * @param  Course  $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexApi(Course $course)
    {
        $lesson = Lesson::where('course_id', $course->id)->get();
        return response()->json($lesson);
    }
}

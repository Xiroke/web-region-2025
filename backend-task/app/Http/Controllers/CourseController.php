<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\WebhookPayRequest;
use App\Http\Resources\CoursePaginatedCollection;
use App\Models\Course;
use App\Models\CourseStudent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Странциа курсов с пагинацией
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $items = Course::paginate(5);
        return view('courses.index', compact('items'));
    }

    /**
     * Страница создания курса
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Создание курса
     * @param  CreateCourseRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCourseRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['img'] = $request->file('image')->store('courses', 'public');
            unset($validated['image']);
        }

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Курс создан!');
    }

    /**
     * Страница конкретного курса
     * @param  Course  $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Course $course)
    {
        $course->load('lessons');
        return view('courses.show', ['item' => $course]);
    }

    /**
     * Страница редактирования курса
     * @param  Course  $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Course $course)
    {
        return view('courses.edit', ['item' => $course]);
    }

    /**
     * Обноваление курса
     * @param  UpdateCourseRequest  $request
     * @param  Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $this->resizeJpg($file->path());

            Storage::disk('public')->delete($course->img);

            $filename = 'mpic_'.Str::random(10).'.'.'jpg';

            $validated['img'] = $file->storeAs('courses', $filename, 'public');
            unset($validated['image']);
        }

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Курс обновлен!');
    }

    /**
     * Функция для изменения размера jpg
     * @param  string  $path
     * @return void
     */
    private function resizeJpg(string $path) {
        [$width, $height] = getimagesize($path);

        if ($width <= 300 && $height <= 300) return;

        // соотношение (1000, 500) => ratio 0.3 =>
        // width = 1000 * 0.3 = 300
        // height = 500 * 0.3 = 150
        $ratio = 300 / max($width, $height);
        $newWidth = round($width * $ratio);
        $newHeight = round($height * $ratio);
        // загрузка из памяти
        $src = imagecreatefromjpeg($path);
        // пустой холст
        $dst = imagecreatetruecolor($newWidth, $newHeight);

        // изменение размера
        imagecopyresampled($dst, $src, 0,0, 0, 0, $newWidth, $newHeight, $width, $height);

        // сохранение
        imagejpeg($dst, $path);

        imagedestroy($src);
        imagedestroy($dst);
    }

    /**
     * Удаление курса
     * @param  Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Курс удалён!');
    }

    /**
     * Получение списка курсов через пагинацию
     * @param  Course  $course
     * @return CoursePaginatedCollection
     */
    public function indexApi(Course $course)
    {
        $courses = Course::paginate(5);
        return new CoursePaginatedCollection($courses);
    }

    /**
     * Запись на курс
     * @param  Course  $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Course $course) {
        $user = auth()->user();

        if ($course->start_date < now()) {
            abort(422, 'The course has started');
        }

        $user->courses()->attach($course->id, ['status' => 'pending']);

        return response()->json([
            'pay_url' => 'http://example.com/fake-pay'
        ]);
    }

    /**
     * Отмена записи на курс
     * @param  CourseStudent  $courseStudent
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelPayment(CourseStudent $courseStudent) {
        $user = auth()->user();

        if ($courseStudent['status']== PaymentStatus::PAID) {
            abort(418, ['status' => 'was payed']);
        }

        $courseStudent['status']= PaymentStatus::FAILED;

        return response()->json(['status' => 'success']);
    }

    /**
     * Вебхук для оплаты
     * @param  WebhookPayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function webhookPay(WebhookPayRequest $request) {
        $validated = $request->validated();

        CourseStudent::where('id', $validated['order_id'])->update(['status' => $validated['status']]);

        return response()->noContent();
    }

    /**
     * Просмотр записей текущего пользователя
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexMy() {
        $user = auth()->user();

        $courseStudents = CourseStudent::where('user_id', $user->id)->with('course')->get();

        $data = $courseStudents->map( function ($courseStudent) {
            return[
                'id' => $courseStudent->id,
                'payment_status' => $courseStudent->status,
                'course' => $courseStudent->course,
            ];
        });


        return response()->json(['data' => $data]);
    }
}

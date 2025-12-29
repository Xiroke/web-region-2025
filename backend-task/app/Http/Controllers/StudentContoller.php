<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexStudentRequest;
use App\Models\Course;
use App\Models\CourseStudent;
use Illuminate\Http\Request;

class StudentContoller extends Controller
{
    /**
     * Получение списка записей с фильтацией по курсу
     * @param  IndexStudentRequest  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(IndexStudentRequest $request) {
        $validated = $request->validated();

        if (isset($validated['course_query'])) {
            $items = CourseStudent::with(['course', 'student'])->whereHas("course", function ($query) use ($validated) {
                $query->whereLike('name', '%'.$validated['course_query'].'%');
            })->get();
        } else {
            $items = CourseStudent::with('course', 'student')->get();
        }

        return view('students', compact('items'));
    }
}

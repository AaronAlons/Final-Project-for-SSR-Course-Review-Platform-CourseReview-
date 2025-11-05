<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest; // <-- NUEVA LÍNEA
use App\Http\Requests\UpdateCourseRequest;// <-- NUEVA LÍNEA

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request) // <-- LÍNEA MODIFICADA
    {
        
        Course::create($request->validated());

        // Redirigimos al dashboard (o a un futuro 'courses.index' de admin)
        return redirect()->route('dashboard')->with('success', 'Curso creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
        return view('courses.edit', ['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course) // <-- LÍNEA MODIFICADA
    {    
        $course->update($request->validated());

        // Redirigimos al dashboard (o a un futuro 'courses.index' de admin)
        return redirect()->route('dashboard')->with('success', 'Curso actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
        $course->delete();

        // Redirigimos al dashboard (o a un futuro 'courses.index' de admin)
        return redirect()->route('dashboard')->with('success', 'Curso eliminado exitosamente.');
    }
}
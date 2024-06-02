<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): View
    {
    
    }

    public function show(User $user): View
    {
    }

    public function create(): View
    {
    }

    public function store(TeacherFormRequest $request): RedirectResponse
    {
    }

    public function edit(Teacher $teacher): View
    {
    }

    public function update(TeacherFormRequest $request, Teacher $teacher): RedirectResponse
    {
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
    }

    public function destroyPhoto(Teacher $teacher): RedirectResponse
    {
      
    }



}

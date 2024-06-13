<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Models\Student;
use App\Models\Genre;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');


Route::patch('users/{user}/upadteBlocked', [UserController::class, 'updateBlocked'])->name('users.updateBlocked');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/* ----- PUBLIC ROUTES ----- */
Route::get('/', [MovieController::class, 'showMoment'])->name('home');
Route::get('courses/showcase', [CourseController::class, 'showcase'])->name('courses.showcase');
Route::get('tickets/showcase', [TicketController::class, 'showcase'])->name('tickets.showcase');
Route::get('purchases/{screening}', [PurchaseController::class, 'buy'])->name('tickets.buy');
Route::get('/movies/{movie}/selectscreening', [MovieController::class, 'showMomentScreenings'])->name('movies.showMomentScreenings');
/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*----- Géneros -----*/

//Route::get('genres/create', [GenreController::class, 'create'])->name('genres.create');
Route::get('genres/create', [GenreController::class, 'create'])
->name('genres.create')
->can('create', Genre::class);

Route::post('genres', [GenreController::class, 'store'])->name('genres.store');


/* ----- Verified users ----- */
Route::middleware('auth', 'verified')->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::delete('courses/{course}/image', [CourseController::class, 'destroyImage'])
        ->name('courses.image.destroy');

    //Course show is public and index for any authenticated user
    Route::resource('courses', CourseController::class)->only(['index']);

    //Department show and index are accessible to any authenticated user
    Route::resource('departments', DepartmentController::class)->only(['index', 'show']);

    //Disciplines index and show are public
    Route::resource('disciplines', DisciplineController::class)->except(['index', 'show']);

    Route::delete('teachers/{teacher}/photo', [TeacherController::class, 'destroyPhoto'])
        ->name('teachers.photo.destroy');
    Route::resource('teachers', TeacherController::class);


    Route::delete('students/{student}/photo', [StudentController::class, 'destroyPhoto'])
        ->name('students.photo.destroy')
        ->can('update', 'student');
    Route::resource('students', StudentController::class);
    // Route::delete('students/{student}/photo', [StudentController::class, 'destroyPhoto'])
    //     ->name('students.photo.destroy')
    //     ->can('update', 'student');
    // Route::get('students', [StudentController::class, 'index'])->name('students.index')
    //     ->can('viewAny', Student::class);
    // Route::get('students/{student}', [StudentController::class, 'show'])
    //     ->name('students.show')
    //     ->can('view', 'student');
    // Route::get('students/create', [StudentController::class, 'create'])
    //     ->name('students.create')
    //     ->can('create', Student::class);
    // Route::post('students', [StudentController::class, 'store'])
    //     ->name('students.store')
    //     ->can('create', Student::class);
    // Route::get('students/{student}/edit', [StudentController::class, 'edit'])
    //     ->name('students.edit')
    //     ->can('update', 'student');
    // Route::put('students/{student}', [StudentController::class, 'update'])
    //     ->name('students.update')
    //     ->can('update', 'student');
    // Route::delete('students/{student}', [StudentController::class, 'destroy'])
    //     ->name('students.destroy')
    //     ->can('delete', 'student');


    Route::delete('administratives/{administrative}/photo', [AdministrativeController::class, 'destroyPhoto'])
        ->name('administratives.photo.destroy');
    Route::resource('administratives', AdministrativeController::class);

    // Add a discipline to the cart:
    Route::post('cart/{screening}', [CartController::class, 'addToCart'])
        ->name('cart.add');
    // Remove a discipline from the cart:
    Route::delete('cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Confirm (store) the cart and save disciplines registration on the database:
    Route::post('cart', [CartController::class, 'confirm'])->name('cart.confirm');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::middleware('can:admin')->group(function () {
        //Course insert, update and delete related routes are for admin only
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        //Department insert, update and delete related routes are for admin only
        Route::resource('departments', DepartmentController::class)->except(['index', 'show']);
    });
    Route::get('courses/{course}/curriculum', [CourseController::class, 'showCurriculum'])->name('courses.curriculum');
Route::get('movies/showcase', [MovieController::class, 'showCase'])->name('movies.showcase');
Route::delete('movies/{movie}/photo', [TheaterController::class, 'destroyImage'])->name('movies.image.destroy');
Route::get('/movies/{movie}/screenings', [MovieController::class, 'showScreening']);
Route::resource('theaters',TheaterController::class);
Route::delete('theaters/{theater}/photo', [TheaterController::class, 'destroyPhoto'])
->name('theaters.photo.destroy')
->can('update', 'theater');
});

/* ----- OTHER PUBLIC ROUTES ----- */
//Course show is public.
Route::resource('courses', CourseController::class)->only(['show']);
Route::resource('movies', MovieController::class);
Route::resource('users', UserController::class);
Route::resource('customers', CustomerController::class);
Route::resource('screenings', ScreeningController::class);
Route::resource('tickets', TicketController::class);
//Disciplines index and show are public
Route::resource('disciplines', DisciplineController::class)->only(['index', 'show']);
Route::resource('genres', GenreController::class);

require __DIR__ . '/auth.php';

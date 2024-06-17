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
use App\Http\Controllers\StatisticsController;
use App\Models\Student;
use App\Models\Genre;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\QrCodeController;

//Teste estatisticas
Route::get('/charts', [ChartController::class, 'showChart'])->name('charts.showChart');
Route::get('/charts2', [ChartController::class, 'showChart2'])->name('charts.showChart2');
Route::get('/general', [ChartController::class, 'general'])->name('charts.general');



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

require __DIR__ . '/auth.php';


Route::post('/screenings/{screening}/process-url', [ScreeningController::class, 'processUrl'])->name('screenings.processUrl');
Route::get('/cart/download-pdf', [CartController::class, 'downloadPdf'])->name('cart.downloadPdf');

/* ----- PUBLIC ROUTES ----- */
Route::get('/', [MovieController::class, 'showMoment'])->name('home');
Route::get('tickets/showcase/{ticket}/{qrcode_url}', [TicketController::class, 'showcase'])->name('tickets.showcase');
Route::get('tickets/{ticket}/qrcode', [TicketController::class, 'generateQRCode'])->name('tickets.qrcode');
Route::get('tickets/{ticket}/access', [TicketController::class, 'validate'])->name('tickets.access');
Route::get('purchases/{screening}', [PurchaseController::class, 'buy'])->name('tickets.buy');
Route::get('purchases/historic/{customer}', [PurchaseController::class, 'showHistoric'])->name('historic.index');
Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
Route::get('purchases/show/{purchase}', [PurchaseController::class, 'show']);
Route::get('/movies/{movie}/selectscreening', [MovieController::class, 'showMomentScreenings'])->name('movies.showMomentScreenings');
/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*----- Géneros -----*/

//Route::get('genres/create', [GenreController::class, 'create'])->name('genres.create');
//Route::get('genres/create', [GenreController::class, 'create'])
//->name('genres.create')
//->can('create', Genre::class);



/* ----- Verified users ----- */
Route::middleware('auth', 'verified')->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::delete('administratives/{administrative}/photo', [AdministrativeController::class, 'destroyPhoto'])
        ->name('administratives.photo.destroy');
    Route::resource('administratives', AdministrativeController::class);

    // Add a discipline to the cart:
    Route::post('cart/{screening}', [CartController::class, 'addToCart'])->name('cart.add');
    // Remove a discipline from the cart:
    Route::delete('cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Confirm (store) the cart and save disciplines registration on the database:
    Route::post('cart', [CartController::class, 'confirm'])->name('cart.confirm');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');

   
    
    Route::get('movies/showcase', [MovieController::class, 'showCase'])->name('movies.showcase');
    Route::delete('movies/{movie}/photo', [TheaterController::class, 'destroyImage'])->name('movies.image.destroy');
    Route::get('/movies/{movie}/screenings', [MovieController::class, 'showScreening']);
    Route::resource('theaters', TheaterController::class);
    Route::delete('theaters/{theater}/photo', [TheaterController::class, 'destroyPhoto'])
        ->name('theaters.photo.destroy')
        ->can('update', 'theater');
});
Route::patch('user/{user}', [UserController::class, 'updateBlocked'])->name('users.block');
/* ----- OTHER PUBLIC ROUTES ----- */

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


Route::resource('movies', MovieController::class);
Route::resource('users', UserController::class);
Route::resource('customers', CustomerController::class);
Route::resource('screenings', ScreeningController::class);
Route::resource('tickets', TicketController::class);
//Disciplines index and show are public
Route::resource('genres', GenreController::class);

require __DIR__ . '/auth.php';

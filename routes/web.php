<?php

use Illuminate\Support\Facades\DB;
use App\Models\Person;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/people/add', [PersonController::class, 'create'])->name('people.create');
    Route::get('/people', [PersonController::class, 'index'])->name('people.index');
    Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');
    Route::post('/people', [PersonController::class, 'store'])->name('people.store');
});


Route::get('/test-degree', function () {
    DB::enableQueryLog();

    // Start timing
    $timestart = microtime(true);

    // Find the person 84
    $person = Person::findOrFail(84);
    $degree = $person->getDegreeWith(1265);

    // Elapsed time and number of SQL queries
    $time_elapsed = microtime(true) - $timestart;
    $query_count = count(DB::getQueryLog());

    return response()->json([
        "degree" => $degree['degree'] ?? false,
        "path" => $degree['path'] ?? [],
        "time" => $time_elapsed,
        "nb_queries" => $query_count,
    ]);
});


require __DIR__.'/auth.php';

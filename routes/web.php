<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/admin');

// Route::get('/storage-link', function () {
//     $target = '/home/alameena/public_html/reports.alameenacademy.com/storage/app/public/attachments';
//     $shortcut = '/home/alameena/public_html/reports.alameenacademy.com/public/storage/attachments';
//     symlink($target, $shortcut);
//     return 'Symlink created successfully.';
// });



Route::get('/events/pdf', [EventController::class, 'generatePDF'])->name('events.pdf');



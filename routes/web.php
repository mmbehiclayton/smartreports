<?php

use Illuminate\Support\Facades\Route;

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


<?php

Route::prefix('epanel/content')->as('epanel.')->middleware(['auth', 'check.permission:Berita'])->group(function() 
{
    Route::resources([
        'kategori' => 'KategoriController',
        'kategori.berita' => 'BeritaController',
    ]);
});
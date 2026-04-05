<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Nama tabel yang terhubung dengan model ini.
     * Secara default Laravel akan mencari tabel bernama 'products'.
     */
    protected $table = 'products';

    /**
     * Kolom-kolom yang dapat diisi (Mass Assignable).
     * Pastikan nama kolom di sini sama persis dengan yang ada di phpMyAdmin.
     */
    protected $fillable = [
        'sku',
        'name',
        'category',
        'price',
        'stock',
        'status'
    ];
}
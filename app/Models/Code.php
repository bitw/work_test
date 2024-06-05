<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $prefix
 * @property string $lab_code
 * @property string $weight
 */
class Code extends Model
{
    use HasFactory;

    protected $table = 'codes';

    public $timestamps = false;
}

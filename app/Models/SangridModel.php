<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SangridModel extends Model
{
    use HasFactory;
    protected $guarded = ['clientID'];

    public function detail()
    {
        return $this->hasMany(DetailModel::class);
    }
}

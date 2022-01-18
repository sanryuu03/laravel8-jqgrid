<?php

namespace App\Models;

use App\Http\Controllers\SangridController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailModel extends Model
{
    use HasFactory;
    protected $guarded = ['detailID'];

    public function sangrid()
    {
        return $this->belongsTo(SangridController::class);
    }
}

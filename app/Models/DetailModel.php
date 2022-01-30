<?php

namespace App\Models;

use App\Models\SangridModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailModel extends Model
{
    use HasFactory;
    protected $guarded = ['detailID'];
    // protected $primaryKey = 'detailID';
    // protected $fillable = [
    //     'detailID',
    //     'clientdID',
    //     'jobdesk',
    //     'hobi',
    //     'hargaHobi',
    // ];

    public function sangrid()
    {
        // tabel detail relasi ke tabel master yaitu sangrid
        return $this->belongsTo(SangridModel::class);
        // return $this->belongsTo(SangridModel::class, 'id', 'clientID');
        // return $this->belongsTo(SangridModel::class)->select('clientID');
        // return $this->hasMany(SangridModel::class);
    }
}

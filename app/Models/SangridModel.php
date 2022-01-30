<?php

namespace App\Models;

use App\Models\DetailModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SangridModel extends Model
{
    use HasFactory;
    protected $guarded = ['clientID'];
    // protected $primaryKey = 'clientID';
    // protected $primaryKey = 'detailID';

    // protected $fillable = [
    //     'detailID',
    //     'clientdID',
    //     'jobdesk',
    //     'hobi',
    //     'hargaHobi',
    // ];


    public function detail()
    {
        // tabel master yaitu sangrid relasi ke tabel detail
        return $this->hasMany(DetailModel::class);
        // return $this->hasMany(DetailModel::class, 'detail_models', 'detailId');
        // return $this->hasMany(DetailModel::class, 'id', 'clientID');
    }
}

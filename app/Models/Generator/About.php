<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Models\Generator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use DigitalCloud\Blameable\Traits\Blameable;
use OwenIt\Auditing\Contracts\Auditable;


class About extends Model implements Auditable
{
    use HasFactory, SoftDeletes, Uuid, Blameable;
    use \OwenIt\Auditing\Auditable;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'tbl_about';

    protected $fillable = [
        'id',
        'judul', 
        'subjudul', 
        'deskripsi_1', 
        'deskripsi_2', 
        'kelebihan_1', 
        'kelebihan_2', 
        'kelebihan_3', 
        'kelebihan_4', 
        
    ];
}
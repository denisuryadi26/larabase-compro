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


class Contact extends Model implements Auditable
{
    use HasFactory, SoftDeletes, Uuid, Blameable;
    use \OwenIt\Auditing\Auditable;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'tbl_contact';

    protected $fillable = [
        'id',
        'name', 
        'description', 
        'logo', 
        'alamat', 
        'email', 
        'telepon', 
        'maps_embed', 
        
    ];
}
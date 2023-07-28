<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use DigitalCloud\Blameable\Traits\Blameable;
use OwenIt\Auditing\Contracts\Auditable;

class Group extends Model implements Auditable
{
    use HasFactory, SoftDeletes, Uuid, Blameable;
    use \OwenIt\Auditing\Auditable;


    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'conf_group';


    public function getCollect()
    {
        return [
            'code' => $this->attributes['code'],
            'name' => $this->attributes['name'],
        ];
    }

    protected $fillable = [
        'id',
        'name',
        'code',
    ];

    public function group_menu(){
        return $this->belongsToMany('App\Models\Menu','conf_group_menu')
            ->withPivot('id','group_id','menu_id','is_addable','is_editable','is_deletable', 'is_viewable')
            ->wherePivot('deleted_at', null);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}

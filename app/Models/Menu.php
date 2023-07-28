<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
namespace App\Models;

use DigitalCloud\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class Menu extends Model implements Auditable
{
    use HasFactory, SoftDeletes, Uuid, Blameable;
    use \OwenIt\Auditing\Auditable;

    protected $keyType = 'string';

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $table = 'conf_menu';

    protected $fillable = ['uuid','name','code','parent_id','icon','route_name','menu_order', 'is_showed'];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(Menu::class, 'parent_id','id')->orderBy('menu_order','ASC');
    }

    public function access()
    {
        return $this->belongsToMany('App\Models\Group','conf_group_menu')
            ->withPivot('id','group_id','menu_id','is_addable','is_editable','is_deletable', 'is_viewable')
            ->wherePivot('deleted_at', null)->withTimestamps();
    }

    public function menu_access()
    {
        $group_id = Auth::user()->group_id;

        return $this->access()->where('group_id',$group_id);
    }



}

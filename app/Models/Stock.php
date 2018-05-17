<?php
/**
 * Created by PhpStorm.
 * User: Sugito
 * Date: 9/10/2016
 * Time: 12:08 AM
 */

namespace App\Models;

use Auth;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\CompanyFilter;

/**
 * App\Models\Stock
 *
 * @property int $id
 * @property int $company_id
 * @property int $owner_id
 * @property string $owner_type
 * @property int $warehouse_id
 * @property int $product_id
 * @property int $base_product_unit_id
 * @property int $display_product_unit_id
 * @property float $quantity
 * @property float $current_quantity
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Models\Company $company
 * @property-read mixed $base_product_unit_h_id
 * @property-read mixed $company_h_id
 * @property-read mixed $display_product_unit_h_id
 * @property-read mixed $h_id
 * @property-read mixed $product_h_id
 * @property-read mixed $warehouse_h_id
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Warehouse $warehouse
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Stock onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereBaseProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereCurrentQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereDisplayProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stock whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Stock withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Stock withoutTrashed()
 * @mixin \Eloquent
 */
class Stock extends Model
{
    use SoftDeletes;

    use CompanyFilter;

    protected $dates = ['deleted_at'];

    protected $table = 'stocks';

    protected $fillable = [
        'quantity',
        'current_quantity',
    ];

    protected $hidden = [
        'id',
        'company_id',
        'owner_id',
        'owner_type',
        'warehouse_id',
        'product_id',
        'base_product_unit_id',
        'display_product_unit_id',
    ];

    protected $appends = [
        'hId',
        'companyHId',
        'warehouseHId',
        'productHId',
        'baseProductUnitHId',
        'displayProductUnitHId',
    ];

    public function getHIdAttribute()
    {
        return HashIds::encode($this->attributes['id']);
    }

    public function getCompanyHIdAttribute()
    {
        return HashIds::encode($this->attributes['company_id']);
    }

    public function getWarehouseHIdAttribute()
    {
        return HashIds::encode($this->attributes['warehouse_id']);
    }

    public function getProductHIdAttribute()
    {
        return HashIds::encode($this->attributes['product_id']);
    }

    public function getBaseProductUnitHIdAttribute()
    {
        return HashIds::encode($this->attributes['base_product_unit_id']);
    }

    public function getDisplayProductUnitHIdAttribute()
    {
        return HashIds::encode($this->attributes['display_product_unit_id']);
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function baseProductUnit()
    {
        return $this->belongTo('App\Models\ProductUnit', 'base_product_unit_id');
    }

    public function displayProductUnit()
    {
        return $this->belongTo('App\Models\ProductUnit', 'display_product_unit_id');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse', 'warehouse_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->updated_by = $user->id;
            }
        });

        static::deleting(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->deleted_by = $user->id;
                $model->save();
            }
        });
    }
}
<?php
namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Orders extends Model
{	
	use Sluggable;
    use SluggableScopeHelpers;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku', 'title', 'slug', 'city_start','city_end', 'location_start', 'location_end', 'date', 'type_car', 'number_car', 'package_name', 'package_weight', 'package_volume', 'price', 'name', 'phone', 'email', 'note', 'admin_note', 'status'
    ];
}
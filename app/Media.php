<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Media extends Model
{
	protected $fillable = [
        'image_path','title','caption','alt','description','type','width','height','size','cat_ids','user_id',
    ];
}

<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserMetas extends Model
{
	protected $fillable = [
        'banner','about','user_id',
    ];
}

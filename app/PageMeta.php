<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class PageMeta extends Model
{
  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_key','meta_value','page_id','created_at','updated_at',
    ]; 
}

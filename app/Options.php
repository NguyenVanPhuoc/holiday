<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Options extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo', 'logo_colorful', 'favicon', 'logo_sonabee', 'title', 'phone', 'email', 'address', 'copyright', 'page_id', 'show_gallery','facebook', 'google', 'youtube', 'twitter', 'instagram', 'social_media'
    ];
}

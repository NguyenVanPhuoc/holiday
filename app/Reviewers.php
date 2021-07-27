<?php
namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reviewers extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    protected $table = 'reviewers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'title', 'title_tag', 'content', 'from_date', 'to_date', 'gallery', 'list_destination', 'list_tour_style', 'list_city', 'group_type_id', 'image', 'banner', 'image_looking', 'image_request'
    ];

    /*
    * custom message validation
    */
    public static function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
            'name.required' => 'Please input the name',
            'slug.required' => 'Please input the slug',
            'group_type_id.required' => 'Please chose group type',
            'list_destination.required' => 'Please chose destination',
            'list_tour_style.required' => 'Please chose tour style',
        ];
    }

    public static function create_docfile_portrait($html)
    {
        return "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head><title>Microsoft Office HTML Example</title>
        <style> <!-- 
            @page
            {
                size: 21cm 29.7cm;  /* A4 */
                margin: 1.5cm 1.5cm 1.5cm 2.5cm; /* Margins: 2 cm on each side */
                mso-page-orientation: portrait;
            }
        @page Section1 { }
        div.Section1 { page:Section1; }
        --></style>
        </head>
        <body>
        <div class=Section1>
        ".$html."
        </div>
        </body>
        </html>";
    }
    public function group_type(){
        return $this->belongsTo('App\GroupType', 'group_type_id');
    }
}

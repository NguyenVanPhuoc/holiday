<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class PriceMetas extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'orperator', 'value', 'price_id',
    ];

    public function getPrice($type, $kilometer){
    	if($type == "ship"){
    		$priceMetas = PriceMetas::where('price_id',8)->get();
    	}else{
    		$priceMetas = PriceMetas::where('price_id',9)->get();
    	}

    	$price = 0;
		$search = array(' ', '-', 'km', '.');
		$replace = array('', '', '', ',');
		$km = str_replace($search, $replace, $kilometer);
    	foreach ($priceMetas as $item) {
			if($item->orperator == "<"){
				$kmMeta = (int)str_replace($search, $replace, $item->title);
				if($km <= $kmMeta){
					$price = $item->value;
					break;
				}
			}else if($item->orperator == "-"){
				$kmMeta = explode("-", $item->title);
				$minKm = (int)str_replace($search, $replace, $kmMeta[0]);
				$maxKm = (int)str_replace($search, $replace, $kmMeta[0]);
				if($km >= $minKm && $km <= $maxKm){
					$price = $item->value;
					break;
				}
			}else{
				$price = $item->value;
				break;
			}			
    	}
    	return $price;
    }
    //number format
    function formatPrice($price){
		return number_format($price,'0',',','.').' đ';
	}
}
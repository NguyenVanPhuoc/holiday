<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Media;
use App\User;
use App\UserMetas;
use App\Orders;
use Cart;
use Mail;

class OrderCarController extends Controller
{
	public function index(){
    	return view('order.show');
    }

    public function customerInfo(Request $request){        
    	return view('order.booking');
    }

    public function ticket($id){
        $order = Orders::find($id);        
    	return view('order.ticket',['order'=>$order]);
    }

    public function bookCarStep1(Request $request){
        $message = "error";
        if($request->ajax()):
        	$cityStart = explode("#", $request->cityStart);
            $cityEnd = explode("#", $request->cityEnd);
            $streetStart = $request->streetStart;
            $streetEnd = $request->streetEnd;
            $time = $request->time;
            $typeCar = $request->typeCar;
            $numberCar = $request->numberCar;
            $packageName = $request->packageName;
            $packageWeight = $request->packageWeight;
            $packageVolume = $request->packageVolume;
            $weightUnit = $request->weightUnit;
            $volumeUnit = $request->volumeUnit;
            $typeMoney = $request->typeMoney;
            $price = $request->price;            
            $typeOrder = $request->typeOrder;
            
            $booking = Cart::instance('booking')->content()->first();
            if($booking == NULL){               
                Cart::instance('booking')->add('car', $packageName, 1, $price, [
                    'cityStart' => $cityStart[1],
                    'cityEnd' => $cityEnd[1],
                    'streetStart' => $streetStart,
                    'streetEnd' => $streetEnd,
                    'time' => $time,
                    'typeCar' => $typeCar,
                    'numberCar' => $numberCar,
                    'packageName' => $packageName,
                    'packageWeight' => $packageWeight,
                    'packageVolume' => $packageVolume,
                    'weightUnit' => $weightUnit,
                    'volumeUnit' => $volumeUnit,
                    'typeMoney' => $typeMoney,
                    'typeOrder' => $typeOrder,
                ]);
            }else{                          
                Cart::instance('booking')->update($booking->rowId, ['name' => $packageName, 1, $price, 'options'=>[
                    'cityStart' => $cityStart[1],
                    'cityEnd' => $cityEnd[1],
                    'streetStart' => $streetStart,
                    'streetEnd' => $streetEnd,
                    'time' => $time,  
                    'typeCar' => $typeCar,
                    'numberCar' => $numberCar,
                    'packageName' => $packageName,
                    'packageWeight' => $packageWeight,
                    'packageVolume' => $packageVolume,
                    'weightUnit' => $weightUnit,
                    'volumeUnit' => $volumeUnit,
                    'typeMoney' => $typeMoney,
                    'typeOrder' => $typeOrder
                ]]);                
            }
            $message = "success";
        endif;
        return $message;
    }

    public function bookCar(Request $request){
        $message = "error";
        if($request->ajax()):
        	$booking = Cart::instance('booking')->content()->first();        	
        	$cityStart = get_city($booking->options->cityStart);
        	$cityEnd = get_city($booking->options->cityEnd);
        	$streetStart = $booking->options->streetStart;
        	$streetEnd = $booking->options->streetEnd;
        	$time = $booking->options->time;
            $typeCar = get_car($booking->options->typeCar);
        	$numberCar = $booking->options->numberCar;
        	$packageName = $booking->options->packageName;
            $packageWeight = $booking->options->packageWeight;
            $packageVolume = $booking->options->packageVolume;
            $typeOrder = $booking->options->typeOrder;
            $weightUnit = get_weight($booking->options->weightUnit);
            $volumeUnit = get_volume($booking->options->volumeUnit);
        	$typeMoney = get_money($booking->options->typeMoney);
        	$price_total = Cart::instance('booking')->total().'<small>'.$typeMoney['name'].'</small>';
        	$name = $request->name;
        	$phone = $request->phone;
        	$email = $request->email;
        	$note = $request->note;             
            
            $order = new Orders;
            $order->sku = tracking();
            $order->title = $cityStart['name'].' - '.$cityEnd['name'];
            $order->slug = $cityStart['name'].' - '.$cityEnd['name'];
            $order->city_start = $cityStart['name'];
            $order->city_end = $cityEnd['name'];
            $order->location_start = $streetStart;
            $order->location_end = $streetEnd;
            $order->date = $time;
            $order->type_car = $typeCar['name'];
            $order->number_car = $numberCar;
            $order->package_name = $packageName;
            $order->package_weight = $packageWeight.'<small>'.$weightUnit['name'].'</small>';
            $order->package_volume = $packageVolume.'<small>'.$volumeUnit['name'].'</small>';
            $order->price = $price_total;
            $order->name = $name;        
            $order->phone = $phone;
            $order->email = $email;
            $order->note = $note;
            $order->status = '000';
            if($typeOrder!=0){
                $order->type_order = $typeOrder;
            }
            if($order->save()){
                Cart::destroy();                
                $message = $order->id;
                //boroking order
                $content = '<ul>';
                $content .= '<li>Nơi gửi: '.$streetStart.'</li>';
                $content .= '<li>Nơi nhận: '.$streetEnd.'</li>';
                $content .= '<li>Người gửi: '.$name.'</li>';
                $content .= '<li>Điện thoại: '.$phone.'</li>';
                $content .= '<li>Email: '.$email.'</li>';
                $content .= '<li>Tên hàng: '.$packageName.'</li>';
                $content .= '<li>Ngày đóng: '.$time.'</li>';
                $content .= '<li>Khối lượng: '.$packageWeight.' '.$weightUnit['name'].'</li>';
                $content .= '<li>Thể tích: '.$packageVolume.' '.$volumeUnit['name'].'</li>';
                $content .= '<li>Xe yêu cầu: '.$typeCar['name'].'</li>';
                $content .= '<li>Mô tả thêm: '.$note.'</li>';
                $content .= '<li>Giá mong muốn: '.$order->price.'</li>';
                $content .= '</ul>';
                $data = array( 'email' => $email, 'name' => $name, 'from' => mailSystem(), 'phone'=>$phone, 'message'=> $content, 'packageName'=>$packageName);
                Mail::send( 'mails.admin.booking', compact('data'), function( $message ) use ($data){
                    $message->to(mailSystem())
                            ->from( $data['email'], $data['name'] )
                            ->subject( '[Web NetLoading] Thông tin yêu cầu mới - Mặt hàng '.$data['packageName']);
                });
                //booking customer
                $content = '<ul>';
                $content .= '<li>Nơi gửi: '.$streetStart.'</li>';
                $content .= '<li>Nơi nhận: '.$streetEnd.'</li>';
                $content .= '<li>Tên hàng: '.$packageName.'</li>';
                $content .= '<li>Ngày đóng: '.$time.'</li>';
                $content .= '<li>Khối lượng: '.$packageWeight.' '.$weightUnit['name'].'</li>';
                $content .= '<li>Thể tích: '.$packageVolume.' '.$volumeUnit['name'].'</li>';
                $content .= '<li>Xe yêu cầu: '.$typeCar['name'].'</li>';
                $content .= '<li>Mô tả thêm: '.$note.'</li>';
                $content .= '<li>Giá mong muốn: '.$order->price.'</li>';
                $content .= '</ul>';
                $data = array( 'email' => $email, 'name' => $name, 'from' => mailSystem(), 'phone'=>$phone, 'message'=> $content);
                Mail::send( 'mails.booking', compact('data'), function( $message ) use ($data){
                    $message->to($data['email'])
                            ->from( $data['email'], $data['name'] )
                            ->subject( '[Web NetLoading] Cảm ơn bạn đã gửi yêu cầu tới hệ thống');
                });
            }else{
                $message = 'error';    
            }
        endif;
        return $message;
    }
    //ticket detail
    public function ticketDetail(Request $request, $slug){
    	$order = Orders::findBySlug($slug);
		if(!empty($order))
			return view('order.ticketDetail',['order'=>$order]);
		else
			return redirect('/');
    }
    //check ticket
    public function checkTicket(Request $request){
    	if($request->ajax()){
    		$order = Orders::where('title', $request->code)->where('phone', $request->phone)->first();
    		if(!empty($order))
    			return '<div class="alert alert-success"><a href="'.url('/tra-cuu-ma-ve').'/'.$order->slug.'">Chi tiết mã vé <strong>'.$request->code.'</strong></a></div>';
    		else
    			return '<div class="alert alert-danger">Không tìm thấy đơn hàng <strong>'.$request->code.'</strong></div>';
    	}
    	return '<div class="alert alert-danger">Lỗi, trình duyệt bạn không hỗ trợ javascript</div>';
    }
}

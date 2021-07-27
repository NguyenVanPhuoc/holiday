<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\UserMetas;
use App\Orders;
use App\PriceMetas;

class OrderAdminController extends Controller
{
    public function index(Request $request){          
        $orders = Orders::latest('created_at')->paginate(14);
        return view('backend.order.list', compact('orders'));
        
    }

    public function update(Request $request){       
        if($request->ajax()){
            $order = Orders::find($request->id);
            $order->status = $request->status;
            $order->save();
            $array = array(
                'clas' => "status txt-center status-".$request->status,
                'text' => $request->text,
            );
            return json_encode($array);
        }
        return 'error';
    }
    //filter order by type
    public function filterStatus($status, $type){
        if(($status=="" || $status=="all") && $type =="all" ):
            $orders = Orders::latest('created_at')->paginate(14);
        elseif($status!="" && $type=="all"):
            $orders = Orders::where('status','=',$status)->latest('created_at')->paginate(14);
        elseif($status!="" && $status!="all" && $type!=""):
            $orders = Orders::where('status','=',$status)->where('type_order','=',$type)->latest('created_at')->paginate(14);
        else:
            $orders = Orders::where('type_order','=',$type)->latest('created_at')->paginate(14);
        endif;
        return view('backend.order.list', ['type'=>$type, 'status'=>$status, 'orders'=>$orders]);
    }
    //filter order by date
    public function filterDate(Request $request){
        $this->validate($request,[
            'd'=>'required',
            ],[
            'd.required'=>'Vui chọn khoản thời gian cần tìm.',
        ]);
        $date = explode("to", $request->d);
        $from = trim($date[0]);
        $to = trim($date[1]);
        if(isset($request->status) && $request->status!='all')
            $orders = Orders::where('status','=',$request->status)->whereBetween('date',[$from, $to])->latest('created_at')->paginate(14);
        else
            $orders = Orders::whereBetween('date',[$from, $to])->latest('created_at')->paginate(14);
        return view('backend.order.list', ['status'=>$request->status, 's'=>$request->s, 'orders'=>$orders, 'date'=>$request->d]);
    }

    //search orders
    public function search(Request $request){       
        if(isset($request->status))
            $orders = Orders::where('sku','like','%'.$request->s.'%')
                ->where('status','=',$request->status)
                ->latest('created_at')->paginate(14);          
        else
            $orders = Orders::where('sku','like','%'.$request->s.'%')->latest('created_at')->paginate(14);
        return view('backend.order.list', ['status'=>$request->status, 's'=>$request->s, 'orders'=>$orders]);
    }
    public function delete($id){
        $order = Orders::find($id);
        $order->delete();
        return redirect('/admin/orders/')->with('success','Xóa thành công');
    }

    public function note(Request $request){
        $message = "error";
        if($request->ajax()):
            $order = Orders::find($request->id);
            $order->admin_note = $request->note;
            $order->save();
            $message = "success";
        endif;
        return $message;
    }
}

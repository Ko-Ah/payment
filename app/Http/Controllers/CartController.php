<?php

namespace App\Http\Controllers;
use App\Models\File;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{

    public function index(){
        $user_id = Auth::id();
        $user = User::find($user_id);
        return view('dashboard.store.cart',[
            'user'=>$user,
        ]);
    }
    public function show(){
        $user_id=Auth::id();
        $user=User::find($user_id);
        $sumPrices=  $user->items->sum('price');
        return response()->json([
            'sumPrices'=>$sumPrices
        ]);
    }
    public function store(Request $request)
    {

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->Items()->attach($user_id,['item_id'=>$request->id]);

        return response()->json(['success' => 'محصول به سبد خرید اضافه شد']);

    }
    public function detach(Request $request){
        $user_id = Auth::id();
        $user = User::find($user_id);
        $user->Items()->detach([$request->id]);
        $sumPrices=  $user->items->sum('price');

        return response()->json(['error'=>'محصول از سبد خرید حذف شد','sumPrices'=>$sumPrices]);

    }

    public function delete(Request $request){

        $order = Order::find($request->id);
        $response = $order->delete();
        return response()->json(['error','you deleted this order']);

    }
}

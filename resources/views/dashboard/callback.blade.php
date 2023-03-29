@extends('dashboard.layouts.app')
@section('content')

     <div class="col-md-7 mt-7 mb-4 m-left ">
         <div class="card mb-4">
             <div class="card-body pt-4 p-3 bg-success">

                 <h6 class="mb-0" class="text-danger">{{$message}}</h6>

                     @if(count($dataResponse) > 0)

                 <h6 class="mb-0" class="text-danger">@if($dataResponse['message'] ) {{$dataResponse['message']}} @endif</h6>
             </div>
             @if(count($transaction)>0 )
             <p>زمان تراکنش :{{$transaction['updated_at']}}</p>
             <div class="card-body pt-4 p-3">
                 <h6 class="mb-0" class="text-danger">شماره تراکنش : {{$transaction['transaction_id']}}</h6>
                 <h6 class="mb-0" class="text-danger"> مبلغ : {{$transaction['payment_amount']}} <span>ریال</span></h6>
                 <h6 class="mb-0" class="text-danger"> نام کاربر : {{$user->name}}</h6>
                 <h6 class="mb-0" class="text-danger"> شماره فاکتور : {{$transaction['order_num']}}</h6>
                 <h6 class="mb-0" class="text-danger"> شماره مرجع : {{$transaction['ref_num']}}</h6>
             </div>
             @endif
             @endif
         </div>
@endsection

@extends('dashboard.layouts.app')


@section('content')
        <div class="col-md-7 mt-7 mb-4 m-left ">
            <div class="card mb-4">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0"><span>آدرس:</span><span>@if($user->contact){{$user->contact->address}}@endif</span></h6>
                </div>

                <div class="card-body pt-4 p-3">
                    <h6 class="mb-0"><span>شماره کارت:</span><span>@if($user->account){{$user->account->account_num}}@endif</span></h6>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">پرداخت</h6>
                </div>

                <div class="card-body pt-4 p-3">

                    <p><span>قیمت کل : </span><span data-price>{{$data['data']['payment_amount']}}</span></p>
                    <div class=" text-start">
                    </div>
                    <form action="https://core.paystar.ir/api/pardakht/payment" method="post" id="form">
                        <input type="hidden" value="{{$data['data']['token']}}" name="token">
                        <button class="btn btn-danger text-light px-3 mb-0" type="submit" style="background: #f44335 !important;" value="submit">تایید</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <!--   Core JS Files   -->
    <script src="{{asset('js/jquery-3.6.1.min.js')}}"></script>
    <script src="{{asset('js/core/popper.min.js')}}"></script>
    <script src="{{asset('/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script>
        window.onload=function(){
            var auto = setTimeout(function(){ autoRefresh(); }, 100);

            function submitform(){
                document.forms["form"].submit();
            }

            function autoRefresh(){
                clearTimeout(auto);
                auto = setTimeout(function(){ submitform(); autoRefresh(); }, 10000);
            }
        }
    </script>
@endpush

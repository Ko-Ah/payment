@extends('dashboard.layouts.app')


@section('content')
    <div class="d-flex">
        <div class="col-md-8 mt-7 m-4 m-right">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">آدرس</h6>
                </div>

                <div class="card-body pt-4 p-3">
                    
                   {{-- <ul class="list-group">
                        @foreach($user->items as $item)

                            <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg d-flex justify-content-between ">
                                <div class="d-flex flex-column ">
                                    <h6 class="mb-3 text-sm"></h6>
                                    <span class="mb-2 text-xs">اسم : <span class="text-dark font-weight-bold ms-sm-2">{{$item->title}}</span></span>
                                    <span class="mb-2 text-xs">متن : <span class="text-dark ms-sm-2 font-weight-bold">{{$item->body}}</span></span>
                                    <span class="text-xs">قیمت : <span class="text-dark ms-sm-2 font-weight-bold">{{$item->price}}</span></span>
                                </div>
                                <div class=" text-start">
                                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;" data-item="{{$item->id}}" id="cart_item"><i class="material-icons text-sm me-2">delete</i>حذف</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>--}}
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-7 m-left">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">پرداخت</h6>
                </div>

                <div class="card-body pt-4 p-3">
                    <p><span>قیمت کل : </span><span data-price>0</span></p>
                    <div class=" text-start">
                        <button class="btn btn-danger text-light px-3 mb-0" type="submit" style="background: #f44335 !important;" >پرداخت</button>
                    </div>
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
        $('body').on('click','#cart_item',function (e){

            var id = $(this).data("item");
            var item = $(this).parent().parent();
            e.preventDefault();
            let _token   = $('meta[name="csrf-token"]').attr('content');

            swal({
                title: `برای حذف محصول مطمئن هستید؟`,
                text: "در صورت حذف امکان بازگشت محصول وجود ندارد",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "لغو",
                        value: true,
                        visible: true,
                    },
                    confirm: {
                        text: "تایید",
                        value: true,
                        visible: true,
                    },
                },
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ url('/cart-delete-item') }}",
                            type:'get',
                            data: {
                                _token: _token,
                                id:id
                            },
                            success: function(data){
                                $('[data-price]').text(data.sumPrices)
                                item.remove();
                            },
                            error:function($response){
                                $('.alert').show();
                                $('.alert').html('error');
                            }
                        });
                    }
                });
        });

        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ url('/cart-fetch-total-price') }}",
            type:'get',
            data: {
                _token: _token,
            },
            success: function(data){
                $('[data-price]').text(data.sumPrices)
            },
            error:function($response){
                $('.alert').show();
                $('.alert').html('error');
            }
        });
    </script>
@endpush

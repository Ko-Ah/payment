<?php $__env->startSection('content'); ?>
    <div class="d-flex">
        <div class="col-md-7 mt-7 m-4 m-right">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">سبد خرید</h6>
                </div>

                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                        <?php if(count($user->items) > 0): ?>
                        <?php $__currentLoopData = $user->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg d-flex justify-content-between ">
                                <div class="d-flex flex-column ">
                                    <h6 class="mb-3 text-sm"></h6>
                                    <span class="mb-2 text-xs">اسم : <span class="text-dark font-weight-bold ms-sm-2"><?php echo e($item->title); ?></span></span>
                                    <span class="mb-2 text-xs">متن : <span class="text-dark ms-sm-2 font-weight-bold"><?php echo e($item->body); ?></span></span>
                                        <span class="text-xs">قیمت : <span class="text-dark ms-sm-2 font-weight-bold"><?php echo e($item->price); ?></span></span>
                                </div>
                                <div class=" text-start">
                                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;" data-item="<?php echo e($item->id); ?>" id="cart_item"><i class="material-icons text-sm me-2">delete</i>حذف</a>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-7 mb-4 m-left ">
            <div class="card mb-4">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0"><span>آدرس:</span><span><?php if($user->contact): ?><?php echo e($user->contact->address); ?><?php endif; ?></span></h6>
                </div>

                <div class="card-body pt-4 p-3">
                    <h6 class="mb-0"><span>شماره کارت:</span><span><?php if($user->account): ?><?php echo e($user->account->account_num); ?><?php endif; ?></span></h6>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">پرداخت</h6>
                </div>

                <div class="card-body pt-4 p-3">
                   <p><span>قیمت کل : </span><span data-price>0</span></p>
                    <div class=" text-start">
                        <form action="<?php echo e(route('pay')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" data-price value="" name="amount">
                            <button class="btn btn-danger text-light px-3 mb-0" type="submit"   style="background: #f44335 !important;" data-send>پرداخت</button>

                        </form>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <!--   Core JS Files   -->
    <script src="<?php echo e(asset('js/jquery-3.6.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/core/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/core/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/sweetalert.min.js')); ?>"></script>
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
                url: "<?php echo e(url('/cart-delete-item')); ?>",
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
                url: "<?php echo e(url('/cart-fetch-total-price')); ?>",
                type:'get',
                data: {
                    _token: _token,
                },
                success: function(data){
                    $('[data-price]').text(data.sumPrices)
                    $('[data-price]').val(data.sumPrices)
                },
                error:function($response){
                    $('.alert').show();
                    $('.alert').html('error');
                }
            });

        /* $('body').on('click','[data-send]',function (e) {
             let _token = $('meta[name="csrf-token"]').attr('content');
             $amount = $('[data-price]').text();
             $orderId = $('[data-order]').val();
             $.ajax({
                 url: "/dashboard/order",
                 Accept: 'application/json',
                 type: 'get',
                 data: {
                     _token: -_token,
                     amount: $amount,
                 },
                 success: function (data) {
                         console.log(data)
                     $('[data-order]').val(data.data[0])
                     $('[data-sign]').val(data.data[3])
                 },
                 error: function ($response) {
                     $('.alert').show();
                     $('.alert').html('error');
                 }
           });

            /* if($('[data-sign]').val() !=""){
                 $sign= $('[data-sign]').val()
                 console.log($sign)
                 console.log( $('[data-order]').val())
                 $.ajax({
                     url: "https://core.paystar.ir/api/pardakht/create",
                     Accept:'application/json',
                     type:'post',
                     beforeSend:function(xhr){
                         xhr.setRequestHeader('Authorization','Bearer 0yovdk2l6e143')
                     },
                     data: {
                         "amount":$amount,
                         "order_id": $('[data-order]').val(),
                         "callback":"https://tecstar.ir/callback",
                         "sign":$sign

                     },
                     success: function(data){
                         console.log(data)
                     },
                     error:function($response){
                         $('.alert').show();
                         $('.alert').html('error');
                     }
                 });
             }
        });*/

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kosar ahmadian\payStar\resources\views/dashboard/store/cart.blade.php ENDPATH**/ ?>
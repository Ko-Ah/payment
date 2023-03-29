<?php $__env->startSection('content'); ?>
        <div class="col-md-7 mt-7 mb-4 m-left ">
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

                    <p><span>قیمت کل : </span><span data-price><?php echo e($data['data']['payment_amount']); ?></span></p>
                    <div class=" text-start">
                    </div>
                    <form action="https://core.paystar.ir/api/pardakht/payment" method="post" id="form">
                        <input type="hidden" value="<?php echo e($data['data']['token']); ?>" name="token">
                        <button class="btn btn-danger text-light px-3 mb-0" type="submit" style="background: #f44335 !important;" value="submit">تایید</button>
                    </form>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kosar ahmadian\payStar\resources\views/dashboard/payment.blade.php ENDPATH**/ ?>
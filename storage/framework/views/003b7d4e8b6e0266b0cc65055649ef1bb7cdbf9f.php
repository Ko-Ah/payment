<?php $__env->startSection('content'); ?>

     <div class="col-md-7 mt-7 mb-4 m-left ">
         <div class="card mb-4">
             <div class="card-body pt-4 p-3 bg-success">

                

                    

                 <h6 class="mb-0" class="text-danger"><?php if($dataResponse['message'] ): ?> <?php echo e($dataResponse['message']); ?> <?php endif; ?></h6>
             </div>
             <?php if(count($transaction)>0 ): ?>
             <p>زمان تراکنش :<?php echo e($transaction['updated_at']); ?></p>
             <div class="card-body pt-4 p-3">
                 <h6 class="mb-0" class="text-danger">شماره تراکنش : <?php echo e($transaction['transaction_id']); ?></h6>
                 <h6 class="mb-0" class="text-danger"> مبلغ : <?php echo e($transaction['payment_amount']); ?> <span>ریال</span></h6>
                 <h6 class="mb-0" class="text-danger"> نام کاربر : <?php echo e($user->name); ?></h6>
                 <h6 class="mb-0" class="text-danger"> شماره فاکتور : <?php echo e($transaction['order_num']); ?></h6>
                 <h6 class="mb-0" class="text-danger"> شماره مرجع : <?php echo e($transaction['ref_num']); ?></h6>
             </div>
             <?php endif; ?>
          
         </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kosar ahmadian\payStar\resources\views/dashboard/callback.blade.php ENDPATH**/ ?>
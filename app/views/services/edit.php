<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topnav.php';?>
<?php require APPROOT . '/views/inc/sidenav.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <a href="<?php echo URLROOT;?>/services" class="btn btn-dark btn-sm mt-2"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
          <div class="col-sm-6">
           
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card bg-light">
                    <div class="card-header bg-secondary">Edit Service</div>
                        <div class="card-body">
                            <form action="<?php echo URLROOT;?>/services/update" method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date">Date</label>
                                        <input type="date" name="date" id="date" 
                                            class="form-control form-control-sm mandatory
                                            <?php echo (!empty($data['date_err'])) ? 'is-invalid' : ''?>"
                                            value="<?php echo (!empty($data['date'])) ? $data['date'] : $data['service']->ServiceDate ?>">
                                        <span class="invalid-feedback"><?php echo $data['date_err']; ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="service">Service Type</label>
                                        <select name="service" id="service" 
                                                class="form-control form-control-sm mandatory
                                                <?php echo (!empty($data['service_err'])) ? 'is-invalid' : ''?>">
                                            <?php foreach($data['services'] as $service) : ?>
                                                <option value="<?php echo $service->ID;?>" 
                                                    <?php selectdCheckEdit($data['sservice'],
                                                          $data['service']->ServiceTypeId,$service->ID) ?>>
                                                    <?php echo strtoupper($service->Service);?>
                                                </option>
                                            <?php endforeach; ?>    
                                        </select>
                                        <span class="invalid-feedback"><?php echo $data['service_err']; ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="customer">Customer</label>
                                        <select name="customer" id="customer" 
                                                class="form-control form-control-sm mandatory
                                                <?php echo (!empty($data['customer_err'])) ? 'is-invalid' : ''?>">
                                            <?php foreach($data['customers'] as $customer) : ?>
                                                <option value="<?php echo $customer->ID;?>" 
                                                    <?php selectdCheckEdit($data['customer'],$data['service']->CustomerId,$customer->ID) ?>>
                                                    <?php echo strtoupper($customer->CustomerName);?>
                                                </option>
                                            <?php endforeach; ?>    
                                        </select>
                                        <span class="invalid-feedback"><?php echo $data['customer_err']; ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="amount">Service Charges</label>
                                        <input type="number" name="amount" id="amount" 
                                            class="form-control form-control-sm mandatory
                                            <?php echo (!empty($data['amount_err'])) ? 'is-invalid' : ''?>"
                                            value="<?php echo (!empty($data['amount_err'])) ? $data['amount'] : $data['service']->Amount ?>">
                                        <span class="invalid-feedback"><?php echo $data['amount_err']; ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="paid">Amount Paid</label>
                                        <input type="number" name="paid" id="paid" 
                                            class="form-control form-control-sm"
                                            value="<?php echo (!empty($data['paid'])) ? $data['paid'] : $data['service']->Paid ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="balance">Balance</label>
                                        <input type="text" name="balance" id="balance" 
                                            class="form-control form-control-sm"
                                            value="<?php echo $data['balance']; ?>" readonly>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="narration">Description</label>
                                        <input type="text" name="narration" id="narration" 
                                            class="form-control form-control-sm mandatory
                                            <?php echo (!empty($data['narration_err'])) ? 'is-invalid' : ''?>"
                                            value="<?php echo (!empty($data['narration_err'])) ? $data['narration'] : strtoupper($data['service']->Narration) ?>"
                                            placeholder="Enter Service Description">
                                        <span class="invalid-feedback"><?php echo $data['narration_err']; ?></span>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <input type="hidden" name="id" value="<?php echo $data['service']->ID;?>">
                                        <button type="submit" class="btn btn-sm btn-block bg-custom text-white">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php require APPROOT . '/views/inc/footer.php'?>
<script>
    const getBalance = function(){
        let sericeCharges = document.getElementById('amount');
        let amountPaid = document.getElementById('paid');
        let balance = 0;
        let balanceInput = document.getElementById('balance');
        balance = Number(sericeCharges.value) - Number(amountPaid.value);
        
        balanceInput.value = balance
    }

    document.getElementById('amount').addEventListener('keyup', getBalance);
    document.getElementById('paid').addEventListener('keyup', getBalance);

</script>
</body>
</html>  
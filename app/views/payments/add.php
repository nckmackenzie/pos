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
            <a href="<?php echo URLROOT;?>/payments" class="btn btn-dark btn-sm mt-2"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row col-md-8 mx-auto">
            <div class="card bg-light">
                <div class="card-header bg-secondary">Receive Payment</div>
                <div class="card-body">
                    <form action="<?php echo URLROOT;?>/payments/create" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer">Customer</label>
                                    <select name="customer" id="customer" style="width: 100%;"
                                            class="form-control form-control-sm select2 mandatory
                                            <?php echo (!empty($data['customer_err'])) ? 'is-invalid' : ''?>">
                                        <option value="" selected disabled>Select Customer</option>
                                        <?php foreach($data['customers'] as $customer) : ?>
                                            <option value="<?php echo $customer->ID;?>" <?php selectdCheck($data['customer'],$customer->ID) ?>>
                                                <?php echo $customer->CustomerName;?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="invalid-feedback"><?php echo $data['customer_err'];?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="idate">Payment Date</label>
                                    <input type="date" name="idate" id="idate"
                                        class="form-control form-control-sm mandatory
                                        <?php echo (!empty($data['date_err'])) ? 'is-invalid' : ''?>"
                                        value="<?php echo (!empty($data['date'])) ? $data['date'] : date('Y-m-d');?>">
                                    <span class="invalid-feedback"><?php echo $data['date_err'];?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="owed">Amount Owed</label>
                                    <input type="text" name="owed" id="owed" class="form-control form-control-sm" readonly>
                                    <input type="hidden" name="due" id="due">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="amount">Current Payment</label>
                                    <input type="number" name="amount" id="amount"
                                        class="form-control form-control-sm mandatory
                                        <?php echo (!empty($data['amount_err'])) ? 'is-invalid' : ''?>"
                                        value="<?php echo $data['amount'];?>">
                                    <span class="invalid-feedback"><?php echo $data['amount_err'];?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="paymethod">Payment Method</label>
                                    <select name="paymethod" id="paymethod"
                                            class="form-control form-control-sm mandatory">
                                        <?php foreach ($data['paymethods'] as $paymethod)  : ?>
                                            <option value="<?php echo $paymethod->ID;?>" <?php selectdCheck($data['paymethod'],$paymethod->ID)?>>
                                                <?php echo $paymethod->PaymentMethod;?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reference">Payment Reference</label>
                                    <input type="text" name="reference" id="reference"
                                        class="form-control form-control-sm mandatory
                                        <?php echo (!empty($data['ref_err'])) ? 'is-invalid' : ''?>"
                                        value="<?php echo $data['ref'];?>">
                                    <span class="invalid-feedback"><?php echo $data['ref_err'];?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" 
                                           class="form-control form-control-sm"
                                           value="<?php echo $data['description'];?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bal">Balance</label>
                                    <input type="text" name="balance" id="balance" 
                                           class="form-control form-control-sm" 
                                           value="<?php echo $data['balance'];?>"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-block btn-sm bg-custom text-white">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php require APPROOT . '/views/inc/footer.php'?>
<script>
    $(function(){
        $('.select2').select2();

        $('#customer').on('change',function(){
            var customer = $(this).val();
            //ajax to get balance
            $.ajax({
                url : '<?php echo URLROOT?>/payments/getbalance',
                method : 'GET',
                data : {customer : customer},
                success : function(data){
                    $('#owed').val(format_number(Number(data)));
                    $('#due').val(Number(data))
                }
            });
        });

        $('#amount').on('keyup change',function(){
            var balance = ($('#due').val() == '') ? 0 : Number($('#due').val());
            var current = $(this).val();

            var closingBalance = parseFloat(balance) - parseFloat(current);
            $('#balance').val(closingBalance);
        });

        function format_number(n) {
          return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        }
    });
</script>
</body>
</html>  
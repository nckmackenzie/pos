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
             <?php if($_SESSION['utype'] == 1) :?>
                <a href="<?php echo URLROOT;?>/sales/sales" class="btn btn-primary btn-sm">Go To All Sales</a>  
             <?php endif; ?>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div id="alerts">
        
        </div>        
        <form action="<?php echo URLROOT;?>/sales/create" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="saleid">Sales ID</label>
                        <input type="text" name="saleid" class="form-control form-control-sm" 
                               value="<?php echo $data['id'];?>"
                               readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sdate">Sales Date</label>
                        <input type="date" name="sdate" id="sdate" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="customer">Customer</label>
                        <select name="customer" id="customer" class="form-control form-control-sm" required>
                            <option value="" selected disabled>Select Customer</option>
                            <?php foreach($data['customers'] as $customer) : ?>
                                <option value="<?php echo $customer->ID;?>"><?php echo $customer->CustomerName;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table class="table table-sm table-bordered table-stripped" id="salesTable">
                        <thead class="bg-navy">
                            <tr>
                                
                                <th>Product</th>
                                <th width="10%">Stock</th>
                                <th width="10%">Qty</th>
                                <th width="10%">Rate</th>
                                <th width="10%">Value</th>
                                <th width="5%">
                                    <center><button type="button" id="add" class="btn btn-sm btn-primary" onclick="addItem();">
                                        <i class="bi bi-plus"></i>
                                    </button></center>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>    
            <div class="row">
                <div class="col-sm-9"></div>
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subtotal">Sub Total</label>
                                <input type="text" name="subtotald" id="subtotald" 
                                    class="form-control form-control-sm" readonly>
                                <input type="hidden" name="subtotal" id="subtotal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm" id="discount" name="discount"
                                        placeholder="Discount" 
                                        aria-label="Discount">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="total">Total Amount</label>
                                <input type="text" name="totald" id="totald"
                                    class="form-control form-control-sm" readonly>
                                <input type="hidden" name="total" id="total">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paid">Paid</label>
                                <input type="number" name="paid" id="paid" 
                                    class="form-control form-control-sm">
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="due">Due</label>
                                <input type="text" name="dued" id="dued" 
                                    class="form-control form-control-sm" readonly>
                                <input type="hidden" name="due" id="due">
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    <button type="submit" class="btn btn-sm btn-block bg-custom text-white">Save</button>
                </div>
            </div> 
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php require APPROOT . '/views/inc/footer.php'?>
<script>
     let items = 0;
    function addItem() {
       let html = `
          <tr>
              
                <td><select name="product[]" class="form-control form-control-sm select2 prod">
                    <option value="0" disabled selected>Select Product</option>
                      <?php foreach($data['products'] as $product) : ?>
                                    <option value="<?php echo $product->ID;?>"><?php echo $product->ProductName;?></option>
                      <?php endforeach; ?>
                    </select>
              </td>
              <td><input name="stock" type="text" class="form-control form-control-sm stock" readonly></td>
              <td><input name="qty[]" type="number" class="form-control form-control-sm qty"></td>
              <td><input name="rate[]" type="text" class="form-control form-control-sm rate" readonly></td>
              <td><input name="value[]" type="text" class="form-control form-control-sm value" readonly></td>
              <td><center><button type="button" class="btn btn-sm btn-danger btnremove">
                            <i class="bi bi-trash"></i>
                  </button></center>
              </td>
          </tr>`;
          document.getElementById("tbody").insertRow().innerHTML = html;
          $('.select2').select2();
    }

    $(function(){
        

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        // $('#customer').select2();

        $('#salesTable').on('change','.prod' , function(){
            var product = $(this).val();
            var tr = $(this).parent().parent();
            // console.log(product);
            $.ajax({
                url : '<?php echo URLROOT;?>/sales/getdetails',
                method : 'get',
                data : {product : product},
                dataType: 'json',
                success : function(html){
                    // console.log(html);
                    tr.find('.stock').val(html["stock"]);
                    tr.find('.rate').val(html["sp"]);
                    $('#rate'+items).val(html);
                }
            });

            var rowCount = $('#salesTable tbody tr').length;
            if (Number(rowCount) > 1) {
                var table =$('#salesTable');
                var check_value = $(table).find(".prod").val();

                if(check_value == product) {
                    $('#alerts').html(`
                        <div class="alert custom-danger" role="alert">
                            Product Has Already Been Selected!
                        </div>
                    `);
                    $(this).closest('tr').remove();
                }
                else {
                    console.log("Not exist");
                }
            }
        });

        $('#salesTable').on('click','.btnremove',function(){
            $(this).closest('tr').remove();
            calculate();
        });

        $('#salesTable').delegate('.qty','keyup change',function(){
            var qty = $(this).val();
            var tr = $(this).parent().parent();
            if ((qty - 0) > (tr.find('.stock').val() - 0)) {
                $('#alerts').html(`
                    <div class="alert custom-danger" role="alert">
                        Qty Entered Is More Than Available Stock!
                    </div>
                `);
            }else{
                $('#alerts').html('');
                var price = tr.find('.rate').val();
                var value = qty * price;
                tr.find('.value').val(value);
                calculate();
            }
        });

        $('#discount').on('change',function(){
            calculate();
        });

        $('#paid').on('change',function(){
            calculate();
        });

        function calculate(){
            var subtotal = 0;
            var discount = ($('#discount').val() == '') ? 0 : Number($('#discount').val());
            var paid = ($('#paid').val() == '') ? 0 : Number($('#paid').val());
            var totalValue = 0;
            var due = 0;
            
            $('.value').each(function(){
                subtotal = subtotal + ($(this).val() * 1);
            });
            $('#subtotal').val(subtotal);
            $('#subtotald').val(format_number(subtotal));
            var discountedAmount = (Number(discount) / 100) * (Number(subtotal));
            totalValue = subtotal - discountedAmount;
            due = totalValue - paid;

            $('#total').val(totalValue);
            $('#totald').val(format_number(totalValue));
            $('#due').val(due);
            $('#dued').val(format_number(due));
            // console.log(discount);
        }

        $(document).ready(function(){
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            $('#sdate').val(today);
            // console.log(today);
        });

        function format_number(n) {
          return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        }

        setInterval(removeAlert,5000);

        function removeAlert(){
            $('#alerts').empty();
        }
    });
</script>
</body>
</html>  
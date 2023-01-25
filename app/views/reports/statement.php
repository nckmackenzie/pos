<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/topnav.php';?>
<?php require APPROOT . '/views/inc/sidenav.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-md-9 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customer">Customer</label>
                            <select name="customer" id="customer" class="form-control form-control-sm select2" style="width: 100%;">
                                <?php foreach($data['customers'] as $customer) : ?>
                                    <option value="<?php echo $customer->ID;?>"><?php echo $customer->CustomerName;?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="customer_err" style="color: #c90404; font-size:0.6rem"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="start">From</label>
                            <input type="date" name="start" id="start" class="form-control form-control-sm">
                            <span id="start_err" style="color: #c90404; font-size:0.6rem"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="end">To</label>
                            <input type="date" name="end" id="end" class="form-control form-control-sm">
                            <span id="end_err" style="color: #c90404; font-size:0.6rem"></span>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <button class="btn btn-sm btn-block bg-custom text-white preview">Preview</button>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div id="results" class="table-responsive">

                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php require APPROOT . '/views/inc/footer.php'?>
<script>
    $(function(){
        $('.select2').select2();
        $('.preview').click(function(){
            var table = $('#table').DataTable();
            var customer;
            var start;
            var end;
            if ($('#customer').val() == '') {
                $('#customer').css('border-color','#c90404');
                $('#customer_err').text('Select Customer');
            }else{
                $('#customer').css('border-color','');
                $('#customer_err').text('');
                customer = $('#customer').val();
            }
            if ($('#start').val() == '') {
                $('#start').css('border-color','#c90404');
                $('#start_err').text('Select Start Date');
            }else{
                $('#start').css('border-color','');
                $('#start_err').text('');
                start = $('#start').val();
            }
            if ($('#end').val() == '') {
                $('#end').css('border-color','#c90404');
                $('#end_err').text('Select End Date');
            }else{
                $('#end').css('border-color','');
                $('#end_err').text('');
                end = $('#end').val();
            }
            if ($('#start').val() == '' && $('#end').val() == '') {
                return
            }else{
                var startd = new Date($('#start').val());
                var endd = new Date($('#end').val());
                
                if (startd > endd) {
                    $('#start').css('border-color','#c90404');
                    $('#start_err').text('Start Date Cannot Be Greater Than End Date');
                    return
                }else{
                    $('#start').css('border-color','');
                    $('#start_err').text('');
                }
            }

            //ajax
            $.ajax({
                url : '<?php echo URLROOT;?>/reports/statementrpt',
                method : 'GET',
                data : {customer: customer,start : start, end : end},
                success : function(data) {
                    $('#results').html(data);
                    table.destroy();
                    table = $('#table').DataTable({
                        pageLength : 100,
                        fixedHeader : true,
                        "searching": false,
                        "buttons": ["excel", "pdf","print"],
                        "responsive" : true,
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;
                             // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };

                            function updateValues(cl){
                                total = api
                                      .column( cl )
                                      .data()
                                      .reduce( function (a, b) {
                                      return intVal(a) + intVal(b);
                                      },0);
                                return total;      
                            }

                            function format_number(n) {
                              return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
                            }
                            // Update footer
                            $('#debittotal').html(format_number(updateValues(1)));
                            $('#credittotal').html(format_number(updateValues(2)));
                        }
                        
                    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
                }
            });
        });
    });
</script>
</body>
</html>  
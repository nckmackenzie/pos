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
            <a href="<?php echo URLROOT;?>/receipts" class="btn btn-dark btn-sm mt-2"><i class="bi bi-arrow-left"></i> Back</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <form action="<?php echo URLROOT;?>/receipts/create" method="post">
          <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ref">Receipt Reference</label>
                        <input type="text" id="ref" class="form-control form-control-sm" name="ref" value="<?php echo $data['reference'];?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date">Receipt Date</label>
                        <input type="date" name="date" id="idate" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="supplier">Supplier</label>
                        <select name="supplier" id="supplier" class="form-control form-control-sm" required>
                            <?php foreach($data['suppliers'] as $supplier) : ?>
                                <option value="<?php echo $supplier->ID;?>"><?php echo $supplier->SupplierName;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
          </div>
          <div class="row">
            <div class="col-sm-12 table-responsive">
                <table class="table table-sm table-bordered table-stripped" id="receiptsTable">
                  <thead>
                      <th width="5%">#</th>
                      <th width="20%">Category</th>
                      <th>Product</th>
                      <th width="10%">Qty</th>
                      <th width="10%">Rate</th>
                      <th width="10%">Value</th>
                      <th width="5%">
                          <button type="button" class="btn btn-sm btn-info btnadd" onclick="addItem();">
                            <i class="bi bi-plus"></i>
                          </button>
                      </th>
                  </thead>
                  <tbody id="tbody"></tbody>
                </table>
                
            </div>
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
      items ++;
      let html = `
          <tr>
              <td>${items}</td>
              <td><select name="category[]" class="form-control form-control-sm" id="category">
                      <option value="0" disabled selected>Select Category</option>
                      <?php foreach($data['categories'] as $category) : ?>
                                    <option value="<?php echo $category->ID;?>"><?php echo $category->CategoryName;?></option>
                      <?php endforeach; ?>
                  </select></td>
              <td><select name="product[]" class="form-control form-control-sm prod" id="product${items}">
                  </select>
              </td>
              <td><input name="qty[]" type="number" class="form-control form-control-sm qty" id="qty${items}"></td>
              <td><input name="rate[]" type="text" class="form-control form-control-sm rate" id="rate${items}" readonly></td>
              <td><input name="value[]" type="text" class="form-control form-control-sm" id="value${items}" readonly></td>
              <td><button type="button" class="btn btn-sm btn-danger btnremove">
                            <i class="bi bi-trash"></i>
                          </button></td>
          </tr>`;
          document.getElementById("receiptsTable").insertRow().innerHTML = html;
    }

    $(function() {
        $('#receiptsTable').on('change','#category', function(){
          var category = $(this).val();
            $.ajax({
                url : '<?php echo URLROOT;?>/receipts/getproducts',
                method : 'POST',
                data : {category : category},
                success : function(html){
                  $('#product'+items).html(html);
                }
            });
          // $('#product'+items)
        })

        $('#receiptsTable').on('change','.prod' , function(){
            var product = $(this).val();
            // console.log(product);
            $.ajax({
                url : '<?php echo URLROOT;?>/receipts/getprice',
                method : 'POST',
                data : {product : product},
                success : function(html){
                   $('#rate'+items).val(html);
                }
            });
        });

        $('#receiptsTable').on('change','.qty', function(){
            var rate =  Number($('#rate'+items).val());
            var qty = Number($('#qty'+items).val());
            var value = rate * qty
            
            $('#value'+items).val(format_number(value));
        });

        function format_number(n) {
          return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        }

        $(window).on('load',function(){
            // var now = new Date();
            // var day = ("0" + now.getDate()).slice(-2);
            // var month = ("0" + (now.getMonth() + 1)).slice(-2);
            // var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            // // $('#date').val(today);
            // console.log(today);
        });
        
        $(document).ready(function(){
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            $('#idate').val(today);
            // console.log(today);
        });

        $('#receiptsTable').on('click','.btnremove',function(){
            // $(this).closest("tr").remove();
            $tr = $(this).closest('tr');
            
            let data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();

            $tr.remove();
        });
    });
</script>
</body>
</html>  
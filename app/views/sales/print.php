<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales <?php echo $data['header']->SalesID;?></title>
    <link rel="shortcut icon" href="<?php echo URLROOT;?>/img/cropped-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/plugins/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/dist/css/style.css">
    <style type="text/css" media="print">
    @page 
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }

    html
    {
        background-color: #FFFFFF; 
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

    body
    {
        border: solid 1px blue ;
        margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
    }
    </style>
</head>
<body>
    <div class="wrapper">
        <section class="invoice">
            <!-- title row -->
            <div class="row mb-3">
                <div class="col-12">
                    <h2 class="page-header">
                        <?php echo strtoupper($data['companyinfo']->CompanyName);?>
                    <small class="float-right">Date: <?php echo $data['header']->SaleDate;?></small>
                    </h2>
                </div><!-- /.col -->
            </div> <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    FROM
                    <address>
                        <strong><?php echo strtoupper($data['companyinfo']->CompanyName);?></strong>
                        <br>Address: <?php echo strtoupper($data['companyinfo']->Address);?>
                        <br>Phone: <?php echo $data['companyinfo']->Contact;?>
                        <br>Email: <?php echo $data['companyinfo']->Email;?>
                        <br>PIN:   <?php echo $data['companyinfo']->PIN;?>
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    TO
                    <address>
                        <strong><?php echo strtoupper($data['customerinfo']->CustomerName);?></strong>
                        <br>Address: <?php echo strtoupper($data['customerinfo']->Address);?>
                        <br>Phone: <?php echo $data['customerinfo']->Contact;?>
                        <br>Email: <?php echo $data['customerinfo']->Email;?>
                        <br>P.I.N: <?php echo $data['customerinfo']->PIN;?>
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #<?php echo $data['header']->SalesID;?></b><br>
                    <br>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th width="10%">QTY</th>
                                <th width="10%">RATE</th>
                                <th width="10%">GROSS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['details'] as $detail) : ?>
                                <tr>
                                    <td><?php echo $detail->ProductName; ?></td>
                                    <td><?php echo $detail->Qty; ?></td>
                                    <td><?php echo $detail->Rate; ?></td>
                                    <td><?php echo number_format($detail->SellingValue,2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!--End Of Col-->
            </div><!--End Of Row -->  
            <hr>  
            <div class="row">
                <div class="col-6">
                    <p class="lead">NOTES:</p>             
                </div><!--End Of Col-->
                <div class="col-6">
                    
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td><?php echo number_format($data['header']->SubTotal,2)?></td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td><?php echo number_format($data['header']->DiscountedAmount,2)?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td><?php echo number_format($data['header']->TotalAmount,2)?></td>
                            </tr>
                            <tr>
                                <th>Amount Paid</th>
                                <td><?php echo number_format($data['header']->AmountPaid,2)?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td><?php echo number_format($data['header']->Balance,2)?></td>
                            </tr>
                        </table>
                    </div>             
                </div><!--End Of Col-->                  
            </div><!--End Of Row -->
        </section><!--End Of invoice section -->
    </div><!--End Of Wrapper -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
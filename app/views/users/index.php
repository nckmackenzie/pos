<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>McPos | Login</title>
    <link rel="shortcut icon" href="<?php echo URLROOT;?>/dist/img/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <link href="<?php echo URLROOT;?>/dist/css/adminlte.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT;?>/dist/css/style.css" rel="stylesheet">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Source Sans Pro', sans-serif;
        }
    </style>
</head>
<body>
    <section class="lg-bx">
        <div class="imgBx">
            <img src="<?php echo URLROOT;?>/dist/img/cash-register.jpg" alt="">
        </div>
        <div class="contentBx">
            <div class="formBx">
                <h2>Login</h2>
                <form action="<?php echo URLROOT;?>/users/signin" method="post">
                    <div class="inputBx">
                        <label>User ID:</label>
                        <input type="text" name="userid" autocomplete="off"
                               class="form-control 
                               <?php echo (!empty($data['userid_err'])) ? 'is-invalid' :''?>"
                               value="<?php echo $data['userid'];?>"
                               placeholder="UserID">
                        <span class="invalid-feedback"><?php echo $data['userid_err'];?></span>
                    </div>
                    <div class="inputBx">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control 
                        <?php echo (!empty($data['password_err'])) ? 'is-invalid' :''?>"
                        value="<?php echo $data['password'];?>"
                        placeholder="Password">
                        <span class="invalid-feedback"><?php echo $data['password_err'];?></span>
                    </div>
                    <div class="inputBx">
                        <label for="company">Company</label>
                        <select name="company" id="company" class="form-control">
                            <?php if($data['count'] == 1) : ?>
                                <option value="<?php echo $data['companies']->ID;?>">
                                    <?php echo $data['companies']->CompanyName;?>
                                </option>
                            <?php endif;?>
                        </select>
                    </div>
                    <div class="inputBx">
                        <input type="submit" name="submit" value="Login" class="btn btn-block">
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
<?php

require_once 'models\Counter.php';

ActiveRecord\Config::initialize(function ($cfg) {
    $cfg->set_model_directory('models');
    $cfg->set_connections(array('development' =>
        'mysql://root@localhost/shopify'));
});

$SALT = "!@#FDSFSFSDF";
$PASSWORD = "qw3rty0p1o";

if (isset($_POST['password'])) {
    SetCookie("pswd", crypt($_POST['password'], $SALT), time() + 3600);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>4Q Admin</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <?php
        if (isset($_COOKIE['pswd']) && $_COOKIE['pswd'] == crypt($PASSWORD, $SALT)):?>
            <h3>Some usefull info:</h3>
            <h4>Emails sent: <span class="label label-info"><?php echo Counter::getEmailsCount(); ?></span></h4>
        <?php else : ?>
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-lock"></span> Login
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">
                                    Password</label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="inputPassword3" name="password"
                                           placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group last">
                                <div class="col-sm-offset-9">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Enter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

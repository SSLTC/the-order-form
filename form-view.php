<?php // This file is mostly containing things for your view / html ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Hopes and Dreams</title>
</head>
<body>
<div class="container">
    <?php if ($showConfirmation): ?>
    <div class="alert <?= $alertRole ?>" role="alert">
        <h4 class="alert-heading">Order confirmation!</h4>
        <p>
            <?php foreach ($_SESSION['Products'] as $i => $product) {
                if ($product['checked']) {
                    echo $product['name'], " - &euro; ", number_format($product['price'], 2), "<br>";
                }
            } ?>
        </p>
        <hr>
        <p class="mb-0">Will be sent to this address:<br />
        Street: <?= $_SESSION['Street'] ?> Nr.: <?= $_SESSION['Streetnumber'] ?><br />
        City: <?= $_SESSION['City'] ?> Zipcode: <?= $_SESSION['Zipcode'] ?></p>
        <?php if (!empty($invalidFields)): ?>
            <hr>
        <?php endif; ?>
        <?php foreach ($invalidFields as $message): ?>
        <?= $message; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <h1>Place your order</h1>
    <?php // Navigation for when you need it ?>
    <?php /*
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    */ ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= $_SESSION['Email'] ?? ''; ?>" />
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?= $_SESSION['Street'] ?? ''; ?>" />
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?= $_SESSION['Streetnumber'] ?? ''; ?>" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?= $_SESSION['City'] ?? ''; ?>" />
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?= $_SESSION['Zipcode'] ?? ''; ?>" />
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
					<?php // <?= is equal to <?php echo ?>
                    <input type="checkbox" value="1" name="product[<?= $i ?>]" <?= ($product['checked']) ? 'checked' : ''; ?>/> <?= $product['name'] ?> -
                    &euro; <?= number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
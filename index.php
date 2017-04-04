<?php
/**
 * User: Andrew Maris
 * Semperstack.com
 */

ini_set('display_errors','On');
require_once('db.php');
require_once('core.php');
$products = new Product();
$product = $products->getAllProducts($db);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP Cart</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<br/><br/>
<div class="container">
    <div class="row">
    <table class="table table-hover table-bordered">
        <thead><tr>
            <th class="col-md-4">Name</th>
            <th class="col-md-6">Description</th>
            <th class="col-md-1">Price</th>
            <th class="col-md-1">Options</th>
        </tr></thead>

<?php  foreach ($product as $p) {
    echo "<tbody><td>".$p->name."</td><td>".$p->description."</td><td>".number_format($p->price,2)."</td><td><a href='cart.php?add={$p->id}' class='btn btn-success'>Add to cart</a></td>   </tbody>";
}

?>

    </table>

<hr>
<?php $products->cart($db,$products); ?>

    </div>

</div>
</body>
</html>
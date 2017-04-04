<?php
/**
 * User: Andrew Maris
 * Semperstack.com
 */
require_once('db.php');
class Product
{
    private $total,$sub;

    public function getAllProducts($db)
    {
        $products = $db->query('SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC');
        if ($products->rowCount() < 1) {
            echo "<p>There are no products !</p>";
        } else {
            $product = $products->fetchAll(PDO::FETCH_OBJ);

        }
        return $product;
    }

    public function getById($db, $id)
    {
        if (!empty($db) && !empty($id)) {
            $product = $db->prepare("SELECT * FROM products WHERE id = :product_id");
            $product->execute([
                'product_id' => $id
            ]);

            return $product->fetchObject();

        } else {
            return "<p>Invalid data psssed !</p>";
        }
    }

    public function cart($db, $products)
    {
        echo "<table class='table table-bordered'><thead><th class='col-md-5'>Product</th><th class='col-md-1'>Amount</th><th class='col-md-1'>Price</th><th class='col-md-1'>Subtotal</th><th class='col-md-4 text-center'>Options</th></thead>";
        foreach ($_SESSION as $name => $value) {
            if ($value > 0) {
                if (substr($name, 0, 5) == 'cart_') {
                    $id = substr($name, 5, (strlen($name) - 5));
                    $name = $products->getById($db, $id)->name;
                    $price = $products->getById($db, $id)->price;
                    $this->sub = ($price * $value);
                    echo "<tbody>","<td>",$name, "</td><td>", $value, "</td><td>$", number_format($price, 2), "</td><td>$", number_format($this->sub, 2), "</td><td class='text-center'><a class='btn btn-danger' href='cart.php?remove={$id}'>-</a> <a  class='btn btn-success' href='cart.php?add={$id}'>+</a> <a  class='btn btn-danger' href='cart.php?delete={$id}'>Delete</a></td></tbody>";
                }

            }
            $this->total += $this->sub;
           }
           echo "</table>";

        if($this->total == 0){
            echo "Your cart is empty !";
        } else {
            echo "<div class='well'><b>Total : ", number_format($this->total, 2), "</b></div>";
echo <<<PAYPAL
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">

            <!-- Identify your business so that you can collect the payments. -->
            <input type="hidden" name="business" value="andrewmaris@protonmail.com">

            <!-- Specify a Buy Now button. -->
            <input type="hidden" name="cmd" value="_xclick">

            <!-- Specify details about the item that buyers will purchase. -->
            <input type="hidden" name="item_name" value="Products">
            <input type="hidden" name="amount" value="{$this->total}">
            <input type="hidden" name="currency_code" value="USD">

            <!-- Display the payment button. -->
            <input type="image" name="submit" border="0"
                   src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png"
                   alt="Buy Now">
            <img alt="" border="0" width="1" height="1"
                 src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

        </form>



PAYPAL;

        }
    }
}
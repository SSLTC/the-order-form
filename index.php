<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

// We are going to use session variables so we need to enable sessions
session_start();

// Use this function when you need to need an overview of these variables
function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

// TODO: provide some products (you may overwrite the example)
$products = [
    ['name' => 'Food for a hungry one', 'price' => 6, 'checked' => false],
    ['name' => 'Shoes for someone barefoot', 'price' => 45, 'checked' => false],
    ['name' => 'A sweater or a jacket for who has cold', 'price' => 39, 'checked' => false],
    ['name' => 'Some trousers for the one without', 'price' => 29.9, 'checked' => false],
];

if (isset($_SESSION['Products'])) {
    $products = $_SESSION['Products'];
}

$showConfirmation = false;

function calculateTotalPrice($totalPrice = 0) {
    $GLOBALS['totalValue'] = $totalPrice;
    if ($totalPrice !== 0) {
        return;
    }
    foreach ($GLOBALS['products'] as $product) {
        if ($product['checked']) {
            $GLOBALS['totalValue'] += $product['price'];
        }
    }
}
calculateTotalPrice();

function validate(): Array
{
    // TODO: This function will send a list of invalid fields back
    $invalidInput = array();

    if (empty($_SESSION['Street']) || 
        empty($_SESSION['Streetnumber']) || 
        empty($_SESSION['City']) || 
        empty($_SESSION['Zipcode'])
    ) {
        array_push($invalidInput, "All fields are required");
        return $invalidInput;
    }

    if (!filter_var($_SESSION['Email'], FILTER_VALIDATE_EMAIL)) {
        array_push($invalidInput, "Invalid email format");
    }

    if (!preg_match("/^[a-zA-Z-' ]*$/", $_SESSION['Street'])) {
        array_push($invalidInput, "Only letters and white space allowed with street<br>");
    }

    if (!preg_match("/^[a-zA-Z-' ]*$/", $_SESSION['City'])) {
        array_push($invalidInput, "Only letters and white space allowed with city<br>");
    }

    if (!is_numeric($_SESSION['Zipcode'])) {
        array_push($invalidInput, "Zipcode has to be numeric");
    }

    return $invalidInput;
}

function handleForm()
{
    // TODO: form related tasks (step 1)
    $_SESSION['Email'] = trim($_POST['email']);
    $_SESSION['Street'] = trim($_POST['street']);
    $_SESSION['Streetnumber'] = trim($_POST['streetnumber']);
    $_SESSION['City'] = trim($_POST['city']);
    $_SESSION['Zipcode'] = trim($_POST['zipcode']);

    $totalPrice = 0;
    foreach ($GLOBALS['products'] as $index => &$product) {
        if (isset($_POST['product'][$index])) {
            $product['checked'] = true;
        } else {
            $product['checked'] = false;
        }

        if ($product['checked']) {
            $totalPrice += $product['price'];
        }
    }
    calculateTotalPrice($totalPrice);

    $_SESSION['Products'] = $GLOBALS['products'];
    
    // Validation (step 2)
    $GLOBALS['invalidFields'] = validate();
    
    if (!empty($GLOBALS['invalidFields'])) {
        // TODO: handle errors
        $GLOBALS['alertRole'] = "alert-danger";
        $GLOBALS['showConfirmation'] = true;
    } else {
        // TODO: handle successful submission
        $GLOBALS['alertRole'] = "alert-success";
        $GLOBALS['showConfirmation'] = true;
    }
}

// TODO: replace this if by an actual check
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    handleForm();
}

require 'form-view.php';

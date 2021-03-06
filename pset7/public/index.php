<?php

    // configuration
    require("../includes/config.php"); 

$rows = CS50::query("SELECT * FROM portfolio WHERE user_id = ?", $_SESSION["id"]);
$money= CS50::query("SELECT * FROM users WHERE id=?", $_SESSION["id"]);
$money=$money[0]['cash'];
$money=number_format ( $money ,2 , "." , "," );
$positions = [];
foreach ($rows as $row)
{
    $stock = lookup($row["symbol"]);
    if ($stock !== false)
    {
        $positions[] = [
            "name" => $stock['name'],
            "price" => $stock['price'],
            "shares" => $row["shares"],
            "symbol" => $row["symbol"]
        ];
    }
}

    // render portfolio
   render("portfolio.php", ["title" => "Portfolio", "positions"=>$positions, "money"=>$money]);


?>

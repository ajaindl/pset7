<?php

 require("../includes/config.php"); 

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $type="BUY";
    $date=date("Y/m/d/ : h:i:sa");
    
    if(preg_match("/^\d+$/", $_POST["shares"])==true )
    {
      $stock=lookup($_POST["symbol"]);
      if($stock==false)
      {
          apologize("That is not a real symbol");
      }
      $price=$stock["price"];
      $symbol=$stock["symbol"];
      $shares=$_POST["shares"];
      $total=$price*$shares;
    
      
     $confirm=CS50::query("SELECT cash FROM users WHERE id=? ", $_SESSION["id"]);
     if($confirm[0]["cash"]<$total)
     {
         apologize("You do not have sufficient funds");
     }
     else
     {
        $submit= CS50::query("INSERT INTO portfolio (user_id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $stock["symbol"], $shares);
         if($submit=false)
         {
             apologize("Something has gone wrong");
         }
         else
         {
             CS50::query("UPDATE users SET cash=cash-$total");
             
             CS50::query("INSERT INTO history (user_id, trans_type, symbol, date, shares, price) VALUES (?, ?, ?, ?, ?,?)", $_SESSION["id"],$type, $symbol, $date, $shares,  $price);
         
             redirect("/");
         }
     }
      
    }
    else
    {
        apologize("You cannot buy fractional shares");
    }
}
else
{
    render("buy_form.php");
}
?>

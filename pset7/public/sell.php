<?php
// configuration
    require("../includes/config.php");
    
if($_SERVER["REQUEST_METHOD"]=="POST") 
{
        $type="SELL";
        $date=date("Y/m/d/ : h:i:sa");
        $price=lookup($_POST["di"]);
        $shares=CS50::query("SELECT shares FROM portfolio WHERE user_id=?", $_SESSION["id"]);
        $temp_shares=$shares[0]["shares"];
        $profit=$shares[0]["shares"] * $price["price"];
         CS50::query("DELETE FROM portfolio WHERE user_id =? AND symbol =?", $_SESSION["id"], $_POST["di"] );
         CS50::query("UPDATE users SET cash = cash + $profit WHERE id =?", $_SESSION["id"] );
         
    
        CS50::query("INSERT INTO history (user_id, trans_type, symbol, date, shares, price) VALUES (?, ?, ?, ?, ?,?)",$_SESSION["id"],$type, $_POST["di"], $date, $temp_shares,  $price["price"]);
         
         
         redirect("/");
}
    
    
    
    
    
    
    
else
{
    $options=CS50::query("SELECT * FROM portfolio WHERE user_id=?", $_SESSION["id"]);
    if($options==false)
    {
        apologize("You don't have any stock to sell");
    }
    else
    {
    render("sell_form.php", ["options"=>$options]);
    }

       
}



?>
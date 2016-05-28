<?php
    require("../includes/config.php"); 

    // if user reached page via GET 
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        //render form
        render("quote_form.php", ["title" => "Quote"]);
    }
    else if($_SERVER["REQUEST_METHOD"]== "POST")
    {
        $stock = lookup($_POST["symbol"]);
        if ($stock==false)
        {
            apologize("You entered an invalid symbol");
        }
        else
        {
         render("quote_return.php",["price"=>$stock]);
        }
    }
?>
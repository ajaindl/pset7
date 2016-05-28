<?php

require("../includes/config.php"); 

$info=CS50::query("SELECT * FROM history WHERE user_id=?", $_SESSION["id"]);

if($info==false)
{
    apologize("No History");
}
else
{
render("history_form.php", ["info"=>$info]);
}
  
 ?>
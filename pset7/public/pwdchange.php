<?php
 require("../includes/config.php"); 
 
 
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("password_form.php", ["title" => "Settings"]);
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $old=CS50::query("SELECT hash FROM users WHERE id=?", $_SESSION["id"]);
        if ($_POST["old_password"]==null || $_POST["new_password"]==null)
        {
        apologize("Must enter a password");
        }
        else if($_POST["new_password"]!=$_POST["confirmation"])
        {
            apologize("Your passwords do not match");

        }
        else if (password_verify($_POST["old_password"], $old[0]["hash"])==true)
        {   
            $password=$_POST["new_password"];
            
            
            $update=CS50::query("UPDATE users SET hash=? WHERE id=?",password_hash($_POST["new_password"], PASSWORD_DEFAULT), $_SESSION["id"]);
            
            if($update==false)
            {
                apologize("Something went wrong" );
            
            }
            else
            {
                redirect("/");
            }
        }
        else
                    
        {
       
        apologize("Did not input correct password");
        
        }
    }
?>
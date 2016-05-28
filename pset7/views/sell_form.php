
<form action="sell.php" method="post">
    <div class="form-group">
    <select align="center" name="di" >
        <?php
        foreach($options as $row)
        {
            echo "<option value='".$row["symbol"]."'>".$row["symbol"]."</option>";            
        }
        ?>

    </select>
</div>
<div>
    <input type="submit" value="sell"/>
        
</div>
</form>
<!-------------------- Example in handling array using checkbox ------------------- -->
<form method="post">
<input type="checkbox" name="op[]" value="kev">
<input type="checkbox" name="op[]" value="mac">
<input type="checkbox" name="op[]" value="mj">
<input type="checkbox" name="op[]" value="bing">
<input type="checkbox" name="op[]" value="jm">
<input type="submit">
</form> <!-- -->

<?php
   if(isset($_POST['op'])){
        foreach($_POST['op'] as $op){
            echo "$op is assigned to the ticket<br/>"; // $query = "INSERT IGNORE INTO .....";
        }
    }/* */
?>
<!-------------------- Example in handling array using checkbox ------------------- -->
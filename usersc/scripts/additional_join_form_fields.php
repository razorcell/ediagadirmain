<?php
// This file often teams up with during_user_creation.php although you can use that file without this one.
// However, if you add additional form fields here, you should process them there.
// We will do an example. Let's say you want to make use of the unused account_id column in the users table.

// Uncomment out the code below and it will automagically be inserted into your join form.
?>
<!-- <label for="confirm">Pick an account ID number</label>
<input type="number" class="form-control" min="0" step="1" name="account_id" value="" required> -->
<!-- 
<label for="team">Team</label>
<input type="text" class="form-control" name="team" value="" required> -->

<label for="team">Team</label>
<select name="team" required class="form-control">
    <option value="Fixed_Income_Euronext">Fixed_Income_Euronext</option>
    <option value="Fixed_Income_ECB">Fixed_Income_ECB</option>
    <option value="Fixed_Income_Brazil">Fixed_Income_Brazil</option>
    <option value="Fixed_Income_Perspektiva">Fixed_Income_Perspektiva</option>
    <option value="Fixed_Income_Bolsar">Fixed_Income_Bolsar</option>
    <option value="Fixed_Income_MAE">Fixed_Income_MAE</option>
    <option value="Equities_French">Equities_French</option>
</select>


<?php
//Now, go into the during_user_creation script to see how to process it.
?>
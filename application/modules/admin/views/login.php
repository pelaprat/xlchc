<table width='100%' height='100%'>
    <tr><td align='center'><h2>LCHC Admin Login</h2></td></tr>
    <tr><td valign='top' align='center' height='100%'>
        <form action='<?=(isset($_GET['from']) ? $_GET['from'] : "admin");?>' method='POST'>
        <table>
            <tr>
                <td valign='bottom'>Email:</td>
                <td>
                    <?=(check("bademail") . check("noe")) . "<br>";?> 
                    <input type='text' value='<?=(isset($_GET['email']) ? $_GET['email']:"")?>' name='email' size='40'/>
                </td>
            </tr>
            <tr>
                <td valign='bottom'>Password:</td>
                <td>
                    <?=(check("nomatch") . check("nop")) . "<br>";?> 
                    <input type='password' value='' name='password' size='40'/><br>
                </td>
            </tr>
            <tr><td colspan='2' align='center'><input type='submit' value='Login' /></td></tr>
        </table>
        </form>
    </td></tr>
</table>


<?php

function check($errorVal){
    if(null == $errorVal || !isset($_GET['errors'])) return "";
    
    if(!in_array($errorVal, explode(",", $_GET['errors']))) return "";
    
    switch($errorVal){
        case "bademail": return "<font color='red'>The email provided was not found.</font>";
        case "nomatch": return "<font color='red'>Incorrect password.</font>";
        case "noe": return "<font color='red'>Please provide your email address.</font>";
        case "nop": return "<font color='red'>Please provide your password.</font>";
    }

}


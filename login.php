<?php

// Inialize session
session_start();

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['username'])) {
header('Location: beer.php');
}
?>
<title>Beer Login</title>

<form method="POST" action="loginproc.php" class="panel" title="User Login" selected="true">
<fieldset>
<div class="row">
<label>Username</label><input type="text" name="username" /></div>
<div class="row">
<label>Password</label><input type="password" name="password" /></div>
<input type="submit" value="Login">
</fieldset>
</form>

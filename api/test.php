<?php
$pass = "test";

$salt = openssl_random_pseudo_bytes(16);
echo "<br>";
echo base64_encode($salt);
echo "<br>";
$hash = crypt($pass, '$6$rounds=5000$' . $salt);

echo $hash;

$hash1 = crypt($pass, $hash);



echo "<br>";

echo $hash1;
echo "<br>";

echo $hash == $hash1;




?>

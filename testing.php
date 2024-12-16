<?php
$hashFromDB = '$2y$10$CZsILBXa1xD4AcMD0TRJsO1PE6uf7vXMPmn6ZX/5ghh8Q2kIYFT5q';
var_dump(password_verify('password123', $hashFromDB));
?>

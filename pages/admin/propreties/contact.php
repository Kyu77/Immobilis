<?php

$_SESSION["success"] = "Vous etes déconnecté";
header("Location: /immobilis/index.php");
session_destroy();

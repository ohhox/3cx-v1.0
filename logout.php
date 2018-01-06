<?php

setcookie('uid', '', time() - 9999999);
unset($_COOKIE['uid']);
header('Location: login.php');

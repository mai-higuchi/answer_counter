<?php
 session_start();
 unset($_SESSION);
 session_destroy();
 header('Location:login.html');    //ログアウトして、ログイン画面へ遷移
?>
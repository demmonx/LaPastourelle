<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1, true);
?>
<div class='modif-titre'>
<?php require 'list_titre.php'; ?>
</div>


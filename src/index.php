<?php
require_once 'inc.header.php';
require_once 'inc.function.php';
require_once 'inc.top_page.php';
require_once 'inc.footer.php';
top();

if (isset($_GET['page'])) {
    if ($_GET['page'] == 'page_generic' && isset($_GET['id']) &&
             is_numeric($_GET['id'])) {
        $page = $_GET["id"];
        $type = isset($_GET["type"]) ? $_GET["type"] : null;
        require_once ("page_generic.php");
    } else 
        if (! strstr($_GET['page'], 'http://') && ! strstr($_GET['page'], 
                'www.') && ! strstr($_GET['page'], '/') &&
                 file_exists($_GET['page'] . '.php')) {
            // && file_exists($_GET['page'])) {
            require_once ($_GET['page'] . ".php");
        } else {
            require_once ("page_accueil.php");
        }
} else {
    require_once ("page_accueil.php");
}
footer();
?>

		

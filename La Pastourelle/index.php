<?php
require_once 'header.inc.php';
require_once 'footer.inc.php';
require_once 'top_page.inc.php';
top();
		
		if (isset ( $_GET ['page'] )) {
			if ($_GET ['page'] == 'generic' && isset ( $_GET ['id'] ) && is_numeric ( $_GET ['id'] )) {
				$page = $_GET ["id"];
				$type = isset ( $_GET ["type"] ) ? $_GET ["type"] : null;
				require_once ("generic.php");
			} else if (! strstr ( $_GET ['page'], 'http://' ) && ! strstr ( $_GET ['page'], 'www.' ) && ! strstr ( $_GET ['page'], '/' )) {
				// && file_exists($_GET['page'])) {
				require_once ($_GET ['page'] . ".php");
			} else {
				require_once ("accueil.php");
			}
		} else {
			require_once ("accueil.php");
		}
		require_once 'footer.inc.php';
		footer();
		?>

		

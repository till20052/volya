<? include "common/header.php" ?>

<div class="section mt30">
	
	<? include "index/".(Router::getMethod() != "execute" ? Router::getMethod() : "landing_page").".php" ?>
	
</div>
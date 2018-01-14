<?php

/*
 * Destruimos la sesion y redireccinamos la pagina
 * */
session_destroy();
$url = @Ruta::ctrRuta();

echo '
<script>

window.location = "' . $url . '"

</script>

';
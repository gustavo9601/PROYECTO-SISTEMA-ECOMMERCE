<?php

/*
 * Destruimos la sesion y redireccinamos la pagina
 * */
session_destroy();
$url = @Ruta::ctrRuta();

//eliminado del localstorage, la variable usuario
//y todo lo que tenga cargado
echo '
<script>
localStorage.removeItem("usuario");
localStorage.clear();
window.location = "' . $url . '"

</script>

';


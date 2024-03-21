<?php

if ($_POST['g-recaptcha-response'] == '') {
echo "<script>
alert('Ingrese captcha');
window.history.back();
</script>";

} else {
    $obj = new stdClass();
    $obj->secret = "6LedJp4aAAAAAMpAcroRQF_1Ub9FSZMlw_TrhDWt";
    $obj->response = $_POST['g-recaptcha-response'];
    $obj->remoteip = $_SERVER['REMOTE_ADDR'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';

    $options = array(
    'http' => array(
    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
    'method' => 'POST',
    'content' => http_build_query($obj)
    )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    $validar = json_decode($result);

    /* FIN DE CAPTCHA */

    if ($validar->success) {
        $correo = trim($_POST['correo']);
        $nombre = trim($_POST['nombre']);
        $telefono = trim($_POST['telefono']);
        $mensaje = trim($_POST['mensaje']);
        $aceptar = trim($_POST['aceptar']);

        $consulta = "Correo: " . $correo . "\n". " Nombre: " . $nombre . "\n". " Telefono: " . $telefono . "\n". "Mensaje: " . $mensaje. "\n". "Aceptar: " . $aceptar;

        mail("administracion@reingesac.com", "Solicitud desde la Web", $consulta);
        echo "<script>
            alert('Mensaje enviado con éxito');
            window.location= 'contacto.html'
            </script>";
        //include 'index.html';
    } else {

    }
}
?>
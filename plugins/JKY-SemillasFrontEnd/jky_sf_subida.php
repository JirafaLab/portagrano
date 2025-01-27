<?php
	include_once ABSPATH . 'wp-admin/includes/media.php';
	include_once ABSPATH . 'wp-admin/includes/file.php';
	include_once ABSPATH . 'wp-admin/includes/image.php';
	require_once (ABSPATH . 'wp-includes/pluggable.php');

    if(! function_exists ( 'wp_handle_upload'))
        require_once (ABSPATH . 'wp-admin/includes/file.php');
    $uploadedfile = $_FILES [$nombrecampo];
    if (! empty ( $uploadedfile ['name'] ))
    {
        $upload_overrides = array('test_form' => false );
        $movefile = wp_handle_upload ($uploadedfile, $upload_overrides);
        if($movefile)
        {
            echo "El archivo es válido y se ha subido correctamente.\n";
        }
        else
        {
            echo "Posible ataque subiendo un archivo\n";
        }
    }
    else
    {
        echo "Por favor sube una imagen";
    }
?>
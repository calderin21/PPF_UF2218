<?php
// Editar -> Eliminar y luego insertar
// La matrícula no se puede cambiar
$xmlPath = 'files/coches.xml';
$xsdPath = 'files/coches.xsd';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matriculaEliminar = $_POST['matricula'] ?? '';

    $xml = simplexml_load_file($xmlPath);
    if ($xml === false) {
        die("❌ Error al cargar el XML.");
    }

    // Buscar y eliminar el coche
    $index = 0;
    foreach ($xml->coche as $coche) {
        if ((string)$coche['matricula'] === $matriculaEliminar) {
            unset($xml->coche[$index]);
            break;
        }
        $index++;
    }

    // Validar antes de guardar
    $tempPath = 'files/temp_coches.xml';
    $xml->asXML($tempPath);

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->load($tempPath);

    if ($dom->schemaValidate($xsdPath)) {
        if ($xml->asXML($xmlPath)) {
            echo "✅ XML guardado correctamente en $xmlPath";
        } else {
            echo "❌ No se pudo guardar en $xmlPath";
        }

        unlink($tempPath);
        echo "</ul><a href='index.php'>Volver</a>";
        //header("Location: index.php?msg=eliminado");
        //exit;
    } else {
        echo "<p style='color:red'>❌ XML inválido después de eliminar:</p><ul>";
        foreach (libxml_get_errors() as $error) {
            echo "<li>{$error->message}</li>";
        }
        echo "</ul><a href='index.php'>Volver</a>";
        unlink($tempPath);

        if ($xml->asXML($xmlPath)) {
            echo "✅ XML guardado correctamente en $xmlPath";
        } else {
            echo "❌ No se pudo guardar en $xmlPath";
        }

    }

    $nuevoCoche = [
        'matricula' => strtoupper($matriculaEliminar ?? ''),
        'marca'     => $_POST['marca'] ?? '',
        'modelo'    => $_POST['modelo'] ?? '',
        'puertas'   => $_POST['puertas'] ?? '',
        'color'     => $_POST['color'] ?? '',
        'precio'    => $_POST['precio'] ?? '',
        'venta'     => $_POST['venta'] ?? ''
    ];
    echo '<pre>';
    print_r($_POST);
    print_r($nuevoCoche);
    echo '</pre>';

    // Cargar XML existente
    $xml = simplexml_load_file($xmlPath);
    if ($xml === false) {
        die("❌ Error al cargar el XML original.");
    }

    // Insertar nuevo coche
    $coche = $xml->addChild('coche');
    $coche->addAttribute('matricula', $nuevoCoche['matricula']);
    $coche->addChild('marca', $nuevoCoche['marca']);
    $coche->addChild('modelo', $nuevoCoche['modelo']);
    $coche->addChild('puertas', $nuevoCoche['puertas']);
    $coche->addChild('color', $nuevoCoche['color']);
    $precio = $coche->addChild('precio', $nuevoCoche['precio']);
    $precio->addAttribute('venta', $nuevoCoche['venta']);

    // Guardar en archivo temporal
    $tempPath = 'files/temp_coches.xml';
    if (!$xml->asXML($tempPath)) {
        die("❌ Error al guardar archivo temporal '$tempPath'. Verifica permisos.");
    }

    // Verificar que el archivo temporal existe y tiene contenido
    if (!file_exists($tempPath) || filesize($tempPath) === 0) {
        die("❌ Archivo temporal no creado o está vacío.");
    }

    // Validar XML temporal con XSD
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->load($tempPath);

    if ($dom->schemaValidate($xsdPath)) {
        // Guardar XML validado
        $xml->asXML($xmlPath);
        unlink($tempPath);

        echo "✅ Modificado y validado.";

        echo "</ul><a href='index.php'>Volver</a>";
        //header("Location: index.php?msg=modificado");
        //exit;
    } else {
        echo "<p style='color:red'>❌ Error de validación XML:</p><ul>";
        foreach (libxml_get_errors() as $error) {
            echo "<li>Línea {$error->line}: {$error->message}</li>";
        }
        echo "</ul><a href='index.php'>Volver</a>";
        libxml_clear_errors();
        unlink($tempPath);
    }
} else {
    echo "❌ Método no permitido.";
    echo "</ul><a href='index.php'>Volver</a>";
}
?>

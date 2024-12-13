<?php

define('APPID_CEDULA', '755'); 
define('TOKEN_CEDULA', '14713f38dce8aa155a3fc6e60fdd607c');


function getCurlData($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $curlData = curl_exec($curl);
    curl_close($curl);
    return $curlData;
}


if (isset($_GET['cedula'])) {
    $cedula = trim($_GET['cedula']);
    if (!empty($cedula)) {
        $url = "https://api.cedula.com.ve/api/v1?app_id=" . APPID_CEDULA . "&token=" . TOKEN_CEDULA . "&cedula=" . (int)$cedula;
        $apiResponse = getCurlData($url);
        $response = json_decode($apiResponse, true);
        
        if (isset($response['data'])) {
            echo json_encode([
                'error' => false,
                'nombre' => $response['data']['primer_nombre'] ?? '',
                'apellido' => $response['data']['primer_apellido'] ?? ''
            ]);
        } else {
            echo json_encode(['error' => true, 'message' => 'No se encontraron datos']);
        }
    } else {
        echo json_encode(['error' => true, 'message' => 'La cédula es requerida']);
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Cédula</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #004080;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #ffa726;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background-color: #e8f4f8;
            border: 1px solid #d1e4f0;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consulta de Cédula</h1>
        <form method="POST">
            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" id="cedula" name="cedula" placeholder="Ingrese su cédula" required>
            </div>
            <button type="submit">Consultar</button>
        </form>

        <?php if ($response): ?>
            <div class="result">
                <?php if (isset($response['error']) && $response['error']): ?>
                    <p class="error">Error: <?= htmlspecialchars($response['error_str'] ?? 'Desconocido') ?></p>
                <?php elseif (isset($response['data'])): ?>
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($response['data']['primer_nombre'] ?? '') ?> <?= htmlspecialchars($response['data']['primer_apellido'] ?? '') ?></p>
                    <p><strong>Cédula:</strong> <?= htmlspecialchars($cedula) ?></p>
                <?php else: ?>
                    <p class="error">No se encontraron datos para esta cédula.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

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


function getCI($cedula) {
    $url = "https://api.cedula.com.ve/api/v1?app_id=".APPID_CEDULA."&token=".TOKEN_CEDULA."&cedula=".(int)$cedula;
    $response = getCurlData($url);
    return json_decode($response, true);
}


if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];
    if (!empty($cedula) && ctype_digit($cedula)) {
        $data = getCI($cedula);
        if (isset($data['data']) && $data['data']) {
            
            echo json_encode([
                'success' => true,
                'nombres' => $data['data']['nombres'] ?? '',
                'apellidos' => $data['data']['apellidos'] ?? '',
                'carrera' => $data['data']['carrera'] ?? '' 
            ]);
        } else {
            
            echo json_encode([
                'success' => false,
                'message' => $data['error_str'] ?? 'No se encontraron datos para esta cédula.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Cédula inválida.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se proporcionó una cédula.'
    ]);
}

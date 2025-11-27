<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function send_wa($number, $message)
{
    // ===== LOG DEBUG ====================================
    file_put_contents(FCPATH . "wa_debug.txt",
        "KIRIM KE: $number | Pesan: $message\n", FILE_APPEND);
    // =====================================================

    $url = "http://192.168.110.250:3000/send";
    $token = "RAHASIA-123";

    $data = array(
        "number" => $number,
        "message" => $message
    );

    $payload = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "token: " . $token
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $error = curl_error($ch); // <-- ambil error
    curl_close($ch);

    // ===== LOG DEBUG ====================================
    file_put_contents(FCPATH . "wa_debug.txt",
        "HASIL CURL: $result | ERROR: $error\n\n", FILE_APPEND);
    // =====================================================

    return $result;
}

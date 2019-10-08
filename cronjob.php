<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://koindra.com/Cronjob/cek_masa_aktif");
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);

curl_close($ch);
?>
<?php
require_once __DIR__ . '/db.php';
$stmt = $pdo->prepare("SELECT logo FROM institution_settings WHERE id = 1 LIMIT 1");
$stmt->execute();
$logo = $stmt->fetchColumn();

if (!$logo) { http_response_code(404); exit; }

header('Content-Type: ' . (new finfo(FILEINFO_MIME_TYPE))->buffer($logo));
header('Cache-Control: public, max-age=3600');
header('Content-Length: ' . strlen($logo));
echo $logo;
?>
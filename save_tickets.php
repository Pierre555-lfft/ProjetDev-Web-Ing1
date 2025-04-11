<?php
session_start();
$data = json_decode(file_get_contents('php://input'), true);

$_SESSION['tickets'] = [
    'adult' => $data['adult'],
    'child' => $data['child'],
    'senior' => $data['senior']
];
$_SESSION['selected_date'] = $data['date'];
$_SESSION['total'] = $data['total'];

echo json_encode(['success' => true]); 
<?php

function handleErrors($requiredFields, $data) {
    $missingFields = [];

    foreach ($requiredFields as $field) {    
        if (empty($data[$field])) {
            $missingFields[] = "$field is required";  
        }  
    }  

    if (!empty($missingFields)) {
        http_response_code(422);
        echo json_encode([
            'error' => 'Missing required fields',
            'missing_fields' => $missingFields 
        ]);
        exit; 
    }  
}  

?>
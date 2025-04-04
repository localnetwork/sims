<?php
    include '../../connect.php';

    header('Content-Type: application/json');
    header('Accept: application/json'); 
 
 
    switch($_SERVER['REQUEST_METHOD']) {
        case "POST": 
            $data = json_decode(file_get_contents('php://input'), true) ?? $_POST; 
            $requiredFields = ['fname', 'lname', 'age', 'gender', 'password'];
            $missingFields = [];

            foreach ($requiredFields as $field) {    
                if (empty($data[$field])) {
                    $missingFields[] = $field . ' is required';  
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
            $fname = $data['fname'];
            $lname = $data['lname']; 
            $age = $data['age'];
            $gender = $data['gender']; 
            $password = $data['password']; 
            $password_hash = password_hash($password, PASSWORD_BCRYPT); 
            try { 
                $query = "INSERT INTO student_info(fname,lname,age,gender,password) VALUES('$fname','$lname','$age','$gender','$password_hash')";
                $result=mysqli_query($con, $query);
                echo json_encode(['message' => 'Student created successfully']);
            } catch(Exception $e) {
                echo json_encode(['message' => 'Failed to create student. Please try again later.']); 
            }   
            break;    
        case "PUT": 
            $id = $_GET['id'] ?? null; 
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required']);
                exit;
            }
            $data = json_decode(file_get_contents('php://input'), true); 

            $requiredFields = ['fname', 'lname', 'age', 'gender', 'password'];
            
            $missingFields = [];
  
            require_once '../../lib/handlers/errorHandlers.php';
            handleErrors($requiredFields, $data); 
  

            $fname = $data['fname'];  
            $lname = $data['lname']; 
            $age = $data['age'];
            $gender = $data['gender'];
            $password = password_hash($data['password'], PASSWORD_BCRYPT);

            $missingFields = [];   
            try { 
                $query = "UPDATE student_info  
                SET fname = '$fname',   
                    lname = '$lname', 
                    age = '$age',    
                    gender = '$gender', 
                    password = '$password'    
                    WHERE stud_id = '$id'";  
                $result=mysqli_query($con, $query);
                echo json_encode(['message' => 'Student updated successfully.']);  
            } catch(Exception $e) {
                echo json_encode(['message' => 'Failed to create student. Please try again later.']); 
            }  
            break;
        case "GET": 
            $search = $_GET['s'] ?? null;

            if ($search) {
                $search = mysqli_real_escape_string($con, $search);
                $query = "SELECT * FROM student_info WHERE fname LIKE '%$search%' OR lname LIKE '%$search%' ORDER BY stud_id DESC"; 
            } else {
                $query = "SELECT * FROM student_info ORDER BY stud_id DESC";
            }

            $result = mysqli_query($con, $query);

            if ($result) {
                $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
                echo json_encode($students);
            } else {
                echo json_encode(['error' => 'No students found.']);
            }
               
            break;

        case "DELETE": 
            $id = $_GET['id'] ?? null; 
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required']);
                exit;
            } 
            $query = "DELETE FROM student_info WHERE stud_id = '$id'";
            $result = mysqli_query($con, $query); 
            if ($result) {
                echo json_encode(['message' => 'Student deleted successfully.']);
            } else {
                echo json_encode(['error' => 'Failed to delete student.']);
            }
            break; 

        default: 
            echo json_encode(['error' => 'Method not allowed.']);
            exit;
        
    }

?>

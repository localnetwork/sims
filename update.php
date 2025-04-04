<?php
include 'connect.php'; 

// Sanitize and validate the ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "SELECT * FROM student_info WHERE stud_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($res = $result->fetch_assoc()) {
        // Student exists, show form
    } else {
        echo "<h3>Student not found.</h3>";
        exit;
    }
} else {
    echo "<h3>Invalid Student ID.</h3>";
    exit;
} 
// Handle update
if (isset($_POST['update'])) {
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';

    $update = "UPDATE student_info SET fname=?, lname=?, age=?, gender=?, password=? WHERE stud_id=?";
    $stmt = $con->prepare($update);
    $stmt->bind_param($fname, $lname, $age, $gender, $password, $id);
    
    if ($stmt->execute()) { 
        header('Location: index.php');
        exit;
    } else {
        echo "Error updating record.";
    }
}
?>

<html lang="en">
<head>
    
    <title>Update <?php echo htmlspecialchars($res['fname']); ?></title> 
    <?php require_once './components/head.php'; ?>
</head>  
<body> 
<?php require_once './components/layout/header.php'; ?>
    <div class="max-w-[1200px] mx-auto"> 
        <div class="grid bg-white rounded-lg shadow-md border border-[#ddd] overflow-hidden">  
            <div> 
            <form name="update" class="sign-up-form space-y-4 bg-[#7066e0] p-[30px]" method="POST">
            <h1 class="text-2xl font-bold text-[#dbd8ff] mb-3 ">Update <?php echo htmlspecialchars(string: $res['fname']); ?></h1>
            <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($res['stud_id']); ?>"> 
                <div>  
                    <label for="fname" class="block text-sm font-medium text-[#dbd8ff] mb-2">Firstname</label>
                    <input type="text" class="w-full px-4 py-2 border border-[#9f96ff] bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="fname" name="fname" value="<?php echo htmlspecialchars($res['fname']); ?>">
                </div> 
                <div>
                    <label for="lname" class="block text-sm font-medium text-[#dbd8ff] mb-2">Last Name</label>
                    <input type="text" class="w-full px-4 py-2 border border-[#9f96ff] bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="lname" name="lname" value="<?php echo htmlspecialchars($res['lname']); ?>">
                </div>  
                <div> 
                    <label for="age" class="block text-sm font-medium text-[#dbd8ff] mb-2">Age</label>
                    <input type="number" class="w-full px-4 py-2 border border-[#9f96ff] bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="age" name="age" value="<?php echo htmlspecialchars($res['age']); ?>">
                </div>  
                <div>
                    <label for="password" class="block text-sm font-medium text-[#dbd8ff] mb-2">Password</label>
                    <input type="password" class="w-full px-4 py-2 border border-[#9f96ff] bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" name="password" value="<?php echo htmlspecialchars($res['password']); ?>">
                </div> 
                <div>
                    <label class="block text-sm font-medium text-[#dbd8ff] mb-2">Gender</label>
                    <div class="flex items-center space-x-4"> 
                        <label class="flex items-center">
                            <input class="form-radio h-4 w-4 text-blue-600" type="radio" name="gender" id="male" value="2" <?php if ($res['gender'] == 2) echo "checked"; ?>>
                            <span class="ml-2 text-[#dbd8ff] mb-2 select-none cursor-pointer">Male</span>
                        </label>
                        <label class="flex items-center"> 
                            <input class="form-radio h-4 w-4 text-blue-600" type="radio" name="gender" id="female" value="3" <?php if ($res['gender'] == 3) echo "checked"; ?>>
                            <span class="ml-2 text-[#dbd8ff] mb-2 select-none cursor-pointer">Female</span>
                        </label>
                    </div>
                </div> 
                
                <div class="mt-4">
                    <button type="submit" class="select-none cursor-pointer bg-[#3f3a7d] w-full text-[#7066e0] text-[#dbd8ff] mb-2 py-2 px-4 rounded-lg transition duration-300" name="submit">
                        Update account 
                    </button>  
                </div>   
            </form> 
            </div>
        </div>  
    </div>  

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<script>
    const form = document.querySelector('.sign-up-form');  
    form.addEventListener('submit', async (e) => {  
        e.preventDefault();  
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        // form.reset(); 
        try {   
            const response = await axios.put('./api/student/request.php?id=' + data.id, data);
            
            Swal.fire({  
                title: 'Success!',   
                icon: 'success',     
                text: "Student updated successfully."   
            })    
            setTimeout(() => {    
                window.location.href = 'index.php';  
            }, 1000);
        }catch(error) {     
            if(error.status === 422) { 
                const errors = error.response.data.missing_fields;  
                Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    html: errors.map(error => `<p>${error}</p>`).join('') 
                }) 
            }else {
                Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    text: 'Failed to create student. Please try again later.' 
                })
            } 
             
        }    
    }); 

</script>
</body>
</html>
 
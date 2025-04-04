<html lang="en">
<head>
    <?php require_once './components/head.php'; ?>
    <title>Register</title>
</head>  
<body>
<?php require_once './components/layout/header.php'; ?>
    <div class="max-w-[1200px] mx-auto"> 
        <div class="grid grid-cols-2 bg-white rounded-lg shadow-md border border-[#ddd] overflow-hidden">
            <div class="bg-[#fff] p-[15px] flex items-center justify-center relative">
                <div class="absolute top-[15px] left-[15px] text-[12px]">
                    <a href="/" class="text-[#7066E0] underline inline-block">
                        Back to home
                    </a>
                </div>
                <img src="./assets/image.svg" /> 
            </div>  
            <div>
            <form action="api/student/request.php" class="sign-up-form space-y-4 bg-[#7066e0] p-[30px]  " method="POST">
                <h1 class="text-2xl font-bold text-[#dbd8ff] mb-3 ">Sign up</h1>
                <p class="text-[#dbd8ff] text-[12px] mb-5"> 
                    Connect with friends and the world around you.
                </p>
                <div> 
                    <label for="fname" class="block text-sm font-medium text-[#dbd8ff] mb-2">Firstname</label>
                    <input type="text" class="w-full px-4 py-2 border border-[#9f96ff] bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="fname" name="fname">
                </div> 
                <div>
                    <label for="lname" class="block text-sm font-medium text-[#dbd8ff] mb-2">Last Name</label>
                    <input type="text" class="w-full px-4 py-2 border border-[#9f96ff] bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="lname" name="lname">
                </div> 
                <div>  
                    <label for="age" class="block text-sm font-medium text-[#dbd8ff] mb-2">Age</label>
                    <input type="number" class="w-full px-4 py-2 border border-[#9f96ff] bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="age" name="age">
                </div>  
                <div>
                    <label for="password" class="block text-sm font-medium text-[#dbd8ff] mb-2">Password</label>
                    <input type="password" class="w-full px-4 py-2 border border-[#9f96ff] bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="password" name="password">
                </div> 
                <div>
                    <label class="block text-sm font-medium text-[#dbd8ff] mb-2">Gender</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input class="form-radio h-4 w-4 text-blue-600" type="radio" name="gender" id="male" value="2" checked="checked">
                            <span class="ml-2 text-[#dbd8ff] mb-2 select-none cursor-pointer">Male</span>
                        </label>  
                        <label class="flex items-center"> 
                            <input class="form-radio h-4 w-4 text-blue-600" type="radio" name="gender" id="female" value="3">
                            <span class="ml-2 text-[#dbd8ff] mb-2 select-none cursor-pointer">Female</span>
                        </label>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="select-none cursor-pointer bg-[#3f3a7d] w-full text-[#7066e0] text-[#dbd8ff] mb-2 py-2 px-4 rounded-lg transition duration-300" name="submit">
                        Create account 
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
        try {
            const response = await axios.post('api/student/request.php', formData);
            // const data = await response.json();
            console.log('response', response); 
            Swal.fire({  
                title: 'Success!',
                icon: 'success',
                text: "Student created successfully"
            })  
            setTimeout(() => {
                window.location.href = 'index.php'; 
            }, 1000);   

            form.reset();   
        }catch(error) {  
            const errors = error?.response?.data?.missing_fields; 

            if(errors) {
                Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    html: errors.map(error => `<p>${error}</p>`).join('')
                })  
            }else { 
                Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    text: error.response.message || 'Failed to create student. Please try again later.'
                })
            }
        }    
    }); 
</script>
</body>
</html> 

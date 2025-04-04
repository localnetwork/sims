<html lang="en">
<head>
    <?php require_once './components/head.php'; ?>
    <title>Sims</title>
</head> 
<body class="min-h-screen flex flex-col">
    <?php require_once './components/layout/header.php'; ?>
    <div class="max-w-[1200px] w-full mx-auto grow"> 
        <div class="mb-[15px]">
            <input type="text" class="search border border-[#ddd] px-[15px] py-[5px] rounded-[5px]" placeholder="Search" />
        </div>
        <div class="student-list grid grid-cols-3 gap-[15px]">
        </div>
    </div> 


    <?php require_once('./components/layout/footer.php'); ?>

    <script>
    const search = document.querySelector('.search'); 
    const list = document.querySelector('.student-list');
    let timeout = null; // Store the timeout ID 

    const fetchData = async (query = "") => {
        try {
            const res = await axios.get(`/api/student/request.php?s=${query}`);
            
            list.innerHTML = res.data.map(student => `
                <div class="student-item p-4 mb-4 bg-white rounded shadow border">
                    <div class="card-header h-[50px] block w-full bg-[#7066E0]"></div>
                    <h3 class="text-lg font-bold">${student.fname} ${student.lname}</h3>
                    <p class="text-gray-600">ID: ${student.stud_id}</p> 
                    <div class="mt-2">
                        <a href="/update.php?id=${student.stud_id}">Edit</a>
                    </div>   
                </div>
            `).join('');

            if (res.data.length === 0) {
                list.innerHTML = '<p class="text-gray-500">No students found.</p>';
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };

    search.addEventListener('input', () => {
        clearTimeout(timeout); // Clear the previous timeout
        timeout = setTimeout(() => {
            fetchData(search.value);
        }, 500); // Wait 500ms after the last keystroke
    });

    fetchData(); // Initial fetch
</script>

</body>
</html> 
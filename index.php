<html lang="en">
<head>
    <?php require_once './components/head.php'; ?>
    <title>Sims</title>
</head> 
<body class="min-h-screen flex flex-col">
    <?php require_once './components/layout/header.php'; ?>
    <div class="max-w-[1200px] px-[15px] w-full mx-auto grow"> 
        <div class="mb-[15px] flex items-center gap-[5px]">
            <input type="text" class="search border border-[#ddd] px-[15px] py-[5px] rounded-[5px]" placeholder="Search" />
            <span class="is-loading">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-[20px] h-[20px] text-[#7066E0] animate-spin">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </span>
        </div>
        <div class="student-list grid md:grid-cols-2 lg:grid-cols-3 gap-[15px]">
        </div>
    </div> 


    <?php require_once('./components/layout/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <script>
    const search = document.querySelector('.search'); 
    const list = document.querySelector('.student-list');
    let timeout = null;
    const isLoading = document.querySelector('.is-loading');
    const fetchData = async (query = "") => {
        isLoading.classList.add('block'); 
        isLoading.classList.remove('hidden'); 

        try {
            const res = await axios.get(`/api/student/request.php?s=${query}`);

            isLoading.classList.add('hidden');
            isLoading.classList.remove('block');
            
            list.innerHTML = res.data.map(student => `
                <div class="student-item p-4 mb-4 bg-white rounded shadow border border-[#bbb5ff]">
                    <div class="card-header mx-[-16px] mt-[-16px] h-[70px] block w-[calc(100%+32px)] bg-[#7066E0]"></div>
                    <div class="card-info grid grid-cols-3 justify-between mt-[-30px] ">
                        <div class="col-span-2 flex gap-x-[15px]">
                            <div class="bg-white w-[70px] mt-[-8px] h-[70px] rounded-full shadow flex items-center justify-center">
                                ${student.fname.charAt(0).toUpperCase()}${student.lname.charAt(0).toUpperCase()}
                            </div>
                            <h3 class="text-lg text-white font-bold text-overflow line-clamp-1">${student.fname} ${student.lname}</h3>
                        </div>
                        <div class="col-span-1 justify-end flex mt-[-40px] items-center gap-x-[15px]">
                            <a href="/update.php?id=${student.stud_id}"> 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="#fff" class="block w-[20px] h-[20px]">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg> 
                            </a>
                            <div onClick="deleteStudent(${student.stud_id})" class="cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="#fff" class="block w-[20px] h-[20px]">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg> 
                            </div>
                        </div> 
                    </div> 

                    <div class="card-content text-[#7066E0] font-bold grid gap-[5px] grid-cols-3 mt-[15px]">
                        <div>
                            Age: ${student.age}
                        </div>
                        <div>
                            Gender: ${student.gender}
                        </div>
                    </div>
                </div>
            `).join('');

            list.classList.add('grid', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-[15px]');

            if (res.data.length === 0) { 
                list.classList.remove('grid', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-[15px]');
                list.innerHTML = `
                    <div class="flex text-center min-h-[300px] items-center flex-col text-[30px] justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="text-gray-500 w-[150px] h-[150px]">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                        </svg>
                        <p class="text-gray-500">No results found for <span class="text-[#7066E0]">${query}</span>.</p>
                    </div>
                `; 
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

    const deleteStudent = async(id) => {
        Swal.fire({
            title: "Are you sure you want to delete this user?",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#dc3741",
            confirmButtonText: "Yes, delete it.",
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire("Successfully deleted!", "", "success"); 
                axios.delete(`/api/student/request.php?id=${id}`)  
                .then(res => { 
                    console.log('response', res); 
                    fetchData(); // Refresh the data after deletion
                })
            } else if (result.isCancelled) { 
                Swal.fire("Changes are not saved", "", "info");
            } 
        }); 
    }

    fetchData(); // Initial fetch
</script>

</body>
</html> 
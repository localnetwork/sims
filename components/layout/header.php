<header class="header w-full sticky z-[1000] mb-[30px] py-[15px] top-0 bg-[#7066E0]">
    <div class="max-w-[1200px] mx-auto py-2 px-[15px] flex justify-between items-center">
        <div class="logo">
            <a href="../../index.php">
                <img src="../../assets/logo.svg" width="65" height="100" />
            </a>
        </div>
        <div class="text-[#dbd8ff]">
            <ul class="flex gap-x-[15px]">
                <li>
                    <a href="../../index.php">
                        Students
                    </a>
                </li>
                <li>
                    <a class="bg-white text-[#7066E0] py-2 px-5 rounded-[5px]" href="../../register.php">
                        Register
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>


<script>

    const header = document.querySelector('header');
    const sticky = header.offsetTop;

    window.onscroll = function() {
        if (window.pageYOffset > sticky) {
            header.classList.add('sticky-header');
        } else {
            header.classList.remove('sticky-header');
        }
    };

</script>
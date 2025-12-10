document.getElementById("menuToggle").addEventListener("click", function () {
    let sidebar = document.getElementById("sidebar");
    let menuIcon = document.getElementById("menuIcon");

    sidebar.classList.toggle("openSidebar");
    sidebar.classList.toggle("-translate-x-full");

    // Ubah ikon dengan animasi
    if (sidebar.classList.contains("openSidebar")) {
        menuIcon.classList.replace("fa-bars", "fa-times"); // Ubah ikon ke "X"
    } else {
        menuIcon.classList.replace("fa-times", "fa-bars"); // Kembali ke ikon menu
    }

    // Tambahkan efek rotasi pada ikon
    menuIcon.classList.toggle("rotate-icon");
    });

    function clock() {
        return {
            time: '',
            start() {
                this.update();
                setInterval(() => this.update(), 1000);
            },
            update() {
                const now = new Date();

                const tanggal = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                const jam = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });

                this.time = `${tanggal} ${jam}`;
            }
        }
    };
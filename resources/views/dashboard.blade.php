<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard RestoApp</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="icon"
      href="../resources/images/favicon/logo.png"
      type="images/png"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0&icon_names=arrow_outward"
    />
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN (untuk ikon) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  </head>
  <body>
    <div class="header-main-wrapper">
      <nav class="sidebar">
        <div class="sidebar-content">
          <div class="sidebar-title"><h2>WarkopTKP</h2></div>
          <button onclick="sidebar()" class="sidebar-btn">
            <div class="close-icon">
              <div class="line"></div>
            </div>
          </button>
        </div>
        <div class="ul-profile-wrapper">
          <ul id="ul-sidebar" class="list-unstyled">
            <a class="text-white text-decoration-none" href="#profile-section"><li>Home</li></a>
            <a class="text-white text-decoration-none" href="#about-section"><li>About</li></a>
            <a class="text-white text-decoration-none" href="#project-section"><li>Projects</li></a>
            <a class="text-white text-decoration-none" href="#contact-section"><li>Contact</li></a>
            <a class="text-white text-decoration-none" href="blog.html"><li>Blog</li></a>
          </ul>
          
          <!-- BAGIAN PROFIL & DROPDOWN (Menggunakan Dropup Bootstrap) -->
          <div class="dropdown dropup">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle p-2 rounded bg-black bg-opacity-25" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="https://via.placeholder.com/100" alt="avatar" width="36" height="36" class="rounded-circle me-2 object-fit-cover">
              <div class="overflow-hidden">
                <strong class="d-block text-truncate" style="max-width: 150px;">Alex Turner</strong>
                <small class="text-muted d-block text-truncate" style="max-width: 150px;">alex@example.com</small>
              </div>
            </a>
            
            <!-- Menu Dropdown (dropup karena posisinya di bawah sidebar) -->
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow w-100" aria-labelledby="dropdownUser1">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
              <li>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger" id="logoutBtn">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <main>
        <div class="overlay"></div>
        <section class="content">
        <h1>Dashboard RestoApp</h1>
        <p class="lead">
            Selamat datang, {{ Auth::user()->username }}!
        </p>
        
  
        </section>
      </main>
    </div>
    <footer>
      <div class="footer-content">
        <div class="footer-about">
          <h3>Portofolio</h3>
          <p>Email: hibbanyama@gmail.com</p>
        </div>

        <div class="footer-social">
          <h4>Follow</h4>
          <a href="https://www.instagram.com/kagaya.01/">Instagram</a> 
          <a href="https://www.linkedin.com/in/hibban-ahmad-ibrahim-b05634379/"
            >LinkedIn</a
          >
           <a href="https://x.com/hibbanibrahim09">Twitter</a> 
          <a href="https://github.com/kagaya-01">GitHub</a>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 Hibban Ahmad Ibrahim. All Rights Reserved.</p>
      </div>
    </footer>
  </body>
  <!-- Bootstrap 5 JS Bundle CDN (Wajib untuk interaksi dropdown) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const sidebarContainer = document.querySelector(".sidebar");
    const sidebarUl = document.querySelector(".ul-profile-wrapper");
    const sidebarBtn = document.querySelector(".close-icon");
    const line = document.querySelector(".line");
    const overlay = document.querySelector(".overlay");


    let resizeTimer;
    window.addEventListener('resize', () => {
      // Clear the timeout if it's already running
      clearTimeout(resizeTimer);

      //timeout to run the code 200ms after resizing stops
      resizeTimer = setTimeout(() => {
        console.log("Resized to:", window.innerWidth);
        if(window.innerWidth > 768){
          sidebarContainer.style.setProperty('left', '0');
          sidebarUl.style.setProperty('display', 'flex');
          sidebarContainer.style.setProperty('background-color', 'var(--black)');
          overlay.style.setProperty('display', 'none');
        } else {
          isOpened = true
          sidebar()
          
        }
      }, 200);
    });

    // SIDEBAR
    let isOpened = false;
    function sidebar() { 

      if (!isOpened) {
        isOpened = true;
        sidebarUl.style.setProperty('display', 'flex');
        sidebarContainer.style.setProperty('left', '0');
        sidebarContainer.style.setProperty('background-color', 'var(--black)');
        sidebarBtn.style.setProperty("--rotate-before", "rotate(45deg)");
        sidebarBtn.style.setProperty("--rotate-after", "rotate(-45deg)");
        sidebarBtn.style.setProperty("--line-color", "white");
        sidebarBtn.style.setProperty("--bottom", "0");
        sidebarBtn.style.setProperty("--top", "0");
        line.style.setProperty("opacity", "0");
        overlay.style.setProperty('background-color', 'rgba(0, 0, 0, 0.328')
        overlay.style.setProperty('display', 'block');
      }

      else if(isOpened) { 
        isOpened = false;
        sidebarContainer.style.setProperty('left', '-10rem');
        sidebarContainer.style.setProperty('background-color', 'rgba(0, 0, 0, 0)');
        sidebarBtn.style.setProperty("--rotate-before", "rotate(0deg)");
        sidebarBtn.style.setProperty("--rotate-after", "rotate(0deg)");
        sidebarBtn.style.setProperty("--line-color", "black");
        sidebarBtn.style.setProperty("--bottom", "1rem");
        sidebarBtn.style.setProperty("--top", "1rem");
        line.style.setProperty("opacity", "1");
        overlay.style.setProperty('background-color', 'rgba(0, 0, 0, 0)');
        setTimeout(() => {
          sidebarUl.style.setProperty('display', 'none');
          overlay.style.setProperty('display', 'none');
        }, 100);
        
      }
    }


    // Logic


    document.getElementById('logoutForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const button = document.getElementById('logoutBtn');
      button.disabled = true;
      button.innerText = 'Logging out...';

      this.submit();
    });
  </script>
  <script src="../pages/index/script/script.js"></script>
  <script
    src="https://kit.fontawesome.com/f65a8d8213.js"
    crossorigin="anonymous"
  ></script>
</html>

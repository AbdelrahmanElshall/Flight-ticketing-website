<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand text-primary" href="#">
                <i class="fa-solid fa-plane"></i>
                <span>TIRF.com</span>
            </a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav w-100 justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link <?= MyAdmin::getActive("home") ?>" href="home">
                            <i class="fa-solid fa-house"></i> Home</a>
                    </li>
                    <li class=" my-2 my-lg-0 mx-0 mx-lg-2 border"></li>
                    <li class="nav-item">
                        <a class="nav-link <?= MyAdmin::getActive("countries") ?>" href="countries">
                            <i class="fa-solid fa-flag"></i> Countries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= MyAdmin::getActive("cities") ?>" href="cities">
                            <i class="fa-solid fa-city"></i> Cities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create">
                        <i class="fa-solid fa-plus"></i></i> Add Flight</a>
                    </li>
                    <li class=" my-2 my-lg-0 mx-0 mx-lg-2 border"></li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
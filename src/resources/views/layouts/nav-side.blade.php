<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">CORE</div>
            <a class="nav-link {{Request::is('/') ? 'active' : ''}}" href="{{url('/')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                HOME
            </a>
            <div class="sb-sidenav-menu-heading">PAGE</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                ADD
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{Request::is('/add/data') ? 'active' : ''}}" href="{{route('data.index')}}">Data</a>
                </nav>
            </div>
            <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                EDIT
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="">Data</a>
                    <a class="nav-link" href="">Field</a>
                    <a class="nav-link" href="">Mail</a>
                    <a class="nav-link" href="">Query</a>
                    <a class="nav-link" href="">CID Data</a>
                    <a class="nav-link" href="">JWF Other Details</a>
                    <a class="nav-link" href="">CID PDF POS</a>
                    <a class="nav-link" href="">Remove Records</a>
                </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePagesView" aria-expanded="false" aria-controls="collapsePagesView">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                View
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePagesView" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="#">Transmittal</a>
                    <a class="nav-link" href="#">Project</a>
                    <a class="nav-link" href="#">Issue Count</a>
                    <a class="nav-link" href="#">Mail List</a>
                    <a class="nav-link" href="#">Evaluation</a>
                    <a class="nav-link" href="#">JWF Need Replacement</a>
                </nav>
            </div> -->
            <a class="nav-link {{Request::is('search') ? 'active' : ''}}" href="{{route('search.index')}}" aria-expanded="false">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                SEARCH
            </a>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsAddons" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                ADDONS
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayoutsAddons" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{Request::is('/upload/template') ? 'active' : ''}}" href="{{route('addons.index')}}">UPLOAD TEMPLATE</a>
                </nav>
            </div>

            <div class="sb-sidenav-menu-heading">User Management</div>
            <a class="nav-link {{Request::is('user') ? 'active' : ''}}" href="{{route('user.index')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                User List
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ Auth::user()->name  }}
    </div>
</nav>
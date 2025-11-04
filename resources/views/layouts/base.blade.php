<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>My Home Dobi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/brand.png') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />

    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">



</head>

<!--
    theme light for customer #fff
    theme dark for staff #73C0BF
    theme default for admin #9BCADD
-->

@if (auth()->user()->role === 'Admin')

    <body class="loading"
        data-layout-config='{"leftSideBarTheme":"default","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false, "showRightSidebarOnStart": true}'>
    @elseif(auth()->user()->role === 'Staff')

        <body class="loading"
            data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false, "showRightSidebarOnStart": true}'>
        @else

            <body class="loading"
                data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false, "showRightSidebarOnStart": true}'>
@endif
<!-- Begin page -->
<div class="wrapper">
    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu logo-light">

        <!-- LOGO -->
        <a href="" class="logo text-center">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="85">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('assets/images/brand.png') }}" alt="" height="40">
            </span>
        </a>

        <div class="h-100" id="left-side-menu-container" data-simplebar>

            <!--- Sidemenu -->
            <ul class="metismenu side-nav mt-3">
                <div class="side-nav-link">
                    <a href="javascript: void(0);">
                        <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" height="35"
                            class="rounded-circle shadow-sm">
                        <div class="user-avatar">
                            <span class="leftbar-user-name text-dark fw-bold">{{ auth()->user()->name }}</span>
                            <p class="text-dark font-12 mb-0">{{ auth()->user()->role }}</p>
                        </div>
                    </a>
                </div>
                <li class="side-nav-title side-nav-item text-dark">Menu</li>
                <!-- Dashboard Link -->
                <li class="side-nav-item">
                    <a href="{{ route('dashboard') }}" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <!-- Profile Information (Staff Only) -->
                @if (auth()->user()->role === 'Staff')
                    <li class="side-nav-item">
                        <a href="{{ route('profile') }}" class="side-nav-link">
                            <i class="uil-user"></i>
                            <span>Profile Information</span>
                        </a>
                    </li>
                @endif

                <!-- Profile Information (Admin and Customer) -->
                @if (auth()->user()->role === 'Admin' || auth()->user()->role === 'Customer')
                    <li class="side-nav-item">
                        <a href="#" class="side-nav-link">
                            <i class="uil-user"></i>
                            <span> Profile Information </span>
                        </a>
                    </li>
                @endif

                <!-- Schedule (Admin and Staff) -->
                @if (auth()->user()->role === 'Admin' || auth()->user()->role === 'Staff')
                    <li class="side-nav-item" id="schedule-sidebar-link">
                        <a href="{{ route('schedule.index') }}" class="side-nav-link">
                            <i class="uil-calendar-alt"></i>
                            <span> Schedule </span>
                        </a>
                    </li>
                @endif

                <!-- Staff Management (Admin Only) -->
                @if (auth()->user()->role === 'Admin')
                    <li class="side-nav-item" id="staff-management-sidebar-link">
                        <a href="{{ route('staff.index') }}" class="side-nav-link">
                            <i class="uil-user-plus"></i>
                            <span> Staff Management </span>
                        </a>
                    </li>
                @endif

                <!-- Inventory & Stock (Admin or Manager) -->
                @if (auth()->user()->role === 'Admin' || (auth()->user()->staff && auth()->user()->staff->role === 'Manager'))
                    <li class="side-nav-item">
                        <a href="{{ route('inventory.index') }}" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span>Inventory & Stock</span>
                        </a>
                    </li>
                @endif

                <!-- Laundry Type & Service (Manager Only) -->
                @if (auth()->user()->role === 'Staff' && auth()->user()->staff->role === 'Manager')
                    <li class="side-nav-item">
                        <a href="{{ route('laundry.index') }}" class="side-nav-link">
                            <i class="uil-cog"></i>
                            <span>Laundry Type & Service </span>
                        </a>
                    </li>
                @endif

                <!-- Order List (Admin, Customer, or Staff with specific roles) -->
                @if (auth()->user()->role === 'Customer' ||
                        (auth()->user()->staff &&
                            (auth()->user()->staff->role === 'Manager' ||
                                auth()->user()->staff->role === 'Dry Cleaner' ||
                                auth()->user()->staff->role === 'Washer/Folder' ||
                                auth()->user()->staff->role === 'Presser/Ironing' ||
                                auth()->user()->staff->role === 'Dryer')))
                    <li class="side-nav-item">
                        <a href="{{ route('order.index') }}" class="side-nav-link">
                            <i class="uil-shopping-cart-alt"></i>
                            <span>Order List </span>
                        </a>
                    </li>
                @endif

                <!-- Pickup & Delivery (Staff or Manager) -->
                @if (
                    (auth()->user()->role === 'Staff' &&
                        (auth()->user()->staff->role === 'Pickup & Delivery Driver' || auth()->user()->staff->role === 'Manager')))
                    <li class="side-nav-item">
                        <a href="{{ route('delivery.index') }}" class="side-nav-link">
                            <i class="uil-truck"></i>
                            <span> Pickup & Delivery </span>
                        </a>
                    </li>
                @endif

                <!-- Billing and Payment (Admin or Manager) -->
                @if (auth()->user()->role === 'Admin' || (auth()->user()->staff && auth()->user()->staff->role === 'Manager'))
                    <li class="side-nav-item">
                        <a href="{{ route('billing-payment.index') }}" class="side-nav-link">
                            <i class="uil-wallet"></i>
                            <span>Billing and Payment</span>
                        </a>
                    </li>
                @endif

            </ul>




            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            @if (auth()->user()->role === 'Admin')
                <div class="navbar-custom" style="background-color:#9BCADD">
                @elseif(auth()->user()->role === 'Staff')
                    <div class="navbar-custom" style="background-color:#73C0BF">
                    @else
                        <div class="navbar-custom">
            @endif
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <!-- Mobile Menu Button -->
                <button class="button-menu-mobile open-left disable-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

                <!-- Logout Icon -->
                <div class="top d-flex align-items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                            <i class="mdi mdi-logout text-dark" style="font-size: 1.4rem;"></i>
                        </x-dropdown-link>
                    </form>
                </div>

            </div>
        </div>
        <!-- End Topbar -->

        <!-- Start Content-->
        <div class="container-fluid">

            @if (session()->has('success'))
                <br>
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if ($errors->any())
                <br>
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </div> <!-- container -->
    </div> <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    MyHome Dobi ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- bundle -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<!-- third party js -->
<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/fullcalendar.min.js') }}"></script>

<!-- third party js ends -->

<!-- demo app -->
<script src="{{ asset('assets/js/pages/demo.customers.js') }}"></script>
<script src="{{ asset('assets/js/pages/demo.calendar.js') }}"></script>
<!-- end demo js-->

<!-- Datatables js -->
<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable Init js -->
<script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>

<!-- Add the following JavaScript to auto-dismiss the alert after 3 seconds -->
<script>
    setTimeout(function() {
        $('.alert').alert('close');
    }, 3000); // 3000 milliseconds = 3 seconds
</script>

</body>

</html>

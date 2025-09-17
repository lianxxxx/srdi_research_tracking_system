<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DMMMSU-SRDI</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />

    <!-- Additional CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="icon" href="../assets/images/logo.png" type="image/x-icon">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css" />
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <!-- End Test -->
    <link rel="icon" href="../assets/images/logo.png" type="image/x-icon">

    <!-- Icon Boxicon -->
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Charts CSS -->
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">



    <!-- Datatable -->
    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- Charts js -->
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>


    <!-- Custom CSS -->
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Additional JS -->
    <script src="../assets/js/jquery-3.5.1.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>

    <style>
        /* Base styles for the sidebar */
        .left-sidebar {
            width: 250px;
            height: 100%;
            /*background: #333;*/
            color: #fff;
            position: fixed;
            top: 0;
            left: -250px;
            /* Hidden by default */
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .left-sidebar.active {
            left: 0;
            /* Show when active */
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /*background: rgba(0, 0, 0, 0.5);*/
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }



        /* Media Queries for larger screen views (laptops/desktops) */
        @media (min-width: 992px) {
            .left-sidebar {
                left: 0;
                /* Sidebar is always visible on larger screens */
            }

            /* Remove the overlay for larger screens */
            .sidebar-overlay {
                display: none;
            }
        }

        /* Mobile view (for smaller screens) */
        @media (max-width: 991px) {
            .left-sidebar {
                left: -250px;
                /* Sidebar hidden by default on mobile */
            }

            .sidebar-overlay.active {
                display: block;
                /* Overlay will show when sidebar is active */
            }
        }
    </style>

    <!--end styles-->
</head>

<body>
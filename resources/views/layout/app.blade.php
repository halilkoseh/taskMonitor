<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task Monitor</title>

    {{-- Favicon (ilk kodunuzda "images/favLogo.png" kullanıyordu) --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favLogo.png') }}" />

    {{-- TailwindCSS (çeşitli sürümler var; hepsini ekledik) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

    {{-- Font Awesome (farklı sürümler / linkler, hepsini ekledik) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-3NDgm8En5yDN9qF8x6cSwpKXoJd/U1kK6Ma4McYAcj3PP5U5cF8NyM4NlbKQ3n8U9sGFAZR/w/lD1fxT8J2N2w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    {{-- style.css (eğer local dosyanızsa) --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    {{-- FullCalendar (ilk kodlarınızda geçiyordu) --}}
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.10.1/main.min.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.10.1/main.min.css' rel='stylesheet' />

    {{-- Google Fonts: Quicksand (ilk kodunuzda family=Quicksand vardı) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    {{-- Choices.js (ilk kodlarınızda vardı) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    {{-- jQuery, Chart.js, Datalabels vs. (ilk kodlarınızda geçiyordu) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    {{-- Örnek body stili ve .card hover vs. --}}
    <style>
        body {
            font-family: 'Quicksand', monospace;
            /* Sizin önceki kodlarınızda 'bg-black flex flex-col' vardı,
               ama burada min-h-screen + flex yapısını body'de tutabiliriz */
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }




        /* Hamburger Menü Stili */
        .hamburger-menu {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            cursor: pointer;
            padding: 10px;
        }

        /* Yalnızca büyük ekranlarda gizlenmeli */
        @media (min-width: 768px) {
            .hamburger-menu {
                display: none;
            }
        }

        /* Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }

        /* Sidebar öğeleri */
        .sidebar-item {
            display: block;
            padding: 10px;
            transition: all 0.3s;
        }

        .sidebar-item:hover {
            background-color: #e0f2fe;
            color: #075985;
        }













        @media (min-width: 769px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 18rem;
                background-color: white;
                padding: 1.25rem;
                color: #4b5563;
                transform: translateX(0);
                transition: transform 0.3s;
                z-index: 50;
            }
        }


        /* Mobilde tam ekran kaplasın diye */




        /* Sidebar (navbar) ile ilgili extra stilleri de ekleyebilirsiniz */
    </style>
</head>

<body class="bg-[#EFEFEF] flex flex-row">
    <!-- Hamburger Menu (Mobilde göster) -->
    <div class="hamburger-menu lg:hidden">
        <i class="fas fa-bars"></i>
    </div>

    @include('components.navbar')

    <div class="flex-1 lg:pl-72">
        @yield('content')
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        [x-cloak] { display: none; opacity: 0; }
    </style>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @livewireStyles
    <title>
        ENS Admin
    </title>
</head>
<body>

    <!--Plan de travail-->

    <div class="my_work">

        <!--Navigation-->

        <div class="sidebar active">
            <div class="logo_content">
                <div class="logo">
                    <img src="images/ens.png" alt="">
                    <div class="logo_name">
                        ENS Admin
                    </div>
                </div>
                <img src="images/menu-fill.svg" alt="" id="btn">
            </div>
            <ul class="nav_list">
                <li>
                    <a href="{{ route('etudiant') }}" class="@if($_SERVER['REQUEST_URI'] === '/') active_link @endif">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M17.5 19h1v-2.5H21v-1h-2.5V13h-1v2.5H15v1h2.5Zm.5 2q-2.075 0-3.537-1.462Q13 18.075 13 16q0-2.075 1.463-3.538Q15.925 11 18 11t3.538 1.462Q23 13.925 23 16q0 2.075-1.462 3.538Q20.075 21 18 21ZM4 19V7l8-6l8 6v2.3q-.475-.15-.975-.225Q18.525 9 18 9V8l-6-4.5L6 8v9h5.075q.075.525.225 1.025q.15.5.375.975Zm8-8.75Z"/></svg></span>
                        <span class="links_name">Accueil</span>
                    </a>
                    <span class="tooltype">Accueil</span>
                </li>
                <li>
                    <a href="{{ route('inscription') }}" class="@if(request()->routeIs('inscription')) active_link @endif">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15 4a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4m0 1.9a2.1 2.1 0 1 1 0 4.2A2.1 2.1 0 0 1 12.9 8A2.1 2.1 0 0 1 15 5.9M4 7v3H1v2h3v3h2v-3h3v-2H6V7H4m11 6c-2.67 0-8 1.33-8 4v3h16v-3c0-2.67-5.33-4-8-4m0 1.9c2.97 0 6.1 1.46 6.1 2.1v1.1H8.9V17c0-.64 3.1-2.1 6.1-2.1Z"/></svg></span>
                        <span class="links_name">Inscription</span>
                    </a>
                    <span class="tooltype">Inscription</span>
                </li>
                <li>
                    <a href="{{ route('pres') }}" class="@if($_SERVER['REQUEST_URI'] === '/preselection') active_link @endif">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 48 48"><mask id="ipSFullSelection0"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M34 5H8a3 3 0 0 0-3 3v26a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3Z"/><path stroke="#fff" stroke-linecap="round" d="M44 13.002V42a2 2 0 0 1-2 2H13.003"/><path stroke="#000" stroke-linecap="round" d="m13 20.486l6 5.525l10-10.292"/></g></mask><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSFullSelection0)"/></svg></span>
                        <span class="links_name">Préinscription</span>
                    </a>
                    <span class="tooltype">Préinscription</span>
                </li>
                <li>
                    <a href="{{ route('dossier') }}" class="@if($_SERVER['REQUEST_URI'] === '/dossier') active_link @endif">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="m17.435 19.723l-2.37-2.37q-.14-.133-.14-.34t.14-.348q.14-.14.335-.15q.194-.01.335.131l1.765 1.766v-4.387q0-.213.144-.356q.144-.144.357-.144t.356.144q.143.143.143.356v4.387l1.765-1.766q.134-.14.341-.14q.207 0 .348.14t.14.348q0 .207-.14.34l-2.389 2.39q-.242.241-.565.241q-.323 0-.565-.242M15 23.5q-.213 0-.356-.144T14.5 23q0-.212.144-.356q.144-.143.356-.143h6q.213 0 .356.144T21.5 23q0 .212-.144.356q-.143.143-.356.143zm-8.885-4q-.652 0-1.133-.482q-.482-.481-.482-1.133V4.115q0-.652.482-1.133q.481-.482 1.133-.482h6.214q.331 0 .632.13q.3.132.518.349L18.02 7.52q.217.217.348.518q.131.3.131.632v1.662q0 .343-.232.575q-.232.232-.576.232H13.73q-.667 0-1.141.475q-.475.474-.475 1.14v5.937q0 .344-.232.576q-.232.232-.575.232zm7.597-11H17.5l-5-5l5 5l-5-5v3.788q0 .505.353.859q.354.353.859.353"/></svg></span>
                        <span class="links_name">Dossier Reçu</span>
                    </a>
                    <span class="tooltype">Dossier Reçu</span>
                </li>
                <li>
                    <a href="{{ route('note') }}" class="@if($_SERVER['REQUEST_URI'] === '/note') active_link @endif">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M23 18v2h-8v-2h8m-10 1c0 .7.13 1.37.35 2H5a2 2 0 0 1-2-2V5c0-1.11.89-2 2-2h10l6 6v4.35c-.63-.22-1.3-.35-2-.35v-1h-7V5H5v14h8m1-9h5.5L14 4.5V10Z"/></svg></span>
                        <span class="links_name">Note</span>
                    </a>
                    <span class="tooltype">Note</span>
                </li>
                <li>
                    <a href="{{ route('certificate') }}" class="@if($_SERVER['REQUEST_URI'] === '/certificate') active_link @endif">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M11.25 1.75h-8.5v11.5h2.5m3.5-3.5l-.5 4.5l2.25-1l2.25 1l-.5-4.5"/><circle cx="10.5" cy="7.5" r="2.75"/></g></svg></span>
                        <span class="links_name">Certificats</span>
                    </a>
                    <span class="tooltype">Certificats</span>
                </li>
                <li>
                    <a href="{{ route('exporter') }}" class="@if($_SERVER['REQUEST_URI'] === '/export') active_link @endif">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M8.71 7.71L11 5.41V15a1 1 0 0 0 2 0V5.41l2.29 2.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42l-4-4a1 1 0 0 0-.33-.21a1 1 0 0 0-.76 0a1 1 0 0 0-.33.21l-4 4a1 1 0 1 0 1.42 1.42ZM21 14a1 1 0 0 0-1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-4a1 1 0 0 0-1-1Z"/></svg></span>
                        <span class="links_name">Exporter</span>
                    </a>
                    <span class="tooltype">Exporter</span>
                </li>
            </ul>
            <div class="profile_content">
                <div class="profile">
                    <div class="profile_details">
                        <a href="{{ route('user.profile') }}">
                            @if(Auth::user()->images != 'default.jpg')
                                <img src="/storage/{{ Auth::user()->images }}" alt="profile images">
                            @else
                                <img src="/images/{{ Auth::user()->images }}" alt="profile">
                            @endif
                        </a>
                        <div class="name_last w-1/2">
{{--                            <div class="name">{{ Auth::user()->name }}</div>--}}
                            <div class="last">{{ Auth::user()->prenom }}</div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <img src="images/logout.svg" id="log_out">
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="home_content">
            <div class="w-full">
                <div class="w-full h-full">
                    @yield('content')
                </div>
                <livewire:modal.flash/>
                <livewire:modal.modal-excel/>
                <livewire:modal.modal/>
                <livewire:modal.process/>
            </div>
        </div>
    </div>

        <script>
            let btn = document.querySelector('#btn')
            let sidebar = document.querySelector('.sidebar')

            btn.onclick = function(){
                sidebar.classList.toggle("active")
            }
        </script>


    <!--End Plan de travail-->
@livewireScripts

</body>
</html>


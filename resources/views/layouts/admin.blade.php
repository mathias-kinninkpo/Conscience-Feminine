<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/logo.png') }}" />
  @yield('styles')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Dashboard Admin - ONG Conscience Féminine - @yield('title')</title>
</head>
<body class="bg-gray-100">
  <!-- Sidebar mobile -->
  <div id="mobile-sidebar" class="fixed inset-0 z-40 flex md:hidden">
    <div class="fixed inset-0 bg-black opacity-50" onclick="toggleSidebar()"></div>
    <aside class="relative bg-white w-64 p-4">
      <div class="mb-8">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
          <img src="{{ asset('storage/images/logo.png') }}" class="h-10" alt="Logo">
          <span class="text-xl font-bold">Conscience Féminine</span>
        </a>
      </div>
      <nav>
        <ul class="space-y-2">
          <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Dashboard</a></li>
          <li><a href="{{ route('admin.announcements.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Annonces</a></li>
          <li><a href="{{ route('admin.activities.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Activités</a></li>
          <li><a href="{{ route('admin.pages.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Pages</a></li>
          <li><a href="{{ route('admin.contacts.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Contacts</a></li>
          <li><a href="{{ route('admin.sliders.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Sliders</a></li>
          <li><a href="{{ route('admin.team.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Équipe</a></li>
          <li><a href="{{ route('admin.faqs.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">FAQ</a></li>
          <li><a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Utilisateurs</a></li>
          <li><a href="{{ route('admin.settings') }}" class="block px-4 py-2 rounded hover:bg-gray-200">Paramètres</a></li>
        </ul>
      </nav>
    </aside>
  </div>

  <!-- Layout principal -->
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar statique pour desktop -->
    <aside class="hidden md:flex md:flex-shrink-0">
      <div class="flex flex-col w-64 bg-white border-r border-gray-200">
        <div class="flex items-center h-16 px-4">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
            <img src="{{ asset('storage/images/logo.png') }}" class="h-10" alt="Logo">
            <span class="text-xl font-bold">Conscience Féminine</span>
          </a>
        </div>
        <nav class="flex-1 overflow-y-auto">
          <ul class="py-4 space-y-1">
            <li>
              <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Dashboard -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/>
                </svg>
                <span class="ml-3">Dashboard</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.announcements.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Annonces -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M9 12h6m-6 4h6m-3-8h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">Annonces</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.activities.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Activités -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">Activités</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.pages.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Pages -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M4 4h16v16H4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">Pages</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Contacts -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M16 12a4 4 0 1 0-8 0 4 4 0 0 0 8 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                  <path d="M12 14v7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">Contacts</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.sliders.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Sliders -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">Sliders</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.team.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Équipe -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M17 20h5v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2h5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                  <circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">Équipe</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.faqs.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône FAQ -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M8 9h8M9 15h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                  <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">FAQ</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Utilisateurs -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M17 20h5v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2h5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                  <circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">Utilisateurs</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <!-- Icône Paramètres -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M12 8v4l3 3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                  <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <span class="ml-3">Paramètres</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Zone de contenu -->
    <div class="flex flex-col flex-1 overflow-hidden">
      <!-- Header -->
      <header class="flex items-center justify-between bg-white shadow px-4 py-3">
        <div class="flex items-center">
          <button class="md:hidden text-gray-500 focus:outline-none" onclick="toggleSidebar()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-2xl font-semibold ml-4">@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="flex items-center">
          <img src="{{ asset('storage/images/avatar.png') }}" alt="Admin Avatar" class="w-10 h-10 rounded-full">
          <span class="ml-2 text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
          <a href="{{ route('logout') }}" class="ml-4 text-red-500 hover:underline">Déconnexion</a>
        </div>
      </header>

      <!-- Contenu principal -->
      <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
      </main>

      <!-- Footer -->
      <footer class="bg-white border-t border-gray-200 p-4">
        <div class="text-center text-gray-600 text-sm">
          © {{ date('Y') }} ONG Conscience Féminine. Tous droits réservés.
        </div>
      </footer>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const mobileSidebar = document.getElementById('mobile-sidebar');
      mobileSidebar.classList.toggle('hidden');
    }
  </script>

  @yield('scripts')
</body>
</html>
<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'My App')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        .submenu-transition {
            transition: max-height 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
=======
<aside class=" bg-white border-r border-gray-200 flex flex-col justify-between " style="width: 25%;">
  <div>
    <div class=" h-100; flex items-center " style="padding: 0px 40px 0px 5px;">
      <div class="w-100 h-auto rounded overflow-hidden">
        <img
          src="assets/logo.png"
          alt="CollabNest Logo"
          class="w-full h-full object-contain"
        />
      </div>
      <a class="text-indigo-700 font-semibold text-lg" href="#">CollabNest</a>
    </div>
    <div class="px-6 mb-6">
      <a href="/profile/{{Auth::user()->id}}">
        <div class="flex items-center space-x-4 bg-gray-100 rounded-lg py-3 px-4">
          @php
            $profile = App\Models\UserProfile::where('user_id',Auth::user()->id)->first();
            $userProfile = json_decode($profile->profile_settings,true);
            $image = $userProfile['image'] ?? [];
          @endphp
          <img alt="Profile" class="rounded-full w-10 h-10 object-cover" src="{{ $image ? asset('storage/'. $image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF'}}" />
          <div>
            <p class="font-semibold text-gray-900 text-sm leading-tight">{{ isset($userProfile['first_name']) ? $userProfile['first_name'].' '.$userProfile['last_name'] : Auth::user()->name}}</p>
            <p class="text-gray-500 text-xs leading-tight">{{ Auth::user()->email }}</p>
          </div>
        </div>
      </a>
    </div>
    <nav class="flex flex-col space-y-2 px-6 text-sm font-semibold">
>>>>>>> b50ca53684946671a86160ff5a873913343ed07a

    <!-- Sidebar Container -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-full shadow-sm">
            <!-- Brand Logo & Name -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <img src="assets/logo.png" alt="CollabNest Logo" class="h-8 w-auto object-contain" />
                    <span class="text-indigo-600 font-bold text-xl">CollabNest</span>
                </div>
            </div>

<<<<<<< HEAD
            <!-- User Profile -->
            <div class="px-6 py-4">
                <a href="/profile" class="group">
                    <div class="flex items-center space-x-3 group-hover:bg-gray-50 rounded-lg p-2 transition-colors">
                        @php
                            $profile = App\Models\UserProfile::where('user_id',Auth::user()->id)->first();
                            $image = json_decode($profile->profile_settings,true)['image'] ?? [];
                        @endphp
                        <img 
                            alt="Profile" 
                            class="rounded-full w-10 h-10 object-cover border-2 border-white shadow-sm" 
                            src="{{ $image ? asset('storage/'. $image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF'}}" 
                        />
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 text-sm truncate">{{ Auth::user()->name }}</p>
                            <p class="text-gray-500 text-xs truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </div>
                </a>
            </div>
=======
  <a href="{{ route('navUsers') }}"
     class="flex items-center space-x-2 py-2 px-3 rounded-md 
            {{ request()->routeIs('navUsers') ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100 text-gray-900' }}">
    <i class="fas fa-users"></i><span>Users</span>
  </a>
>>>>>>> b50ca53684946671a86160ff5a873913343ed07a

            <!-- Navigation Menu -->
            <nav class="flex-1 overflow-y-auto px-3 py-2">
                <ul class="space-y-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center space-x-3 py-2 px-3 rounded-lg sidebar-transition
                                  {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-home text-gray-500 w-5 text-center"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>

                    <!-- Projects (Collapsible) -->
                    <li>
                        <div class="group">
                            <button id="project-toggle"
                                    class="w-full flex items-center justify-between space-x-3 py-2 px-3 rounded-lg sidebar-transition
                                           {{ request()->routeIs('projects*') || request()->routeIs('navMyProject') || request()->routeIs('viewProject') || request()->routeIs('editProject') || request()->routeIs('navCreateProject') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-box text-gray-500 w-5 text-center"></i>
                                    <span class="font-medium">Projects</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-400 transform sidebar-transition 
                                      {{ request()->routeIs('projects*') || request()->routeIs('navMyProject') || request()->routeIs('viewProject') || request()->routeIs('editProject') || request()->routeIs('navCreateProject') ? 'rotate-180' : '' }}"></i>
                            </button>
                            
                            <div id="project-menu" 
                                 class="submenu-transition overflow-hidden 
                                        {{ request()->routeIs('projects*') || request()->routeIs('navMyProject') || request()->routeIs('viewProject') || request()->routeIs('editProject') || request()->routeIs('navCreateProject') ? 'max-h-40' : 'max-h-0' }}">
                                <ul class="pl-8 pt-1 space-y-1">
                                    <li>
                                        <a href="{{route('projects')}}"
                                           class="flex items-center space-x-3 py-2 px-3 rounded-lg sidebar-transition
                                                  {{ request()->routeIs('projects') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                            <span class="w-5 text-center">•</span>
                                            <span>All Projects</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('navMyProject') }}"
                                           class="flex items-center space-x-3 py-2 px-3 rounded-lg sidebar-transition
                                                  {{ request()->routeIs('navMyProject') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                            <span class="w-5 text-center">•</span>
                                            <span>My Projects</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- Messages -->
                    <li>
                        <a href="{{ route('messages') }}"
                           class="flex items-center space-x-3 py-2 px-3 rounded-lg sidebar-transition
                                  {{ request()->routeIs('messages') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="far fa-comment text-gray-500 w-5 text-center"></i>
                            <span class="font-medium">Messages</span>
                            <span class="ml-auto bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-0.5 rounded-full">3</span>
                        </a>
                    </li>

                    <!-- Meetings -->
                    <li>
                        <a href="{{ route('meetings') }}"
                           class="flex items-center space-x-3 py-2 px-3 rounded-lg sidebar-transition
                                  {{ request()->routeIs('meetings') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-video text-gray-500 w-5 text-center"></i>
                            <span class="font-medium">Meetings</span>
                        </a>
                    </li>

                    <!-- Settings -->
                    <li>
                        <a href="{{ route('settings') }}"
                           class="flex items-center space-x-3 py-2 px-3 rounded-lg sidebar-transition
                                  {{ request()->routeIs('settings') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-cog text-gray-500 w-5 text-center"></i>
                            <span class="font-medium">Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Logout Button -->
            <div class="px-6 py-4 border-t border-gray-200">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-center space-x-2 bg-red-600 border border-white-100 text-white hover:bg-red-50 font-medium py-2 px-4 rounded-lg transition-colors duration-200 shadow-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 ml-64 p-6">
     
        </main>
    </div>

    <script>
        // Toggle project submenu
        const projectToggle = document.getElementById('project-toggle');
        const projectMenu = document.getElementById('project-menu');
        
        projectToggle.addEventListener('click', () => {
            const isExpanded = projectMenu.style.maxHeight !== '0px' && projectMenu.style.maxHeight !== '';
            
            if (isExpanded) {
                projectMenu.style.maxHeight = '0';
                projectToggle.querySelector('.fa-chevron-down').classList.remove('rotate-180');
            } else {
                projectMenu.style.maxHeight = projectMenu.scrollHeight + 'px';
                projectToggle.querySelector('.fa-chevron-down').classList.add('rotate-180');
            }
        });

        // Initialize submenu state if needed
        document.addEventListener('DOMContentLoaded', () => {
            if (window.location.pathname.includes('/projects') || 
                window.location.pathname.includes('/my-projects')) {
                projectMenu.style.maxHeight = projectMenu.scrollHeight + 'px';
            }
        });
    </script>
</body>
</html>
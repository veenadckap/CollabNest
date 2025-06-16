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

  <a href="{{ route('dashboard') }}"
     class="flex items-center space-x-2 py-2 px-3 rounded-md 
            {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100 text-gray-900' }}">
    <i class="fas fa-home"></i><span>Dashboard</span>
  </a>

  <a href="{{ route('navUsers') }}"
     class="flex items-center space-x-2 py-2 px-3 rounded-md 
            {{ request()->routeIs('navUsers') ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100 text-gray-900' }}">
    <i class="fas fa-users"></i><span>Users</span>
  </a>

  <div>
      <a id="project" 
     class="flex items-center space-x-2 py-2 px-3 rounded-md 
        hover:bg-gray-100 text-gray-900  cursor-pointer">
    <i class="fas fa-box"></i><span >Projects</span>
  </a>

    <div class="branch  {{ request()->routeIs('projects') || request()->routeIs('navMyProject') || request()->routeIs('viewProject')  || request()->routeIs('editProject') || request()->routeIs('navCreateProject') ?'block' :'hidden'}}">
        <a href="{{route('projects')}}"
        class="flex items-center space-x-2 py-2 px-3 rounded-md 
              {{ request()->routeIs('projects') ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100 text-gray-900' }}">
        <i></i><i></i><span id="project">All project</span>
        </a>

      <a href="{{ route('navMyProject') }}"
        class="flex items-center space-x-2 py-2 px-3 rounded-md 
            {{ request()->routeIs('navMyProject')  ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100 text-gray-900' }}">
        <i></i><i></i><span id="project">My project</span>
      </a>
    </div>
  </div>

  <a href="{{ route('messages') }}"
     class="flex items-center space-x-2 py-2 px-3 rounded-md 
            {{ request()->routeIs('messages') ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100 text-gray-900' }}">
    <i class="far fa-comment"></i><span>Messages</span>
  </a>

  <a href="{{ route('meetings') }}"
     class="flex items-center space-x-2 py-2 px-3 rounded-md 
            {{ request()->routeIs('meetings') ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100 text-gray-900' }}">
    <i class="fas fa-video"></i><span>Meetings</span>
  </a>



  <a href="{{ route('settings') }}"
     class="flex items-center space-x-2 py-2 px-3 rounded-md 
            {{ request()->routeIs('settings') ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100 text-gray-900' }}">
    <i class="fas fa-cog"></i><span>Settings</span>
  </a>
</nav>


    </div>

    <div class="px-6 py-4 border-t border-gray-200">
      <form method="POST" action="/logout">
        @csrf
        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-lg flex items-center justify-center space-x-2 transition-all duration-200">
          <i class="fas fa-sign-out-alt"></i>
          <span>Logout</span>
        </button>
      </form>
    </div>
  </aside>


  <script>
let project = document.querySelector('#project'),
    branches = document.querySelector('.branch');

    project.addEventListener('click', (e) => {
      branches.style.display = branches.style.display === 'block' ? 'none' : 'block';
    });

  </script>

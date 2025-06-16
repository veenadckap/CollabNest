<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>TeamCollab Dashboard - Public Users</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: 'Inter', sans-serif; }
    .dark .dark\:bg-gray-900 { background-color: #1a202c; }
    .dark .dark\:text-white { color: #fff; }
    .dark .dark\:bg-gray-800 { background-color: #2d3748; }
    .dark .dark\:border-gray-700 { border-color: #4a5568; }
    .dark .dark\:placeholder-gray-400::placeholder { color: #a0aec0; }
  </style>
</head>
<body class="bg-[#f8fafc] dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex">

  <!-- Sidebar - Preserved as original -->
  @include('layout.aside')

  <!-- Main Content Area -->
  <main class="flex-1 p-8 overflow-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">All Users</h1>
    
    <div class="flex gap-8">
      @foreach($users as $user)

        @php 
          $proffession_id = \App\Models\UserTag::where('user_id',$user->id)->where('tag_model','profession')->pluck('tag_id');
          $skill_id = \App\Models\UserTag::where('user_id',$user->id)->where('tag_model','tech_skill')->pluck('tag_id');
          $profile = \App\Models\UserProfile::where('user_id',$user->id)->first();
          $userProfile = json_decode($profile,true)['profile_settings'];
          $image = json_decode($userProfile,true)['image'] ?? [];
          $bio = json_decode($userProfile,true)['bio'] ?? '';
        @endphp
      
      <!-- User Card 1 -->
      <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow hover:shadow-md transition-all duration-300 p-6">
        <div class="flex items-center space-x-4">
          <img src="{{ $image ? asset('storage/'. $image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF'}}" alt="User photo" class="w-16 h-16 rounded-full object-cover border-2 border-white dark:border-gray-600 shadow-sm">
          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{$user->name}}</h3>

            
            @foreach($proffession_id as $id)
            <p class="text-sm text-blue-500 dark:text-blue-400">{{\App\Models\Profession::where('id',$id)->value('profession')}}</p>
            @endforeach
            <div class="flex mt-1 space-x-1">
              @foreach($skill_id as $skill)
              <span class="text-xs px-2 py-1 bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-300 rounded-full">{{\App\Models\Skill::where('id',$skill)->value('skill')}}</span>
              @endforeach
            </div>
          </div>
        </div>
        <p class="mt-4 text-gray-600 dark:text-gray-300 text-sm">
          {{$bio}}
        </p>
        <a href="/profile/{{$user->id}}" class="inline-block mt-4 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
          View Profile
        </a>
      </div>
    @endforeach
    </div>
  </main>
</body>
</html>

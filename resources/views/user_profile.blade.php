<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>TeamCollab Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://unpkg.com/alpinejs" defer></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .profile-shadow {
      box-shadow: 0 4px 6px -1px rgba(6, 182, 212, 0.1), 0 2px 4px -1px rgba(6, 182, 212, 0.06);
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex">

  @include('layout.aside')

  <div class="flex-1 p-6">
    @if(session('success'))
        <div
            x-data = "{show:true}"
            x-init = "setTimeout(()=>show=false,3000)"
            x-show="show"
            x-transition
            class="bg-emerald-50 text-emerald-700 text-sm absolute top-4 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-lg border border-emerald-100 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    <div class="max-w-6xl mx-auto bg-white rounded-2xl overflow-hidden p-8 profile-shadow">
      <div class="flex flex-col md:flex-row gap-10 items-start">
        <!-- Left: Profile Image & Resume -->
        <div class="flex flex-col items-center gap-6 w-full md:w-1/3">

          @php
            $settings = json_decode($skills->profile_settings, true);
            $imagePath = $settings['image'] ?? null;
            $pdf = $settings['resume'] ?? null;
          @endphp

          <!-- Profile Image -->
            <div class="h-24 w-24 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow">
              <img id="profile-preview" 
                   src="{{ $imagePath ? asset('storage/' . $imagePath) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                   alt="Profile Preview" 
                   class="h-full w-full object-cover">
            </div>

          <!-- Resume PDF Preview -->
          @if($pdf)
          <div class="w-full">
            <div class="h-[440px] rounded-lg overflow-hidden shadow-sm border border-gray-100 bg-gray-50">
              <iframe src="{{ asset('storage/' . $pdf) }}#toolbar=0" class="w-full h-full" frameborder="0"></iframe>
            </div>
            
          @if($skills->user_id !== Auth::user()->id)
          <div class="mt-3 text-center">
              <a href="{{ asset('storage/' . $pdf) }}"target="_blank" download class="inline-flex items-center text-sm text-cyan-600 hover:text-cyan-800 font-medium transition-colors">
                <i class="fas fa-file-pdf mr-2"></i>
                Download Resume
              </a>
            </div>
            @endif

          </div>
          @endif
        </div>

        <!-- Right: Profile Details -->
        <div class="flex-1 space-y-6">
          <!-- Name & Professions -->
          <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ isset($userProfile['first_name']) ? $userProfile['first_name'].' '.$userProfile['last_name'] : \App\Models\User::where('id',$id)->value('name') }}</h1>
            <div class="mt-3 flex flex-wrap gap-2">
              @php 
                $professions_id = \App\Models\UserTag::where('user_id',$id)->where('tag_model','profession')->pluck('tag_id');
              @endphp
              
              @foreach($professions_id ?? [] as $n)
                <span class="bg-cyan-50 text-cyan-700 text-xs font-medium px-3 py-1.5 rounded-full border border-cyan-100">{{ App\Models\Profession::where('id',$n)->value('profession')}}</span>
              @endforeach
            </div>
          </div>

          <!-- Key Info Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
            <div class="bg-gray-50 p-3 rounded-lg">
            @php
                use Vinkla\Hashids\Facades\Hashids;
            @endphp

            <p class="text-gray-500 text-xs font-medium mb-1">User ID</p>
            <p class="font-semibold text-gray-700">{{ Hashids::encode($id) }}</p>

            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                @php
                    $tech_skill = [];
                    $tech_skill_id = \App\Models\UserTag::where('user_id',$id)->where('tag_model','tech_skill')->pluck('tag_id');

                        foreach ($tech_skill_id ?? [] as $skill_id) {
                            $tech_skill[] = \App\Models\Skill::where('id', $skill_id)->value('skill');
                        }
                @endphp

              <p class="text-gray-500 text-xs font-medium mb-1">Technical Skills</p>
              <p class="font-semibold text-cyan-600">
                {{ implode(', ', $tech_skill) ?: 'Not specified' }}
              </p>
            </div>

            @php 
              $soft_skills_id = \App\Models\UserTag::where('user_id',$id)->where('tag_model','tech_skill')->pluck('tag_id');
              $soft_skills=[];
              foreach($soft_skills_id ?? [] as $soft_skill){
                $soft_skills[]=\App\Models\SoftSkill::where('id',$soft_skill)->value('soft_skills');
              }
            @endphp
            <div class="bg-gray-50 p-3 rounded-lg">
              <p class="text-gray-500 text-xs font-medium mb-1">Soft Skills</p>
              <p class="font-semibold text-gray-700">{{ implode(', ', $soft_skills) ??  'Not specified' }}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
              <p class="text-gray-500 text-xs font-medium mb-1">Skill Level</p>
              <p class="font-semibold text-gray-700">{{ $settings['skill_level'] ?? 'Not specified' }}</p>
            </div>
            @php
              $interests =[];
              $interests_id = \App\Models\UserTag::where('user_id',$id)->where('tag_model','interest')->pluck('tag_id');
          
              foreach($interests_id as $int){
                $interests[]=\App\Models\Interest::where('id',$int)->value('interest');
              }
         
            @endphp
            <div class="bg-gray-50 p-3 rounded-lg">
              <p class="text-gray-500 text-xs font-medium mb-1">Interests</p>
              <p class="font-semibold text-gray-700">{{ implode(', ', $interests) ?: 'Not specified' }}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
              <p class="text-gray-500 text-xs font-medium mb-1">Availability</p>
              <p class="font-semibold text-gray-700">{{ $settings['availability'] ?? 'Not specified' }}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
              <p class="text-gray-500 text-xs font-medium mb-1">Experience</p>
              <p class="font-semibold text-gray-700">{{ $settings['years_of_experience'] ?? 'Not specified' }} years</p>
            </div>
            
            <!-- Added Date of Birth Field -->
            <div class="bg-gray-50 p-3 rounded-lg">
              <p class="text-gray-500 text-xs font-medium mb-1">Date of Birth</p>
              <p class="font-semibold text-gray-700">{{ $settings['dob'] ?? 'Not specified' }}</p>
            </div>
            
            <!-- Added Mobile Number Field -->
             @if($skills->user_id === Auth::user()->id)
            <div class="bg-gray-50 p-3 rounded-lg">
              <p class="text-gray-500 text-xs font-medium mb-1">Mobile Number</p>
              <p class="font-semibold text-gray-700">{{ $settings['mobile'] ?? 'Not specified' }}</p>
            </div>
            
            <!-- Added Address Field -->
            <div class="bg-gray-50 p-3 rounded-lg">
              <p class="text-gray-500 text-xs font-medium mb-1">Address</p>
              <p class="font-semibold text-gray-700">{{ $settings['address'] ?? 'Not specified' }}</p>
            </div>
          </div>
              @endif
          <!-- Bio -->
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-500 text-xs font-medium mb-2">About Me</p>
            <p class="text-gray-700 text-sm leading-relaxed">
              {{ $settings['bio'] ?? 'No bio information available. Update your profile to add a bio.' }}
            </p>
          </div>

    
          <!-- Social Links -->
          <div class="flex flex-wrap gap-4 items-center">
            <!-- GitHub Link -->
             @if(isset($settings['github']))
            <div>
              <a href="{{$settings['github'] ?? 'https://github.com'}}" target="_blank"
                 class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                <i class="fab fa-github mr-2"></i>
                GitHub
              </a>
            </div>
            @endif
                      
            <!-- LeetCode Link -->
             @if(isset($settings['leetcode']))
            <div>
              <a href="{{$settings['leetcode'] ?? 'https://leetcode.com'}}" target="_blank"
                 class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-sm font-medium rounded-md transition-colors duration-200">
                <i class="fas fa-code mr-2"></i>
                LeetCode
              </a>
            </div>
            @endif
                      
            <!-- LinkedIn Link -->
             @if(isset($settings['linkedin']))
            <div>
              <a href="{{$settings['linkedin'] ?? 'https://linkedin.com'}}" target="_blank"
                 class="inline-flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-md transition-colors duration-200">
                <i class="fab fa-linkedin-in mr-2"></i>
                LinkedIn
              </a>
            </div>
            @endif
          </div>

          <!-- Button -->
          @if($skills->user_id === Auth::user()->id)
          <div class="pt-2">
            <a href="/navProfile/edit" class="inline-flex items-center bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-medium px-6 py-3 rounded-lg shadow-sm transition-all text-sm">
              <i class="fas fa-user-edit mr-2"></i>
              Update Profile
            </a>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

</body>
</html>
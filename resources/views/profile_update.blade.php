<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Update Profile | TeamCollab</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .tag {
      transition: all 0.2s ease;
    }

    .tag:hover {
      transform: translateY(-1px);
    }

    .tag-remove {
      transition: all 0.2s ease;
    }

    .tag-remove:hover {
      color: #dc2626;
      transform: scale(1.1);
    }

    .input-tag-container {
      min-height: 44px;
    }

    #profession_suggession {
      display: none;
      position: absolute;
      width: 100%;
      max-height: 200px;
      overflow-y: auto;
      background: white;
      border: 1px solid #e5e7eb;
      border-radius: 0.375rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      z-index: 10;
    }

    #profession_suggession li {
      padding: 8px 12px;
      cursor: pointer;
    }

    #profession_suggession li:hover {
      background-color: #f3f4f6;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen py-10 px-4">

  <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl overflow-hidden">
    <!-- Header with Gradient -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-white">Update Your Profile</h1>
          <p class="text-blue-100 mt-1">Keep your professional information up-to-date</p>
        </div>
        <div class="flex items-center space-x-2">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white bg-opacity-20 text-white">
            <i class="fas fa-user-edit mr-1"></i> Edit Mode
          </span>
        </div>
      </div>
    </div>

    @php
    $image = json_decode($skills->profile_settings,true)['image'] ?? '';
    @endphp

    <!-- Form -->
    <form action="/profile/update" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
      @csrf

      <!-- Profile Image + Basic Info -->
      <section class="">
        <!-- Profile Image Upload -->
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
            <div class="flex items-center space-x-4">
              <div class="relative">
                <div class="h-24 w-24 rounded-full bg-gray-200 overflow-hidden border-2 border-white shadow">
                  <img id="profile-preview" src="{{ $image ? asset('storage/' . $image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                    alt="Profile Preview" class="h-full w-full object-cover">
                </div>
                <label for="profile_image" class="absolute -bottom-2 -right-2 bg-white p-1.5 rounded-full shadow-md cursor-pointer hover:bg-gray-100">
                  <i class="fas fa-camera text-blue-600 text-sm"></i>
                </label>
              </div>
              <input type="file" name="profile_image" id="profile_image" accept="image/*" class="hidden">
            </div>
          </div>

          <!-- Resume Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Resume (PDF)</label>
            <div class="flex items-center">
              <label for="resume" class="flex-1 cursor-pointer">
                <div class="flex items-center justify-between px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100">
                  <span class="text-sm text-gray-600 truncate">
                    {{ json_decode($skills->profile_settings,true)['resume'] ?? 'Upload resume' }}
                  </span>
                  <i class="fas fa-file-pdf text-red-500 ml-2"></i>
                </div>
                <input type="file" id="resume" name="resume" accept=".pdf" class="hidden">
              </label>
            </div>
          </div>
        </div>

        <!-- Basic Info -->
        <div class="md:col-span-2 space-y-5">
          <!-- First Name -->
  <div>
    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
    <input type="text" id="first_name" name="first_name"
           value="{{ json_decode($skills->profile_settings,true)['first_name'] ?? '' }}"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
  </div>

  <!-- Last Name -->
  <div>
    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
    <input type="text" id="last_name" name="last_name"
           value="{{ json_decode($skills->profile_settings,true)['last_name'] ?? '' }}"
           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
  </div>

          <!-- Mobile Number -->
          <div>
            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-phone text-gray-400"></i>
              </div>
              <input type="tel" id="mobile" maxlength="10" name="mobile" value="{{ json_decode($skills->profile_settings,true)['mobile'] ?? '' }}" placeholder="+1 234 567 8900"
                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
          </div>

          <!-- Date of Birth -->
          <div>
            <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-calendar-alt text-gray-400"></i>
              </div>
              <input type="date" id="dob" name="dob" value="{{ json_decode($skills->profile_settings,true)['dob'] ?? '' }}"
                class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
              <div id="dob-error" class="text-red-500 text-xs mt-1 hidden">You must be at least 18 years old.</div>
            </div>
          </div>

          <!-- Address -->
          <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea id="address" name="address" rows="2" placeholder="Enter your full address"
              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ json_decode($skills->profile_settings,true)['address'] ?? '' }}</textarea>
          </div>

          <!-- Profession Tags -->
          <div class="relative">
            <label class="block text-sm font-medium text-gray-700 mb-1">Profession(s)</label>
            <div class="input-tag-container flex flex-wrap items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
              <div id="profession-tags" class="flex flex-wrap gap-2">

                @php
                $professions_id = \App\Models\UserTag::where('tag_model','profession')->where('user_id',Auth::user()->id)->pluck('tag_id') ?? [];
                $professions =[];
                foreach($professions_id as $n){
                $professions[]=\App\Models\Profession::where('id',$n)->value('profession');
                }
                @endphp
                @if(isset($professions))

                <div class="tag inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">

                  <button type="button" class="tag-remove ml-1.5 text-blue-600 hover:text-blue-800">
                    <i class="fas fa-times text-xs"></i>
                  </button>
                </div>

                @endif
              </div>
              <input type="text" id="profession-input" placeholder="e.g. Developer, Designer"
                class="flex-1 min-w-[100px] border-0 focus:ring-0 px-1 py-1 text-sm">
              <button type="button" id="add-profession" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-plus-circle"></i>
              </button>
              <input type="hidden" name="profession" id="profession-values" value="{{ implode(',', $professions) ?? '' }}">

            </div>
            <ul id="prof_suggession" class="absolute mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 max-h-48 overflow-auto "></ul>
          </div>
        </div>
      </section>

      <!-- Social Links -->
      <section class="grid md:grid-cols-2 gap-6">
        <div>
          <label for="github" class="block text-sm font-medium text-gray-700 mb-1">GitHub</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fab fa-github text-gray-400"></i>
            </div>
            <input type="url" id="github" name="github" value="{{ json_decode($skills->profile_settings,true)['github'] ?? '' }}" placeholder="https://github.com/yourusername"
              class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
          </div>
        </div>
        <div>
          <label for="leetcode" class="block text-sm font-medium text-gray-700 mb-1">LeetCode</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-code text-gray-400"></i>
            </div>
            <input type="url" id="leetcode" name="leetcode" value="{{ json_decode($skills->profile_settings,true)['leetcode'] ?? '' }}" placeholder="https://leetcode.com/yourusername"
              class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
          </div>
        </div>
        <div>
          <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fab fa-linkedin text-gray-400"></i>
            </div>
            <input type="url" id="linkedin" name="linkedin" value="{{ json_decode($skills->profile_settings,true)['linkedin'] ?? '' }}" placeholder="https://linkedin.com/in/yourprofile"
              class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
          </div>
        </div>
      </section>

      <!-- Skills & Experience -->
      <section class="space-y-5">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
          <i class="fas fa-tools text-blue-500 mr-2"></i> Skills & Expertise
        </h2>

        <div class="grid md:grid-cols-2 gap-6">
          <!-- Technical Skills Tags -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Technical Skills</label>
            <div class="input-tag-container flex flex-wrap items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
              <div id="technical-skills-tags" class="flex flex-wrap gap-2">


                @php
                $tech_skills_id = \App\Models\UserTag::where('tag_model','tech_skill')->where('user_id',Auth::user()->id)->pluck('tag_id') ?? [];
                $tech_skills = [];
                foreach($tech_skills_id as $tech_id){
                $tech_skills[]=\App\Models\Skill::where('id', $tech_id)->value('skill');
                }
                @endphp

                <div class="tag inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">

                  <button type="button" class="tag-remove ml-1.5 text-indigo-600 hover:text-indigo-800">
                    <i class="fas fa-times text-xs"></i>
                  </button>
                </div>

              </div>
              <input type="text" id="technical-skills-input" placeholder="e.g. JavaScript, Python"
                class="flex-1 min-w-[100px] border-0 focus:ring-0 px-1 py-1 text-sm">
              <button type="button" id="add-technical-skill" class="text-indigo-600 hover:text-indigo-800">
                <i class="fas fa-plus-circle"></i>
              </button>
              <input type="hidden" name="technical_skills" id="technical-skills-values"
                value="{{ implode(',', $tech_skills) ?? '' }}">
            </div>
            <ul id="skills_suggession"
              class="absolute mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 max-h-48 overflow-auto ">
            </ul>
          </div>

          <!-- Soft Skills Tags -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Soft Skills</label>
            <div class="input-tag-container flex flex-wrap items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
              <div id="soft-skills-tags" class="flex flex-wrap gap-2">

                @php
                $soft_skills_id = \App\Models\UserTag::where('tag_model','soft_skill')->where('user_id',Auth::user()->id)->pluck('tag_id') ?? [];
                $soft_skills=[];
                foreach($soft_skills_id as $soft_skill){
                $soft_skills[]=\App\Models\SoftSkill::where('id',$soft_skill)->value('soft_skills');
                }
                @endphp


                @if(isset($soft_skills))

                <div class="tag inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">

                  <button type="button" class="tag-remove ml-1.5 text-green-600 hover:text-green-800">
                    <i class="fas fa-times text-xs"></i>
                  </button>
                </div>

                @endif
              </div>
              <input type="text" id="soft-skills-input" placeholder="e.g. Leadership, Communication"
                class="flex-1 min-w-[100px] border-0 focus:ring-0 px-1 py-1 text-sm">
              <button type="button" id="add-soft-skill" class="text-green-600 hover:text-green-800">
                <i class="fas fa-plus-circle"></i>
              </button>
              <input type="hidden" name="soft_skills" id="soft-skills-values"
                value="{{ implode(',', $soft_skills) ?? '' }}">
            </div>
            <ul id="soft_skill_suggession"
              class="absolute mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 max-h-48 overflow-auto ">
            </ul>
          </div>

          <!-- Skill Level -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Skill Level</label>
            <select name="skill_level"
              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
              <option value="Beginner" {{ (json_decode($skills->profile_settings,true)['skill_level'] ?? '') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
              <option value="Intermediate" {{ (json_decode($skills->profile_settings,true)['skill_level'] ?? '') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
              <option value="Expert" {{ (json_decode($skills->profile_settings,true)['skill_level'] ?? '') == 'Expert' ? 'selected' : '' }}>Expert</option>
            </select>
          </div>

          <!-- Years of Experience -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Years of Experience</label>
            <div class="relative">
              <input type="number" min="0" name="years_of_experience" value="{{ json_decode($skills->profile_settings,true)['years_of_experience'] ?? '' }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <span class="text-gray-500">years</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Preferences -->
      <section class="space-y-5">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
          <i class="fas fa-sliders-h text-blue-500 mr-2"></i> Preferences
        </h2>

        <div class="grid md:grid-cols-2 gap-6">
          <!-- Interests Tags -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Interests</label>
            <div class="input-tag-container flex flex-wrap items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
              <div id="interests-tags" class="flex flex-wrap gap-2">

                @php
                $interests_id = \App\Models\UserTag::where('tag_model','interest')->where('user_id',Auth::user()->id)->pluck('tag_id') ?? [];
                $interests = [];
                foreach ($interests_id as $interest) {
                $interests[] = \App\Models\Interest::where('id', $interest)->value('interest');
                }
                @endphp

                <div class="tag inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">

                  <button type="button" class="tag-remove ml-1.5 text-purple-600 hover:text-purple-800">
                    <i class="fas fa-times text-xs"></i>
                  </button>
                </div>
              </div>
              <input type="text" id="interests-input" placeholder="e.g. Open Source, AI"
                class="flex-1 min-w-[100px] border-0 focus:ring-0 px-1 py-1 text-sm">
              <button type="button" id="add-interest" class="text-purple-600 hover:text-purple-800">
                <i class="fas fa-plus-circle"></i>
              </button>
              <input type="hidden" name="interests" id="interests-values"
                value="{{ implode(',', $interests) ?? '' }}">
            </div>
            <ul id="interests_suggession"
              class="absolute mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 max-h-48 overflow-auto ">
            </ul>
          </div>

          <!-- Availability -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
            <input type="text" name="availability" value="{{ json_decode($skills->profile_settings,true)['availability'] ?? '' }}" placeholder="e.g. Weekends, Evenings"
              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
          </div>
        </div>
      </section>

      <!-- Bio -->
      <div>
        <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">About You</label>
        <textarea id="bio" name="bio" rows="4" placeholder="Tell us about yourself, your experience, and what you're passionate about"
          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ json_decode($skills->profile_settings,true)['bio'] ?? '' }}</textarea>
      </div>

      <!-- Form Buttons -->
      <div class="flex justify-between items-center pt-6 border-t border-gray-200">
        <a href="{{ url()->previous() }}"
          class="flex items-center px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
          <i class="fas fa-arrow-left mr-2"></i> Cancel
        </a>
        <button type="submit"
          class="flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition">
          <i class="fas fa-save mr-2"></i> Save Changes
        </button>
      </div>
    </form>
  </div>

  <script>
    $(document).ready(function() {

      // Tag handling functions
      function setupTagSystem(inputSelector, addButtonSelector, tagsContainerSelector, hiddenInputSelector, colorClasses) {
        let tags = $(hiddenInputSelector).val() ? $(hiddenInputSelector).val().split(',') : [];

        function updateTags() {
          $(tagsContainerSelector).empty();
          tags.forEach(tag => {
            if (tag.trim()) {
              $(tagsContainerSelector).append(`
                <div class="tag inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${colorClasses.bg} ${colorClasses.text}">
                  ${tag.trim()}
                  <button type="button" class="tag-remove ml-1.5 ${colorClasses.hover}">
                    <i class="fas fa-times text-xs"></i>
                  </button>
                </div>
              `);
            }
          });
          $(hiddenInputSelector).val(tags.join(','));
        }

        $(addButtonSelector).on('click', function() {
          const val = $(inputSelector).val().trim();
          if (val && !tags.includes(val)) {
            tags.push(val);
            updateTags();
            $(inputSelector).val('');
          }
        });

        $(inputSelector).on('keypress', function(e) {
          if (e.which === 13) { // Enter key
            e.preventDefault();
            $(addButtonSelector).click();
          }
        });

        $(document).on('click', `${tagsContainerSelector} .tag-remove`, function() {
          const tagText = $(this).parent().text().trim();
          tags = tags.filter(t => t.trim() !== tagText);
          updateTags();
        });

        // Initialize tags on page load
        updateTags();
      }

      // Setup all tag systems
      setupTagSystem('#profession-input', '#add-profession', '#profession-tags', '#profession-values', {
        bg: 'bg-blue-100',
        text: 'text-blue-800',
        hover: 'text-blue-600 hover:text-blue-800'
      });

      setupTagSystem('#technical-skills-input', '#add-technical-skill', '#technical-skills-tags', '#technical-skills-values', {
        bg: 'bg-indigo-100',
        text: 'text-indigo-800',
        hover: 'text-indigo-600 hover:text-indigo-800'
      });

      setupTagSystem('#soft-skills-input', '#add-soft-skill', '#soft-skills-tags', '#soft-skills-values', {
        bg: 'bg-green-100',
        text: 'text-green-800',
        hover: 'text-green-600 hover:text-green-800'
      });

      setupTagSystem('#interests-input', '#add-interest', '#interests-tags', '#interests-values', {
        bg: 'bg-purple-100',
        text: 'text-purple-800',
        hover: 'text-purple-600 hover:text-purple-800'
      });


      function setupSuggestion(inputId, listId, fetchUrl, clickBtnId, keyName = '') {
        $(`#${inputId}`).on('input', function() {
          const query = $(this).val().trim();
          const list = $(`#${listId}`);
          list.empty();
          if (!query) return;

          fetch(`${fetchUrl}${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
              if (!data.length) return list.append('<li class="p-2 text-gray-500">No matches found</li>');
              data.forEach(item => {
                const text = typeof item === 'object' ? item[keyName] : item;
                list.append(`<li class="p-2 hover:bg-gray-100 cursor-pointer">${text}</li>`);
              });
            })
            .catch(err => console.error('Fetch error:', err));
        });

        $(document).on('click', `#${listId} li`, function() {
          const selected = $(this).text();
          $(`#${inputId}`).val(selected);
          $(`#${listId}`).empty();
          $(`#${clickBtnId}`).click();
        });
      }


      setupSuggestion('profession-input', 'prof_suggession', '/profession/search?q=', 'add-profession');
      setupSuggestion('technical-skills-input', 'skills_suggession', '/skills/search?q=', 'add-technical-skill');
      setupSuggestion('soft-skills-input', 'soft_skill_suggession', '/softSkill/search?query=', 'add-soft-skill');
      setupSuggestion('interests-input', 'interests_suggession', '/interests/search?query=', 'add-interest');


    });

    $(document).ready(function() {
      // Form validation
      $('form').on('submit', function(e) {
        let isValid = true;
        const errors = [];

        // Validate Name
        const name = $('#name').val().trim();
        if (!name) {
          errors.push('Full name is required');
          $('#name').addClass('border-red-500');
          isValid = false;
        } else {
          $('#name').removeClass('border-red-500');
        }

        // Validate Profession (at least one)
        const professions = $('#profession-values').val();
        if (!professions) {
          errors.push('At least one profession is required');
          $('.input-tag-container').first().addClass('border-red-500');
          isValid = false;
        } else {
          $('.input-tag-container').first().removeClass('border-red-500');
        }

        // Validate Technical Skills (at least one)
        const techSkills = $('#technical-skills-values').val();
        if (!techSkills) {
          errors.push('At least one technical skill is required');
          $('#technical-skills-tags').closest('.input-tag-container').addClass('border-red-500');
          isValid = false;
        } else {
          $('#technical-skills-tags').closest('.input-tag-container').removeClass('border-red-500');
        }

        // Validate URLs format if provided
        const validateUrl = (url, fieldName) => {
          if (url && !/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/.test(url)) {
            errors.push(`Please enter a valid ${fieldName} URL`);
            $(`#${fieldName}`).addClass('border-red-500');
            return false;
          }
          $(`#${fieldName}`).removeClass('border-red-500');
          return true;
        };

        validateUrl($('#github').val().trim(), 'github');
        validateUrl($('#linkedin').val().trim(), 'linkedin');
        validateUrl($('#leetcode').val().trim(), 'leetcode');

        // Validate Mobile Number if provided
        const mobile = $('#mobile').val().trim();
        if (mobile && !/^[6-9][0-9]{9}$/.test(mobile)) {
          errors.push('Please enter a valid mobile number');
          $('#mobile').addClass('border-red-500');
          isValid = false;
        } else {
          $('#mobile').removeClass('border-red-500');
        }

        //Validate dob

        document.getElementById('dob').addEventListener('change', function() {
          const dobInput = this.value;
          const errorElement = document.getElementById('dob-error');

          if (!dobInput) {
            errorElement.classList.add('hidden');
            this.classList.remove('border-red-500');
            return;
          }

          const birthDate = new Date(dobInput);
          const today = new Date();
          let age = today.getFullYear() - birthDate.getFullYear();
          const monthDiff = today.getMonth() - birthDate.getMonth();

          // Adjust age if birthday hasn't occurred yet this year
          if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
          }

          if (age < 18) {
            errorElement.classList.remove('hidden');
            this.classList.add('border-red-500');
          } else {
            errorElement.classList.add('hidden');
            this.classList.remove('border-red-500');
          }
        });

        // Validate Years of Experience if provided
        const yearsExp = $('input[name="years_of_experience"]').val();
        if (yearsExp && (isNaN(yearsExp) || yearsExp < 0 || yearsExp > 50)) {
          errors.push('Years of experience must be between 0 and 50');
          $('input[name="years_of_experience"]').addClass('border-red-500');
          isValid = false;
        } else {
          $('input[name="years_of_experience"]').removeClass('border-red-500');
        }

        // Validate file types
        const profileImage = $('#profile_image')[0].files[0];
        if (profileImage && !profileImage.type.match('image.*')) {
          errors.push('Profile image must be an image file (JPEG, PNG, etc.)');
          isValid = false;
        }

        const resumeFile = $('#resume')[0].files[0];
        if (resumeFile && !resumeFile.name.match(/\.(pdf)$/i)) {
          errors.push('Resume must be a PDF file');
          isValid = false;
        }

        // Show errors if any
        if (!isValid) {
          e.preventDefault();

          // Remove any existing error messages
          $('.error-message').remove();

          // Show error messages
          if (errors.length > 0) {
            const errorHtml = `
              <div class="error-message mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                <div class="flex items-center">
                  <i class="fas fa-exclamation-circle mr-2"></i>
                  <strong>Please fix the following issues:</strong>
                </div>
                <ul class="mt-2 ml-6 list-disc">
                  ${errors.map(error => `<li>${error}</li>`).join('')}
                </ul>
              </div>
            `;

            $(errorHtml).insertAfter('.bg-gradient-to-r');
          }
        }
      });

      // Real-time validation for inputs
      $('input, textarea, select').on('input change', function() {
        $(this).removeClass('border-red-500');
      });
    });
  </script>
</body>

</html>
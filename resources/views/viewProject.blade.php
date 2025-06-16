<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>{{ $project->title }} | TeamCollab Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .skill-tag {
      transition: all 0.2s ease;
    }

    .skill-tag:hover {
      transform: translateY(-2px);
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
    }
  </style>
</head>
@if(session('success'))
<div id="toast"
  class="fixed bottom-5 right-5 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in">
  <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
</div>

<script>
  // Auto-dismiss after 2 minutes (120,000ms)
  setTimeout(() => {
    const toast = document.getElementById('toast');
    if (toast) toast.style.display = 'none';
  }, 120000); // 2 minutes = 120000 ms
</script>

<style>
  @keyframes slide-in {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-slide-in {
    animation: slide-in 0.5s ease-out;
  }
</style>
@endif


<body class="bg-gray-100 text-gray-800 min-h-screen flex">

  @include('layout.aside')

  <main class="flex-1  h-screen overflow-y-auto p-6">
    <div class="max-w-5xl mx-auto space-y-10">

      <!-- Header -->
      <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
          <h1 class="text-4xl font-bold text-gray-900">{{ $project->title }}</h1>
          <div class="flex items-center mt-2 space-x-4 text-sm text-gray-600">
            <span class="px-3 py-1 rounded-full font-medium 
              {{ $project->is_private ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
              {{ $project->is_private ? 'Private' : 'Public' }}
            </span>
            <span>Owned by <strong>{{ \App\Models\User::where('id',$project->owner_id)->value('name') }}</strong></span>
          </div>
        </div>
        <div class="flex gap-3">
          <a href="{{ url()->previous() }}" class="flex items-center px-4 py-2 text-sm bg-white border rounded-md shadow-sm hover:bg-gray-50 text-gray-700">
            <i class="fas fa-arrow-left mr-2"></i> Back
          </a>

          @if($project->owner_id === Auth::user()->id)
          <a href="/navUpdateProject/{{$project->id}}" class="flex items-center px-4 py-2 text-sm text-white bg-indigo-600 rounded-md shadow hover:bg-indigo-700">
            <i class="fas fa-edit mr-2"></i> Edit
          </a>
          @endif
        </div>
      </div>

      <!-- Project Details Card -->
      <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
        <div class="p-8 space-y-10">

          <!-- Description -->
          <section>
            <h2 class="text-xl font-semibold mb-2 flex items-center">
              <i class="fas fa-align-left mr-2 text-indigo-500"></i> Description
            </h2>
            <p class="text-gray-700 leading-relaxed">
              {{ $project->description ?? 'No description provided.' }}
            </p>
          </section>

          <!-- Goals -->
          <section>
            <h2 class="text-xl font-semibold mb-2 flex items-center">
              <i class="fas fa-bullseye mr-2 text-indigo-500"></i> Goals
            </h2>
            <p class="text-gray-700 leading-relaxed">
              {{ $project->goals ?? 'No goals defined.' }}
            </p>
          </section>

          <!-- Grid Sections -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Skills -->
            <div>
              <h3 class="text-lg font-semfibold mb-2 flex items-center">
                <i class="fas fa-tools mr-2 text-indigo-500"></i> Skills Required
              </h3>

              @if($project->skills_required)
              <div class="flex flex-wrap gap-2">
                @foreach (json_decode($project->skills_required) as $skill)
                <span class="skill-tag inline-block px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-800">
                  {{ App\Models\Skill::where('id',$skill)->value('skill') }}
                </span>
                @endforeach
              </div>
              @else
              <p class="text-gray-500 italic">Not specified</p>
              @endif
            </div>

            <!-- Documents -->
            <div>
              <h3 class="text-lg font-semibold mb-2 flex items-center">
                <i class="fas fa-file-alt mr-2 text-indigo-500"></i> Requirements
              </h3>
              @if($project->requirement_documents)
              @foreach(json_decode($project->requirement_documents,true) as $ind=>$docs)
              <a href="{{ asset('storage/' . $docs) }}" target="_blank"
                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-download mr-2"></i> {{$ind}}
              </a>
              @endforeach
              @else
              <p class="text-gray-500 italic">No documents uploaded</p>
              @endif
            </div>

            <span class="px-3 py-1 rounded-full text-sm font-medium 
            @if($project->status == 0) bg-yellow-100 text-yellow-800
            @elseif($project->status == 1) bg-green-100 text-green-800
            @elseif($project->status == 2) bg-orange-100 text-orange-800
         0
            @else bg-gray-100 text-gray-800
            @endif">Project Status :
              @php
              $statusText = match($project->status) {
              0 => 'OPEN',
              1 => 'ACTIVE',
              default => 'CLOSED',
              };
              @endphp

              {{ $statusText }}
            </span>
          </div>
        </div>



        <!-- Footer -->
        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex justify-between items-center">
          <span class="text-sm text-gray-500">
            Created on {{ $project->created_at->format('M d, Y') }}
          </span>
          <div class="flex gap-3">
            <button class="flex items-center px-3 py-1.5 text-sm border border-gray-300 rounded-md bg-white text-gray-700 hover:bg-gray-100">
              <i class="fas fa-share-alt mr-2"></i> Share
            </button>
            @if($project->owner_id !== Auth::user()->id)
            <form action="{{ route('request', ['project' => $project->id]) }}" method="POST">
              @csrf
              <button type="submit" class="flex items-center px-3 py-1.5 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                <i class="fas fa-user-plus mr-2"></i> Request
              </button>
            </form>
            @else
            <div x-data="{ showInviteModal: false }">
              <a href="#" @click.prevent="showInviteModal = true" class="flex items-center px-3 py-1.5 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                <i class="fas fa-paper-plane mr-2"></i> Invite
              </a>

              <!-- Modal -->
              <div x-show="showInviteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-transition>
                <!-- Modal Panel -->
                <div @click.away="showInviteModal = false" class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md" x-transition>
                  <h2 class="text-lg font-semibold mb-4 text-gray-800">Invite a Member</h2>

                  <form method="POST" action="{{ route('sendInvite', $project->id) }}">
                    @csrf
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input type="email" name="email" id="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-200 mb-4" />

                    <div class="flex justify-end gap-2">
                      <button type="button" @click="showInviteModal = false" class="px-4 py-2 text-sm bg-gray-200 rounded-md hover:bg-gray-300">
                        Cancel
                      </button>
                      <button type="submit" class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                        Send Invite
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    @include('team')

    @include('tasks/index')
  </main>
</body>

</html>
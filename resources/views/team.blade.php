<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>TeamCollab Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-[#f8fafc] text-gray-900 min-h-screen flex">

  <!-- Main Content -->
  <div class="max-w-4xl mx-auto p-6 space-y-6 w-full">

    <!-- Team Details -->
    <div class="bg-white shadow-md rounded-2xl p-6">
      <h2 class="text-xl font-semibold mb-4 text-gray-800">Team Details</h2>
      <p class="text-sm text-gray-700 space-y-1">
        <span><strong>Project Title:</strong> {{ session('project_title') }}</span><br>
        <span><strong>Created On:</strong> {{ \Carbon\Carbon::parse(session('project_created'))->format('F j, Y') }}</span><br>
        <span><strong>Status:</strong> {{ session('project_status') }}</span><br>
        <span><strong>Description:</strong> {{ session('project_description') }}</span>
      </p>
    </div>

    <!-- Team Members -->
    <div class="bg-white shadow-md rounded-2xl p-6">
      <h2 class="text-xl font-semibold mb-4 text-gray-800">Team Members</h2>
      <ul class="space-y-2 text-sm text-gray-700 list-inside">
    {{-- Team Lead --}}
    @if(session('owner_name'))
      <li>👤 {{ session('owner_name') }} (Team Lead)</li>
    @endif

    {{-- Requesters with Skill --}}
    @php
        $requesters = session('requester_name');
    @endphp

    @if(is_array($requesters) && count($requesters))
        @foreach($requesters as $requester)
            <li>👤 {{ $requester['name'] }} ({{ $requester['skill'] }})</li>
        @endforeach
    @elseif(is_string($requesters))
        <li>👤 {{ $requesters }} (Backend Developer)</li>
    @endif

      </ul>
    </div>

  </div>
</body>
</html>

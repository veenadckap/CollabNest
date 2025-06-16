<?php

namespace App\Http\Controllers;

use App\Models\ProjectRequest;
use App\Models\ProjectTeam;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\ProjectRequestMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectInviteMail;


class ProjectRequestController extends Controller
{
    public function sendRequest($id)
{
    $project = Project::findOrFail($id);
    $owner = User::find($project->owner_id);
    $requester = Auth::user();

    if ($project->owner_id === Auth::id()) {
        return redirect()->back()->with('error', 'You cannot request your own project.');
    }


    ProjectRequest::create([
        'user_id'    => $requester->id,
        'project_id' => $project->id,
    ]);

    Mail::to($owner->email)->send(new ProjectRequestMail($requester, $project));

    return redirect()->back()->with('success', 'Request sent to the project owner!');
}


    public function acceptRequest(Request $request, $id)
    {
        $userId = $request->query('user'); 
        $requester = User::findOrFail($userId);

        $projectRequest = ProjectRequest::where('user_id', $userId)->firstOrFail();
        $project = Project::findOrFail($projectRequest->project_id);
        $owner = User::findOrFail($project->owner_id);


        ProjectTeam::create([
            'project_id' => $project->id,
            'user_id' => $requester->id,
            'owner_id' => $project->owner_id,
        ]);

        $requesters = session()->get('requester_name', []);
        $requesters[] = [
            'name' => $requester->name,
            'skill' => $requester->skill ?? 'Backend Developer',
        ];
        session()->put('requester_name', $requesters);
        session()->put([
            'owner_name' => $owner->name,
            'project_title' => $project->title,
            'project_created' => $project->created_at,
            'project_status' => $project->status,
            'project_description' => $project->description,
        ]);

        return redirect('/viewProject')->with('success', 'Request accepted and team updated!');
    }

    public function rejectRequest(Request $request, $id)
    {
        $userId = $request->query('user');

        $project = Project::findOrFail($id);
        if (Auth::id() !== $project->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        return redirect('/dashboard')->with('info', 'You rejected the request for project: ' . $project->name);
    }

      public function sendInvite(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $project = Project::findOrFail($id);

        Mail::to($request->email)->send(new ProjectInviteMail($project));

        return redirect('/dashboard')->with('success', 'Invitation email sent!');
    }

}

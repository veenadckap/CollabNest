<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\User;
use App\Models\Skill;
use App\Mail\ProjectRequestMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('AllProjects',compact('projects'));
    }

    public function navMyProject(){

        $projects = Project::where('owner_id',Auth::user()->id)->get();

        return view('MyProject',compact('projects'));
    }

    public function navcreateproject()
    {
        return view('createProject');
    }

    public function CreateProject(Request $request)
    {

       
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'goals' => 'required',
            'skills_required' => 'nullable|array',
            'github' => 'nullable|url|max:255',
            'trello' => 'nullable|url|max:255',
            'is_private' => 'required|boolean',
        ]);

        $validated['owner_id'] = Auth::user()->id;

        // Handle file uploads
        $document_path=[];
        if($request->file('requirement_documents')){
            foreach($request->file('requirement_documents') as $ind=>$file){
               if(isset($file) && isset($request->doc_names[$ind])){
                    $name = $request->doc_names[$ind];
                    $document_path[$name] = $file->store('projectDocuments','public');
               }
  
            }
        }

    
        $logo_path = '';
        if ($request->hasFile('logo')) {
            $logo_path = $request->file('logo')->store('files', 'public');
        }

        // Convert skill names to IDs
        $skills = [];
        if (!empty($validated['skills_required'])) {
            foreach ($validated['skills_required'] as $skill) {
                $skills[] = Skill::where('skill', $skill)->value('id');
            }
        }

        // Prepare data for saving
        $validated['requirement_documents'] = json_encode($document_path);
        $validated['logo'] = $logo_path;
        $validated['project_url'] = json_encode([
            'github' => $validated['github'] ?? '',
            'trello' => $validated['trello'] ?? ''
        ]);
        $validated['skills_required'] = json_encode($skills);
        $validated['status']=0;

        Project::create($validated);

        return redirect()->route('navMyProject')->with('success', 'Project created succesfully!');
    }

        public function viewProject(Project $project)
    {
    $user = \Illuminate\Support\Facades\Auth::user(); 
    $userId = $user->id;

        $assignedTasks = Task::where('project_id', $project->id)
                             ->where('assigned_by', $userId)
                             ->get();

        $receivedTasks = Task::where('project_id', $project->id)
                             ->where('assigned_to', $userId)
                             ->get();

        return view('viewProject', compact('project', 'assignedTasks', 'receivedTasks'));
    }


    public function navUpdateProject($id)
    {
        $project = Project::findOrFail($id);
        return view('updateProject', compact('project'));
    }

    public function UpdateProject(Request $request, $id)
    {

  
   
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'goals' => 'required',
            'technical_skills' => 'required|string',
            'github' => 'required|url|max:255',
            'trello' => 'required|url|max:255',
            'is_private' => 'required|boolean',
        ]);

        $project = Project::findOrFail($id);

        // Handle logo update
        $logo_path = $project->logo;
        if ($request->hasFile('logo')) {
            if ($logo_path && Storage::disk('public')->exists($logo_path)) {
                Storage::disk('public')->delete($logo_path);
            }
            $logo_path = $request->file('logo')->store('files', 'public');
        }

        // Handle document updates
        $document_path = json_decode($project->requirement_documents, true) ?? [];
        $removed_docs = json_decode($request->removed_documents, true) ?? [];

        foreach($removed_docs as $remove){
            if(isset($document_path[$remove])){
                $file_path = $document_path[$remove];
                if(Storage::disk('public')->exists($file_path)){
                    Storage::disk('public')->delete($file_path);
                }
            }
        }

        $document_path = array_filter($document_path, function ($key) use ($removed_docs) {
            return !in_array($key, $removed_docs);
        }, ARRAY_FILTER_USE_KEY);

        

        if ($request->hasFile('requirement_documents')) {
            foreach ($request->file('requirement_documents') as $ind=>$file) {
                if(isset($file) && isset($request->doc_names[$ind])){
                    $name = $request->doc_names[$ind];
                    $document_path[$name] = $file->store('projectDocuments', 'public');
                }
                
            }
        }
      
        // Convert skills string to IDs
        $skills = [];
        $skillList = array_filter(array_map('trim', explode(',', $request->technical_skills)));
        foreach ($skillList as $skill) {
            $skills[] = Skill::where('skill', $skill)->value('id');
        }

        // Prepare update array
        $update = [
            'owner_id' => Auth::user()->id,
            'title' => $request->title,
            'logo' => $logo_path,
            'description' => $request->description,
            'goals' => $request->goals,
            'requirement_documents' => json_encode($document_path),
            'skills_required' => json_encode($skills),
            'project_url' => json_encode([
                'github' => $request->github,
                'trello' => $request->trello
            ]),
            'is_private' => $request->is_private,
            'status'=>$request->status == 'open' ? 0 :($request->status == 'active' ? 1 : ($request->status == 'closed' ? 2 : $project->status)),
        ];

        

        Project::where('id',$id)->update($update);

        return redirect()->route('navMyProject')->with('success','Project updated successfully');
    }

    public function deleteProject(Request $request){
    
        if(Hash::check($request->password,Auth::user()->password)){
            Project::where('id',$request->id)->delete();
            return ['success'=>'Project deleted success fully'];
        }else{
            return ['error','Incorrect password'];
        }
       
    }

}
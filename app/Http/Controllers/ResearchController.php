<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchInformation;
use App\Models\User;
class ResearchController extends Controller
{
    //Registration ng research information
    public function store(Request $request)
    {
        $userId = session('pending_user_id'); // from registration step

        if (!$userId) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        if (ResearchInformation::where('user_ID', $userId)->exists()) {
            return redirect()->route('login')
                ->with('error', 'You have already submitted your research info. Please login.');
        }

        $request->validate([
            'research_title' => 'required|string|max:255',
            'research_college' => 'required|string|max:255',
            'research_department' => 'required|string|max:255',
            'research_Endorsement_letter' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $research = new ResearchInformation();
        $research->research_info_ID = uniqid('rId_');
        $research->user_ID = $userId;
        $research->research_title = $request->research_title;
        $research->research_college = $request->research_college;
        $research->research_department = $request->research_department;

        if ($request->hasFile('research_Endorsement_letter')) {
            // Define folder based on research_info_ID
            $folderPath = 'researchFolder/' . $research->research_info_ID;
            \Storage::makeDirectory($folderPath);

            $file = $request->file('research_Endorsement_letter');

            // Create unique filename: researchID_timestamp.extension
            $filename = $research->research_info_ID . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Store inside storage/app/public/researchFolder/{research_info_ID}/filename
            $path = $file->storeAs($folderPath, $filename, 'public');

            // Save file path in DB
            $research->research_Endorsement_letter = $path;
        }

        $research->save();

        // Clear session once research info is stored
        session()->forget('pending_user_id');

        return redirect()->route('login')->with('success', 'Research info submitted successfully! Please login.');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileSkill;
use Illuminate\Http\Request;

class ProfileSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $profileId
     * @return ProfileSkill
     */
    public function index($profileId)
    {
        return ProfileSkill::where('profile_id', strval($profileId))->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $profileId)
    {
        $request->validate([
            'payload.name' => 'bail|required|max:250',
        ]);
        $skill = new ProfileSkill;
        $skill->name = $request->payload['name'];
        $skill->years = $request->payload['years'];
        $skill->profile_id = $profileId;
        $skill->save();
        return $skill;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfileSkill  $profileSkill
     * @return \Illuminate\Http\Response
     */
    public function show(ProfileSkill $profileSkill)
    {
        return $profileSkill;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProfileSkill $profileSkill
     * @return void
     */
    public function update(Request $request, ProfileSkill $profileSkill)
    {
        return $profileSkill;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($profileId, $skillId)
    {
        return ProfileSkill::destroy($skillId);
    }
}

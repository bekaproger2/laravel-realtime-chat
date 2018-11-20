<?php

namespace App\Services;

use App\Follower;
use App\User;
use App\Project;
use Auth;

class FollowerService {

    public function checkIfProjectFollowerExist(Project $project, Follower $follower)
    {
        return is_null($project->followers->contains($follower)); 
    }

    public function createFollower(int $userId)
    {
        $follower = Follower::create([
            'user_id' => $userId
        ]);

        return $follower;
    }

    public function addProjectFollower(Project $project, User $user)
    {
        $exists = !$this->checkIfProjectFollowerExist($project, $user->follower);
        if(!$exists){
            $follower = $this->createFollower($user->id);
            $project->followers()->save($follower);
        }
    }

    public function getProjectFollowersWhereNotIn(array $usersId)
    {
        $followers = $project->followers()->whereNotIn('user_id', $usersId);

        return $followers;
    }

}
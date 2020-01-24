<?php

namespace App\Http\Controllers\API;

use App\Deployment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DeploymentController extends Controller
{
    public function webhook(Request $request): void
    {
        $branch = $request->json('execution.branch.name');
        if (! in_array($branch, ['master', 'develop'])) {
            return;
        }

        $deployment = new Deployment();

        $deployment->project = $request->json('project.display_name');
        $deployment->pipeline = $request->json('execution.pipeline.name');
        $deployment->branch = $branch;

        $deployment->status = $request->json('execution.status');

        $deployment->invoker = $request->json('invoker.name');
        $deployment->invoker_image = $this->parseAvatarUrl($request->json('invoker.avatar_url'));
        $deployment->committer = $request->json('execution.to_revision.committer.name');

        if ($request->json('execution.to_revision.committer.avatar_url') !== null) {
            $deployment->committer_image = $this->parseAvatarUrl($request->json('execution.to_revision.committer.avatar_url'));
        }

        $deployment->link = $request->json('execution.html_url');

        $deployment->save();
    }

    public function getRecentDeployments()
    {
        return Deployment::query()->latest()->limit(3)->get();
    }

    protected function parseAvatarUrl(string $subject)
    {
        return str_replace('/w/32/32/AVATAR.png', '/w/160/160/AVATAR.png', $subject);
    }
}

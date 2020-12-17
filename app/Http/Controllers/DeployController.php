<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class DeployController extends Controller
{
    public function deploy(Request $request)
    {
        $gitPayload = $request->getContent();
        $gitlabHash = $request->header('X-Gitlab-Token');     
        $localToken = config('app.deploy_secret');
        // $localHash = 'sha1=' . hash_hmac('sha1', $gitPayload, $localToken, false);     
        // if (hash_equals($gitlabHash, $localHash)) {
        if ($gitlabHash === $localToken) {
            $root_path = base_path();
            // $process = new Process('cd ' . $root_path . '; ./deploy.sh');
            // $process->run(function ($type, $buffer) {
            //     echo $buffer;
            // });
            
            chdir($root_path);
            shell_exec('./deploy.sh');
            echo "Ok";
        }
    }

    public function testDeploy()
    {
        echo "[Message] Auto deploy: OK";
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class CheckCandidateSession
{

    public function handle($request, Closure $next)
    {
        //$candidate_id = $request->session()->get('candidate_id');
        //echo $candidate_id;exit;
        if (!$request->session()->exists('candidate_id')) {
            // user value cannot be found in session
            return redirect()->route('candidate_dashboard_login');
        }

        return $next($request);
    }

}

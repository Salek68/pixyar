<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPlan
{
public function handle($request, Closure $next, ...$plans)
    {
       $user = $request->user(); // یا Auth::user()

    if (!$user) {
        abort(403, 'کاربر شناسایی نشد.');
    }

    // آخرین اشتراک فعال
    $subscription = $user->subscriptions()
        ->where('status', 'active')
        ->latest('id')
        ->first();

    if (!$subscription || !in_array($subscription->plan, $plans)) {
        $allowedPlans = implode(' یا ', $plans);
        abort(403, "دسترسی محدود است. فقط پلن $allowedPlans اجازه دسترسی دارد.");
    }

    return $next($request);
    }
}

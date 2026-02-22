<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    public function showplans()
    {
        $plans = Plan::all();
        return view('subscribe.plans', compact('plans'));
    }

    public function checkoutPlan(Plan $plan)
    {
        $user = Auth::user();
        return view('subscribe.checkout', compact('plan', 'user'));
    }

    public function prosesCheckout(Request $request)
    {
        $plan = Plan::findOrFail($request->plan_id);
        $user = Auth::user();

        $user->memberships()->create([
            'plan_id' => $plan->id,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays($plan->duration),
        ]);

        return redirect()->route('subscribe.success');
    }

    public function showSuccess()
    {
        return view('subscribe.success');
    }
}

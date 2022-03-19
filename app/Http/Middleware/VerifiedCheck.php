<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->isVerified) {
            return $next($request);
        } else {
            return redirect()
                ->route('vacations.index')
                ->with('errorMessage', 'متأسفانه هنوز هویت شما توسط مدیر سایت تأیید نشده است... لطفاً صبر کنید و یا با واحد مربوطه تماس بگیرید');
        }
    }
}

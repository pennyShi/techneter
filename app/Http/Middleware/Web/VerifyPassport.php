<?php
namespace App\Http\Middleware\Web;

use Passport;
use Closure;
use Output;
use Request;

class VerifyPassport
{

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(Passport::check())
        {
            return $next($request);
        }else{
            if(Request::ajax())
            {
                return Output::needLogin();
            }else{
                return redirect('/login/qq');
            }
        }
    }

}
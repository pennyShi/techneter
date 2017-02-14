<?php
namespace App\Http\Middleware\Web;

use User;
use Passport;
use Closure;

class VerifyUserinfo
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
        if(!User::getSessionUserinfo())
        {
            $passport = Passport::user();
            if($passport)
            {
                $userInfo = User::getUserInfoByUserPassportId($passport->id);
                User::setSesstionUserinfo($userInfo);
            }else{
                return redirect('/login/qq');
            }
        }

        return $next($request);
    }

}
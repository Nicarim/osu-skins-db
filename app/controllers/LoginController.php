<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 07.04.14
 * Time: 13:29
 */

class LoginController extends BaseController{
    public function loginOAuth(){
        $code = Input::get("code");
        $google = OAuth::consumer("Google");
        if (!empty($code)){

            $token = $google->requestAccessToken($code);
            $userdata = json_decode($google->request("https://www.googleapis.com/oauth2/v1/userinfo"), true);
            $user = User::firstOrNew(
                array(
                    "google_id" => $userdata['id'],
                ));
            $user->name = $userdata['name'];
            $user->email = $userdata['email'];
            $user->refresh_token = $code;
            //$user->access_token = $;
            //dd($token);
            $user->save();
            Auth::loginUsingId($user->id);

            return Redirect::route("Home");
        }
        else{
            $url = $google->getAuthorizationUri();
            return Redirect::to((string) $url);
        }
    }
    public function logoutOAuth(){
        Auth::logout();
        return Redirect::route("Home");
    }

} 
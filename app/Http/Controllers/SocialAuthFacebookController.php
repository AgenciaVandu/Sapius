<?php

namespace App\Http\Controllers;

use Socialite;
use App\Services\SocialFacebookAccountService;

class SocialAuthFacebookController extends Controller
{
  /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
  public function redirect()
  {
      return Socialite::driver('facebook')->redirect();
  }
  /**
   * Return a callback method from facebook api.
   *
   * @return callback URL from facebook
   */
  public function callback(SocialFacebookAccountService $service)
  {
      $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
      //$user = Socialite::driver('facebook')->user();
      auth()->login($user);
      //Enviar correo de contraseña del usuario
      return redirect()->to("/alumno/users/".auth()->user()->id."/complete");
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class thirdPartyLoginController extends Controller
{
   public function redirectingToFacebookLogin(){

   return Socialite::driver('facebook')->redirect();

   }

   public function facebooklanding(){
      $user = Socialite::driver('facebook')->user();
      $create['name'] = $user->getName();
      $create['email'] = $user->getEmail();
      $create['facebook_id'] = $user->getId();
      $userModel = new User;
      $userModel->addNew($created);
      return redirect()->route("landing");
   }
}

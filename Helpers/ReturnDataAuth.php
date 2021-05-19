<?php

    function returnIsLogin(){
        return (auth()->guard('admin')->check() || auth()->guard('seller')->check() || auth()->guard('buyer')->check()) ? 1 : 0;
    }

    function returnDataLogin(){
        if(auth()->guard('admin')->check()){
            return 'admin';
        }
        if(auth()->guard('seller')->check()){
            return 'seller';
        }
        if(auth()->guard('buyer')->check()){
            return 'buyer';
        }
    }

    function returnAuthName($key){
        return auth()->guard($key)->user()->name;
    }

    function returnAuthAvatar($key){
        return auth()->guard($key)->user()->avatar;
    }
?>

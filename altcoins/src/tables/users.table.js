'use strict';

let UsersTable = (function(){ 
    let userLoggedIn = () => {
        var user = JSON.parse(localStorage.getItem('user'));
        if(user){
            if(user.timeStamp && 
            ((new Date(user.timeStamp)).addDays(1)).getTime() > (new Date()).getTime()){
                return true;
            }
            else{
                localStorage.removeItem('user');
                return false;
            }
        }
        return false;
    };

    let loginUser = (user) => {
        localStorage.setItem('user', JSON.stringify(user));
    };

    let logoutUser = () => {
        localStorage.removeItem('user');
    };

    return {
        userLoggedIn: userLoggedIn,
        loginUser: loginUser,
        logoutUser: logoutUser
    }
})();
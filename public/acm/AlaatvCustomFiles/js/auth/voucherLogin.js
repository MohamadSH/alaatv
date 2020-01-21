var loginActionUrl = GlobalJsVar.loginActionUrl(),
    redirectUrl = window.location.href,
    $usernameObject = AjaxLogin.getUsernameObject(),
    $passwordObject = AjaxLogin.getPasswordObject();

AjaxLogin.showLogin(loginActionUrl, redirectUrl);

$('#AlaaAjaxLoginModal').on('hide.bs.modal', function (e) {
    e.preventDefault();
    e.stopPropagation();
    return false;
});

AjaxLogin.changeInputFeedback($usernameObject, message);

$(document).ready(function () {
    $(document).on('click', '.btnShowRiazi', function () {
        $('.a--imageWithCaption.tajrobi').fadeOut();
        $('.a--imageWithCaption.ensani').fadeOut();
        $('.a--imageWithCaption.riazi').fadeIn();
    });
    $(document).on('click', '.btnShowTajrobi', function () {
        $('.a--imageWithCaption.riazi').fadeOut();
        $('.a--imageWithCaption.ensani').fadeOut();
        $('.a--imageWithCaption.tajrobi').fadeIn();
    });
    $(document).on('click', '.btnShowEnsani', function () {
        $('.a--imageWithCaption.riazi').fadeOut();
        $('.a--imageWithCaption.tajrobi').fadeOut();
        $('.a--imageWithCaption.ensani').fadeIn();
    });
    $(document).on('click', '.btnAllMajor', function () {
        $('.a--imageWithCaption.tajrobi').fadeIn();
        $('.a--imageWithCaption.riazi').fadeIn();
    });
});
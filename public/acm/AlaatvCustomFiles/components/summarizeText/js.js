$(document).on('click', '.a--summarize-text .a--summarize-text-toggleBtn', function () {
    $(this).parents('.a--summarize-text').addClass('a--summarize-full-view');
    $(this).fadeOut();
});
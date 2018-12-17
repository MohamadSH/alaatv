var tags = $('#js-var-tags').val();
var extraTags = $('#js-var-extraTags').val();
var actionUrl = [];
actionUrl["content"] = $('#js-var-contentIndexUrl').val();
actionUrl["product"] = $('#js-var-productIndexUrl').val();
actionUrl["contentset"] = $('#js-var-setIndexUrl').val();

$(document).ready(function () {
    initialSlick($(".productSlider"));
    initialPortfolio("#js-grid-juicy-contentset");
    initialPortfolio("#js-grid-juicy-projects");
    /*
        makeGradeSelect($("#majorSelect").val());
        makeLessonSelect( $("#gradeSelect").val());
        makeTeacherSelect();
    */
    // contentLoad("product", ["product"], null, actionUrl["product"], false);
    // contentLoad("contentset", ["contentset"], null, actionUrl["contentset"], false);
    $(".contentPortlet .portlet-title .caption").append(makeTagLabels(tags));
});

/*function makeGradeSelect(majorId) {

    //ToDo : Ajax to get grades of this major
    // console.log(lessons);

    var grades = [];  // ToDo : comes from ajax
    $("#gradeSelect").empty();
    $.each(grades, function (index, value) {
        var caption = "";
        if (value != null && value != undefined)
            caption = value;

        $("#gradeSelect").append($("<option></option>")
            .attr("value", index).text(caption));
    });
}

function makeLessonSelect(gradeId) {

    //ToDo : Ajax to get grades of this major
    // console.log(lessons);

    var lessons = [];  // ToDo : comes from ajax
    $("#lessonSelect").empty();
    $.each(lessons, function (index, value) {
        var caption = "";
        if (value != null && value != undefined)
            caption = value;

        $("#lessonSelect").append($("<option></option>")
            .attr("value", index).text(caption));
    });
}

function makeTeacherSelect() {
    //ToDo
}*/

function makeTagLabels(tags, withInput) {
    var labels = "";
    if (withInput == null || withInput == undefined)
        withInput = false;
    $.each(JSON.parse(tags), function (key, value)  {
        var label = '<span class="tag label label-info tag_' + key + '" style="display: inline-block; margin: 2px; padding: 10px;">';
        label += '<a class="removeTagLabel" data-role="' + key + '" style="padding-left: 10px"><i class="fa fa-remove"></i></a>';
        label += '<span >';
        label += '<a href="' + actionUrl["content"] + '?tags[]=' + value + '"  class="font-white">' + value + '</a>';
        label += '</span>';
        if (withInput) {
            label += '<input id="tagInput_' + key + '" class="extraTag" name="tags[]" type="hidden" value="' + value + '">';
        }
        label += '</span>';

        labels += label
    });
    return labels;
}

function destroySlick(element) {
    element.slick('unslick');
}

function initialSlick(element) {
    element.slick({
        auto: true,
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false
                }
            }
            /*
            You can unslick at a given breakpoint now by adding:
            settings: "unslick"
            instead of a settings object
            */
        ],
        rtl: true
    });
}

function initialPortfolio(className) {
    (
        function ($, window, document, className, undefined) {
            'use strict';

            // init cubeportfolio
            $(className).cubeportfolio({
                // filters: '#js-filters-juicy-projects',
                // loadMore: '#js-loadMore-juicy-projects',
                // loadMoreAction: 'click',
                layoutMode: 'grid',
                defaultFilter: '*',
                animationType: 'quicksand',
                gapHorizontal: 35,
                gapVertical: 30,
                gridAdjustment: 'responsive',
                mediaQueries: [{
                    width: 1500,
                    cols: 4
                }, {
                    width: 1100,
                    cols: 4
                }, {
                    width: 800,
                    cols: 3
                }, {
                    width: 480,
                    cols: 3
                }, {
                    width: 320,
                    cols: 1
                }],
                caption: 'overlayBottomReveal',
                displayType: 'sequentially',
                displayTypeSpeed: 80,

                // lightbox
                lightboxDelegate: '.cbp-lightbox',
                lightboxGallery: true,
                lightboxTitleSrc: 'data-title',
                lightboxCounter: '<div class="cbp-popup-lightbox-counter"> of </div>',

                // singlePage popup
                singlePageDelegate: '.cbp-singlePage',
                singlePageDeeplinking: true,
                singlePageStickyNavigation: true,
                singlePageCounter: '<div class="cbp-popup-singlePage-counter"> of </div>',
                singlePageCallback: function (url, element) {
                    // to update singlePage content use the following method: this.updateSinglePage(yourContent)
                    var t = this;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'html',
                        timeout: 10000
                    })
                        .done(function (result) {
                            t.updateSinglePage(result);
                        })
                        .fail(function () {
                            t.updateSinglePage('AJAX Error! Please refresh the page!');
                        });
                },
            });

        }
    )(jQuery, window, document, className);
}

function contentLoadAjaxRequest(url, formData, type) {
    $.ajax({
        type: "GET",
        cache: true,
        url: url,
        data: formData,
        statusCode:
            {
                200: function (response) {
                    var items = response.items;
                    // tags = response.tagLabels;

                    // location.hash = page;
                    $.each(items, function (key, item) {
                        var totalItems = item.totalitems;
                        switch (type) {
                            case "contentset":
                                // $("#tab_contentset").html(item.view);
                                $("#js-grid-juicy-contentset").cubeportfolio('destroy');
                                $("#tab_contentset").html(item.view);
                                initialPortfolio("#js-grid-juicy-contentset");
                                break;
                            case "content":
                                if (item.type === "video") {
                                    $("#js-grid-juicy-projects").cubeportfolio('destroy');
                                    $("#tab_content_video").html(item.view);
                                    initialPortfolio("#js-grid-juicy-projects");
                                }
                                else if (item.type === "pamphlet") {
                                    $("#tab_content_pamphlet").html(item.view);
                                }
                                else if (item.type === "article") {
                                    if (totalItems > 0) {
                                        $("#tab_content_article").html(item.view);
                                        $("#tab_content_article").show();
                                        $('a[href^="#tab_content_article]').show();
                                    }
                                    else {
                                        $("#tab_content_article").hide();
                                        $('a[href^="#tab_content_article]').hide();
                                    }
                                }
                                break;
                            case "product":
                                if (totalItems > 0) {
                                    $("#productPortlet").show();
                                    var element = $(".productSlider");
                                    destroySlick(element);
                                    $("#productDiv .row .productSlider").html(item.view);
                                    initialSlick(element);
                                }
                                else {
                                    $("#productPortlet").hide();
                                }

                                break;
                            default:
                                break;
                        }
                    });
                    $("#content-search-loading").hide();

                },
                422: function (response) {
                    console.log(response);
                },
                503: function (response) {
                    console.log(response);
                }
            }
    });
}

function contentLoad(itemType, pageName, pageNumber, url, setTagLabel) {
    var formData = "";

    var extraTags = [];
    var tags = [];
    $("#itemFilterForm").find(':not(input[name=_token])').filter(':input').each(function () {
        var elementId = $(this).attr("id");
        var element = $("#" + elementId);

        if (element.hasClass("extraTag")) {
            var extraTagText = element.val();
            formData += "tags[]=" + extraTagText + "&";
            extraTags.push(extraTagText);
            tags.push(extraTagText);
        }
        else if ($("#" + elementId + " option:selected").val() != '') {
            var selectedText = $("#" + elementId + " option:selected").text();
            var tagText = string_to_slug(selectedText);
            formData += "tags[]=" + tagText + "&";
            tags.push(tagText);
        }
    });

    formData = formData.slice(0, -1);
    if (setTagLabel) {
        $(".tag").remove();
        $(".contentPortlet .portlet-title .caption").append(makeTagLabels(tags));
        $("#itemFilterFormBody").append(makeTagLabels(extraTags, true));
    }
    var addressBarAppend = formData;
    $.each(pageName, function (key, value) {
        if (pageNumber != undefined && pageNumber > 0) {
            var numberQuery;
            numberQuery = [pageName + "Page=" + pageNumber];
            formData = formData + "&" + numberQuery.join('&');
        } else {
            $("#content-search-loading").show();
        }

        if (value != undefined && value.length > 0) {
            var typesQuery = ["contentType[]=" + value];
            formData = formData + "&" + typesQuery.join('&');
        }
    });

    formData = decodeURIComponent(formData);
    changeUrl(addressBarAppend);

    if (itemType === "video" || itemType === "pamphlet" || itemType === "article")
        itemType = "content";
    // console.log(formData);
    contentLoadAjaxRequest(url, formData, itemType, setTagLabel);
    return false;
}

function changeUrl(appendUrl) {
    var newUrl = actionUrl["content"] + "?" + appendUrl;
    window.history.pushState({formData: appendUrl}, "Title", newUrl);
    document.title = newUrl;
}

$(window).on("popstate", function (e) {
    window.location.reload();
});

$(document).on('click', '.pagination a', function (e) {
    var query = $(this).attr('href').split('?')[1];
    var parameters = query.split('=');
    var pageName = parameters[0];
    var pageNumber = parameters[1];
    parameters = pageName.split('Page');
    var itemType = parameters[0];

    contentLoad(itemType, [itemType], pageNumber, actionUrl[itemType], false);
    e.preventDefault();
});

/*
$(document).on("change", "#gradeSelect", function (){
    tags.push($("#gradeSelect option:selected").val());
});

$(document).on("change", "#majorSelect", function (){
    tags.push($("#majorSelect option:selected").val());
    makeLessonSelect();
});

$(document).on("change", "#lessonSelect", function (){
    tags.push($("#lessonSelect option:selected").val());
    makeTeacherSelect();
});

$(document).on("change", "#teacherSelect", function (){
    tags.push($("#teacherSelect option:selected").val());
});
*/

$(document).on("change", ".itemFilter", function () {
    contentLoad("content", ["video", "pamphlet", "article"], null, actionUrl["content"], true);
    contentLoad("product", ["product"], null, actionUrl["product"], true);
    contentLoad("contentset", ["contentset"], null, actionUrl["contentset"], true);
});

$(document).on("click", ".removeTagLabel", function () {
    var id = $(this).data("role");
    $(".tag_" + id).remove();
    tags.splice(id, 1);
    var elements = [
        "gradeSelect",
        "majorSelect",
        "lessonSelect",
        "teacherSelect"
    ];


    $.each(elements, function (key, value) {
        $("#" + value).each(function () {
            var selectedText = $("#" + value + " option:selected").text();
            var slugifiedSelectedText = string_to_slug(selectedText);
            if ($.inArray(slugifiedSelectedText, tags) == -1) {
                $("#" + value).val($("#" + value + " option:first").val());
            }
        });
    });

    contentLoad("content", ["video", "pamphlet", "article"], null, actionUrl["content"], true);
    contentLoad("product", ["product"], null, actionUrl["product"], true);
    contentLoad("contentset", ["contentset"], null, actionUrl["contentset"], true);
});

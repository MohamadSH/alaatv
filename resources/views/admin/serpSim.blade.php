
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115256947-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-115256947-1');
    </script>
    <!-- Repixel Code -->
    <script>
        (function(w, d, s, id, src){
            w.Repixel = r = {
                init: function(id) {
                    w.repixelId = id;
                }
            };
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)){ return; }
            js = d.createElement(s);
            js.id = id;
            js.async = true;
            js.onload = function(){
                Repixel.init(w.repixelId);
            };
            js.src = src;
            fjs.parentNode.insertBefore(js, fjs);
        }(window, document, 'script', 'repixel',
            'https://sdk.repixel.co/r.js'));
        Repixel.init('5d8bb4bad04fe20008d533a8');
    </script>
    <!-- Repixel Code -->
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2010091775960303');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=2010091775960303&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
    <title>SERP Simulator - SEO Title & Meta Description Tool 2019 | SERPsim</title>
    <meta charset="UTF-8">
    <meta name="description" content="Tired of inaccurate and outdated SERP snippet generators? SERPsim is based on the very latest google pixel limits and is a full fledged SERP simulator. Try it!" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <script src="https://serpsim.com/js/jquery-3.3.1.min.js"></script>
    <script defer src="https://serpsim.com/js/material.min.js"></script>
    <script defer src="https://serpsim.com/js/html2canvas.min.js"></script>
    <!--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" type="text/css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://serpsim.com/css/serpsim.css">

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ['Roboto:400,500']
            }
        });
    </script>
</head>

<body>
<div id="logo_div">
    <div id="logo_box">
        <span class="helper"></span>
        <a href="/"><img id="serpsim_logo" src="https://serpsim.com/img/serpsim_logo_new.svg" alt="SERPsim - The most accurate SERP snippet generator & SERP simulator!" /></a>
    </div>
    <div id="banner_box">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- serpsimulator top 728x90 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-5643559973451550"
             data-ad-slot="4996233742"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</div>

<div id="p1" class="mdl-progress mdl-js-progress"></div>
<div id="input_div">
    <div id="banner_box_side">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- serpsim side ad 160x600 -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:160px;height:600px"
             data-ad-client="ca-pub-5643559973451550"
             data-ad-slot="7982041079"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <div id="banner_box_side_right">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- serpsim right side ad -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:160px;height:600px"
             data-ad-client="ca-pub-5643559973451550"
             data-ad-slot="2821557237"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

    <input id="snippet_id" type="hidden">
    <div class="input_row">
        <div class="label_div">
            <span class="input_label">Fetch</span>
        </div>
        <div class="field_div">
            <input id="ext_url" class="serp_input input_file" type="text" placeholder="Enter single URL or paste multiple URLs to fetch data from..." autocapitalize="none"> <button id="fetch_url" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Fetch</button> <span id="ext_url_status"><div class="mdl-spinner mdl-js-spinner is-active"></div></span>
        </div>
    </div>
    <div class="input_row">
        <div class="label_div">
            <span class="input_label">Title</span><span id="title_length_mobile" class="counter_mobile">(0px / 585px)</span>
        </div>
        <div class="field_div">
            <input id="title_text" class="serp_input" type="text" placeholder="Enter a title..."> <div class="counter_div"><span id="title_length">(0px / 573px)</span></div>
        </div>
    </div>
    <div class="input_row">
        <div class="label_div">
            <span class="input_label">URL</span><span id="url_length_mobile" class="counter_mobile">(0px / 536px)</span>
        </div>
        <div class="field_div">
            <input id="url" class="serp_input" type="text" placeholder="Enter a url..." autocapitalize="none"> <div class="counter_div"><span id="url_length">(0px / 585px)</span></div>
        </div>
    </div>
    <div class="input_row">
        <div class="label_div">
            <span class="input_label">META</span><span id="meta_desc_length_mobile" class="counter_mobile">(0px / 930px)</span>
        </div>
        <div class="field_div">
            <textarea id="meta_desc" class="serp_input" placeholder="Enter a META description..."></textarea> <div class="counter_div"><span id="meta_desc_length">(0px / 930px)</span></div>
        </div>
    </div>
    <div class="input_row">
        <div class="label_div">
            <span class="input_label">Options</span>
        </div>
        <div class="field_div">
            <input id="show_rich" class="show_box" type="checkbox" /> Rich snippet
            <br>
            <input id="show_date" class="show_box" type="checkbox" /> Date
            <br>
            <input id="show_cached" class="show_box" type="checkbox" /> Cached
            <input id="show_mobile" class="show_box" type="checkbox" style="display: none;"/>
        </div>
    </div>
</div>
<div id="serp_preview">
    <div id="top_bar">
        <img src="https://serpsim.com/img/google_logo.svg" id="google_logo" alt="Google Logo"/> <div id="search_div"><div id="search_input" contenteditable="true"></div><div id="search_categories"><div class="search_cat_active">All</div><div class="search_cat" style="margin-left: 50px;">Images</div><div class="search_cat">Videos</div><div class="search_cat">News</div><div class="search_cat">Maps</div><div class="search_cat">More</div><div class="mode_cat" id="mode_mobile"><i class="material-icons">phone_iphone</i><span style="display:block; font-size: 10px;">Mobile</span></div><div class="mode_cat" style="padding-left: 0px;" id="mode_desktop"><i class="material-icons mode_active">desktop_windows</i><span style="display:block; font-size: 10px;">Desktop</span></div></div></div>
    </div>
    <div id="serp_result">
        <span id="serp_title"></span><br>
        <span id="serp_url"></span><div class="arrow_container"><span class="down_arrow"></span></div><br>
        <div id="rich_div"><span id="serp_rich"><img id="score_stars" src="https://serpsim.com/img/stars.png" alt="Rating stars">Rating: 9,7/10 - 112 votes</span></div>
        <span id="serp_meta"></span>
    </div>
    <div id="serp_result_mobile" style="display: none; background-color: #fff;margin-bottom: 10px;font-size: 14px;line-height: 20px;box-shadow: 0 1px 6px rgba(32, 33, 36, 0.28);border-radius: 8px; width: 359px; margin: 0 auto; margin-top: 50px;">
        <div id="serp_favdiv_mobile" style="font-size: 14px;line-height: 20px;color: #202124;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;padding-top: 13px;display: block; padding-left: 16px; padding-right: 16px;">
            <img id="serp_favicon_mobile" style="margin-right: 12px;vertical-align: middle;width: 16px;height: 16px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABs0lEQVR4AWL4//8/RRjO8Iucx+noO0MWUDo16FYABMGP6ZfUcRnWtm27jVPbtm3bttuH2t3eFPcY9pLz7NxiLjCyVd87pKnHyqXyxtCs8APd0rnyxiu4qSeA3QEDrAwBDrT1s1Rc/OrjLZwqVmOSu6+Lamcpp2KKMA9PH1BYXMe1mUP5qotvXTywsOEEYHXxrY+3cqk6TMkYpNr2FeoY3KIr0RPtn9wQ2unlA+GMkRw6+9TFw4YTwDUzx/JVvARj9KaedXRO8P5B1Du2S32smzqUrcKGEyA+uAgQjKX7zf0boWHGfn71jIKj2689gxp7OAGShNcBUmLMPVjZuiKcA2vuWHHDCQxMCz629kXAIU4ApY15QwggAFbfOP9DhgBJ+nWVJ1AZAfICAj1pAlY6hCADZnveQf7bQIwzVONGJonhLIlS9gr5mFg44Xd+4S3XHoGNPdJl1INIwKyEgHckEhgTe1bGiFY9GSFBYUwLh1IkiJUbY407E7syBSFxKTszEoiE/YdrgCEayDmtaJwCI9uu8TKMuZSVfSa4BpGgzvomBR/INhLGzrqDotp01ZR8pn/1L0JN9d9XNyx0AAAAAElFTkSuQmCC">
            <span id="serp_favcrumbs_mobile" style="color: #3C4043;white-space: nowrap;font-size: 12px;font-family: Roboto,HelveticaNeue,Arial,sans-serif !important;font-weight: inherit;line-height: 20px;"></span>
        </div>
        <div id="serp_title_mobile" style="width: 343px; word-wrap: break-word; font-size: 16px; line-height: 20px; padding-top: 12px; padding-left: 16px; padding-right: 16px; Roboto,HelveticaNeue,Arial,sans-serif !important; color: #1967D2;"></div>
        <div id="serp_meta_mobile" style="width: 327px; word-wrap: break-word; font-size: 14px; line-height: 20px; padding-top: 12px; padding-left: 16px; padding-right: 16px; padding-bottom: 12px; Roboto,HelveticaNeue,Arial,sans-serif !important; color: #3C4043"></div>
        <div id="rich_div_mobile" style="margin-top: -4px; width: 327px; word-wrap: break-word; font-size: 14px; line-height: 20px; padding-left: 16px; padding-right: 16px; padding-bottom: 12px;">
            <div id="rating_mobile" style="font-size: 14px; line-height: 20px; font-family: Roboto,HelveticaNeue,Arial,sans-serif; color: #202124;">Rating</div>
            <div id="score_mobile" style="margin-top: 5px; font-size: 14px; line-height: 20px; font-family: Roboto,HelveticaNeue,Arial,sans-serif; color: #70757A;">9,2/10 <img id="score_stars_mobile" src="https://serpsim.com/img/stars_mobile.png" alt="Rating stars" style="margin-top: -3px;"> (19)</div>
        </div>
    </div>
    <div id="serp_button_div">
        <div class="button_div">
            <button id="share" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                SHARE
            </button>
            <button id="copy" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                COPY
            </button>
            <button id="clear" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                CLEAR
            </button>
            <button id="save_snippet" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                SAVE
            </button>
            <button id="save_image" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                IMAGE
            </button>
        </div>
    </div>
</div>
<div id="list_container">
    <div id="snippet_container">
        <div id="snippet_list_header">
            Saved snippets (Click row to edit)
            <div id="filter_div"><input type="checkbox" id="filter_snippet"> Only show truncated snippets</div>
        </div>
    </div>
    <button id="copy_snippets" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored copy mdl-snackbar__action">
        <i class="material-icons">content_copy</i>
    </button>
    <div class="mdl-tooltip" data-mdl-for="copy_snippets">
        Copy all snippets to clipboard
    </div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>
<div id="body_text">
    <h1>SERPsim - the most accurate SERP snippet generator and SERP simulator optimization tool</h1>
    With its pixel perfect precision SERPsim is the most accurate SERP snippet generator and SERP simulator you will ever find! Fetch title and meta description from an existing url or create new ones from scratch. Following the very latest Google updates 2019 SERPsim will always keep you within the current pixel length limit and alert you of any important issues. With SERPsim you can share, save and copy a single snippet or multiple in bulk! All these features combined makes SERPsim an unprecedented google snippet tool which is totally free and hopefully loved by SEO specialists and webmasters alike - all across the world! While we are trying to make the previews as accurate as possible the information on this website is provided "as is" without any representations or warranties, express or implied.</div>
<div id="disclaimer">© 2019 SERPsim.com. Google and the Google logo are registered trademarks of Google LLC. <button class="mdl-button mdl-js-button mdl-button--icon"><a href="mailto:feedback@serpsim.com" id="mail_link"><i class="material-icons">mail_outline</i></a></button>
    <div class="mdl-tooltip" data-mdl-for="mail_link">
        Click to mail us at feedback@serpsim.com
    </div>
</div>

<textarea id="clipboard_data"></textarea>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            // Disable caching of AJAX responses
            cache: false,
        });

        $.fn.textWidth = function(text, font) {
            //if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
            if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span style="left: -500%; max-width: 1500px;">').hide().appendTo(document.body);
            $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
            return $.fn.textWidth.fakeEl.width();
        };

        var max_length_title_dt = 573;
        var max_length_url_dt = 536;
        var max_length_meta_dt = 930;

        var max_length_title_mb = 550;
        var max_length_url_mb = 327;
        var max_length_meta_mb = 905; //720

        var max_length_title = max_length_title_dt;
        var max_length_url = max_length_url_dt;
        var max_length_meta = max_length_meta_dt;

        var title_font_dt = '20px arial';
        var url_font_dt = '16px arial';
        var meta_font_dt = '14px arial';

        var title_font_mb = '16px Roboto';
        var url_font_mb = '14px Roboto';
        var meta_font_mb = '14px Roboto';

        var title_font = title_font_dt;
        var url_font = url_font_dt;
        var meta_font = meta_font_dt;

        $("#save_image").click(function() {
            if($("#serp_title").text() != "" && $("#serp_url").text() != "" && $("#serp_meta").text() != "") {
                DownloadAsImage();
                gtag('event', 'Image', {'event_category' : 'Button click', 'event_label' : $("#serp_url").text()});
            }
            else {
                var data = {
                    message: 'No snippet available!',
                    timeout: 3000
                };
                document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);

            }
        });

        function downloadURI(uri, name) {
            var link = document.createElement("a");
            link.download = name;
            link.href = uri;
            document.body.appendChild(link);
            link.click();
            link.remove();
        }

        function DownloadAsImage() {
            var element = $("#serp_result")[0];
            if($("#show_mobile").prop('checked')) {
                element = $("#serp_result_mobile")[0];
            }
            html2canvas(element).then(function (canvas) {
                var myImage = canvas.toDataURL('image/png', 1.0);
                downloadURI(myImage, "serpsim_snapshot.png");
            });
        }

        function setSERPMode(mode) {
            //console.log('SERP Mode = ' + mode);
            if(mode === 'mobile') {
                $(".mode_active").removeClass('mode_active');
                $("#mode_mobile").addClass('mode_active');
                $("#show_mobile").prop('checked', true);
                $("#serp_result").hide();
                $("#serp_result_mobile").show();
                title_font = title_font_mb;
                url_font = url_font_mb;
                meta_font = meta_font_mb;
                max_length_title = max_length_title_mb;
                max_length_url = max_length_url_mb;
                max_length_meta = max_length_meta_mb;
                $("#title_text").trigger('keyup');
                $("#url").trigger('keyup');
                $("#meta_desc").trigger('keyup');
            }
            else if(mode === 'desktop') {
                $(".mode_active").removeClass('mode_active');
                $("#mode_desktop").addClass('mode_active');
                $("#show_mobile").prop('checked', false);
                $("#serp_result_mobile").hide();
                $("#serp_result").show();
                title_font = title_font_dt;
                url_font = url_font_dt;
                meta_font = meta_font_dt;
                max_length_title = max_length_title_dt;
                max_length_url = max_length_url_dt;
                max_length_meta = max_length_meta_dt;
                $("#title_text").trigger('keyup');
                $("#url").trigger('keyup');
                $("#meta_desc").trigger('keyup');
            }
        }

        function isURL(str) {
            regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
            if (regexp.test(str)) {
                return true;
            }
            else {
                return false;
            }
        }

        function mobileURL(url) {
            if(url.length > 7 && url.includes('/')) {
                if(url.endsWith('/')) {
                    url = url.slice(0, -1);
                }
                exp = url.split(/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?/);
                prefix_string = exp[2]+':'+exp[3];
                path = exp[5].replace(/\//g, ' › ');
                if(path === ' > ') {
                    path = '';
                }
                if(url.startsWith('https://')) {
                    return(prefix_string + path);
                }
                else {
                    return(exp[4] + path);
                }
            }
        }

        function stripTrailingSlash(str) {
            if(str.substr(-1) === '/') {
                return str.substr(0, str.length - 1);
            }
            return str;
        }

        function extractDomain(url) {
            var domain;
            if (url.indexOf("://") > -1) {
                domain = url.split('/')[2];
            }
            else {
                domain = url.split('/')[0];
            }

            if (domain.indexOf("www.") > -1) {
                domain = domain.split('www.')[1];
            }

            domain = domain.split(':')[0]; //find & remove port number
            domain = domain.split('?')[0]; //find & remove url params

            return domain;
        }

        function arrowNavigation(element, event) {
            switch (event.which) {
                case 38: //UP
                    element.parent().parent().prev().find('.serp_input:first').focus();
                    break;
                case 40: //DOWN
                    element.parent().parent().next().find('.serp_input:first').focus();
                    break;
            }
        }

        function substringPixels(phrase, limit, font) {
            pixel_width = 0;
            for(var i = 0, c = ''; c = phrase.charAt(i); i++){
                if(pixel_width + $.fn.textWidth(c, font) > limit) {
                    return phrase.substring(0, i);
                    break;
                }
                else {
                    pixel_width = pixel_width + $.fn.textWidth(c, font);
                }
            }
            return phrase;
        }

        function truncateUrlMobile(url) {
            suffix_length = $.fn.textWidth('...', url_font);
            allowed_length =  max_length_url - suffix_length;
            surl = url;
            for(var i = 0; surl = surl.substring(0, surl.length - 1); i++) {
                //console.log(surl + "(" + $.fn.textWidth(surl, url_font) + ")");
                if($.fn.textWidth(surl, url_font) <= allowed_length) {
                    return surl + '...';
                    break;
                }
                else {
                }
            }
        }

        function truncateUrl(url) {
            exp = url.split(/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?/);
            prefix_string = exp[2]+':'+exp[3];
            prefix = $.fn.textWidth(prefix_string, url_font);
            path = exp[5].split("/");
            last_part = '/' + path[path.length-1];
            if(last_part == '/') {
                last_part = '/' + path[path.length-2]+'/';
            }
            last_part_pixels = $.fn.textWidth(last_part, url_font);
            fit_last = true;
            offset = 0;
            if($("#show_cached").prop('checked')) {
                offset = 54;
            }
            remains = max_length_url - prefix - last_part_pixels - offset - 32;
            suffix = "";
            if(remains < 0) {
                suffix = '/...' + substringPixels(last_part, last_part_pixels + remains, url_font) + ' ...';
            }
            else if (remains < 15.52) {
                pre_suffix = "";
                if(substringPixels(exp[5], remains) != "") {
                    pre_suffix = substringPixels(exp[5], remains, url_font);
                }
                else {
                    pre_suffix = "/";
                }
                suffix = pre_suffix + '...' + substringPixels(last_part, last_part_pixels + remains, url_font) + ' ...';
            }
            else {
                suffix = substringPixels(exp[5], remains, url_font) + '...' + last_part;
            }
            return prefix_string + suffix;
        }

        function truncateString(text, length) {
            if(text.length >= length) {
                return text.substring(0,length-3) + '...';
            }
            else {
                return text;
            }
        }

        function uncheckBoxes() {
            $(".show_box").each(function() {
                if($(this).prop('checked') === true && $(this).attr('id') !== 'show_mobile') {
                    $(this).trigger('click');
                }
            });
        }

        function clearInput() {
            $("#ext_url").val('').trigger('keyup');
            $("#title_text").val('').trigger('keyup');
            $("#url").val('').trigger('keyup');
            $("#meta_desc").val('').trigger('keyup');
            $("#snippet_id").val('');
            $(".active_snippet").removeClass('active_snippet');
            $("#serp_favicon_mobile").attr('src', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABs0lEQVR4AWL4//8/RRjO8Iucx+noO0MWUDo16FYABMGP6ZfUcRnWtm27jVPbtm3bttuH2t3eFPcY9pLz7NxiLjCyVd87pKnHyqXyxtCs8APd0rnyxiu4qSeA3QEDrAwBDrT1s1Rc/OrjLZwqVmOSu6+Lamcpp2KKMA9PH1BYXMe1mUP5qotvXTywsOEEYHXxrY+3cqk6TMkYpNr2FeoY3KIr0RPtn9wQ2unlA+GMkRw6+9TFw4YTwDUzx/JVvARj9KaedXRO8P5B1Du2S32smzqUrcKGEyA+uAgQjKX7zf0boWHGfn71jIKj2689gxp7OAGShNcBUmLMPVjZuiKcA2vuWHHDCQxMCz629kXAIU4ApY15QwggAFbfOP9DhgBJ+nWVJ1AZAfICAj1pAlY6hCADZnveQf7bQIwzVONGJonhLIlS9gr5mFg44Xd+4S3XHoGNPdJl1INIwKyEgHckEhgTe1bGiFY9GSFBYUwLh1IkiJUbY407E7syBSFxKTszEoiE/YdrgCEayDmtaJwCI9uu8TKMuZSVfSa4BpGgzvomBR/INhLGzrqDotp01ZR8pn/1L0JN9d9XNyx0AAAAAElFTkSuQmCC');
            uncheckBoxes();
        }

        function fillClipboard() {
            var clipboard_data = "";
            $(".snippet_list").filter(":visible").each(function(i) {
                clipboard_data += $(this).attr("data-serp-title") + "\t" + $(this).attr("data-serp-url") + "\t" + $(this).attr("data-serp-meta") + "\r\n";
            });
            $("#clipboard_data").val(clipboard_data);
        }

        function loadSnippet(snippet) {
            if(snippet.hasClass('error')) {
                snippet.removeClass('error');
                snippet.addClass('had_error');
            }
            snippet.addClass('active_snippet');
            snippet.find('.saved_title:first').addClass('active_snippet');
            snippet.find('.saved_url:first').addClass('active_snippet');
            snippet.find('.delete_snippet:first').addClass('active_snippet');
            snippet.find('.snippet_number:first').addClass('active_snippet');
            $("#title_text").val(snippet.attr('data-serp-title')).trigger('keyup');
            $("#url").val(snippet.attr('data-serp-url')).trigger('keyup');
            $("#meta_desc").val(snippet.attr('data-serp-meta')).trigger('keyup');
            $("#snippet_id").val(snippet.attr('data-snippet-id'));
            document.querySelector('#logo_div').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function calcNumbers() {
            var snippCount = $(".snippet_list").length;
            $(".snippet_list").each(function(i) {
                currNo = parseInt(snippCount) - parseInt(i);
                $(this).attr('data-list-number', currNo);
                if(currNo%2===0){
                    $(this).addClass('evenDiv');
                }
                else {
                    $(this).removeClass('evenDiv');
                }
                $(".snippet_number", this).html(currNo + '.');
            });
        }

        $("#filter_snippet").click(function() {
            if($(this).prop("checked")) {
                $(".snippet_list").hide();
                $(".snippet_list.error").show();
                $(".snippet_list.had_error").show();
            }
            else {
                $(".snippet_list").show();
            }
        });

        //SHARE BUTTON
        $("#share").click(function() {
            if ($(".snippet_list").length == 0 && ($("#serp_title").text() == '' && $("#serp_url").text() == '' && $("#serp_meta").text() == '')) {
                var data = {
                    message: 'Nothing to share',
                    timeout: 2000
                };
                document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
            }
            else {
                if($(".snippet_list").length == 0 && ($("#serp_title").text() != '' && $("#serp_url").text() !='' && $("#serp_meta").text() !='')) {
                    $("#save_snippet").trigger('click');
                }
                serpsim_url = window.location.href;
                $("#clipboard_data").val(serpsim_url);

                var data = {
                    message: 'Project-URL copied to clipboard',
                    timeout: 4000
                };

                var tempInput = document.createElement("textarea");
                tempInput.style = "position: absolute; left: -1000px; top: -1000px";
                tempInput.value = $("#clipboard_data").val();
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                gtag('event', 'Share', {'event_category' : 'Snippet', 'event_label' : serpsim_url});
            }
        });

        //COPY BUTTON SMALL
        $("#copy").click(function(){
            if($(".snippet_list").filter(":visible").length > 0) {
                $(".copy").trigger("click");
            }
            else {
                clipboard_data = $("#title_text").val() + "\t" + $("#url").val() + "\t" + $("#meta_desc").val() + "\r\n";
                $("#clipboard_data").val(clipboard_data);

                var data = {
                    message: 'Snippet copied to clipboard.',
                    timeout: 2000
                };

                var tempInput = document.createElement("textarea");
                tempInput.style = "position: absolute; left: -1000px; top: -1000px";
                tempInput.value = $("#clipboard_data").val();
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
            }
        });

        //CLEAR BUTTON
        $("#clear").click(function(){
            clearInput();
        });

        //COPY BUTTON
        $(document).on("click", ".copy", function() {
            fillClipboard();
            var data = {
                message: $(".snippet_list").filter(":visible").length + ' snippets copied to clipboard.',
                timeout: 2000
            };
            var tempInput = document.createElement("textarea");
            tempInput.style = "position: absolute; left: -1000px; top: -1000px";
            tempInput.value = $("#clipboard_data").val();
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
        });

        //ENTER KEY in EXT URL
        $("#ext_url").keyup(function(e){
            arrowNavigation($(this), e);
            if(e.keyCode == 13){
                $("#fetch_url").trigger('click');
            }
        });


        //SAVE SNIPPET
        $("#save_snippet").click(function() {
            if($("#serp_title").text() != '' && $("#serp_url").text() !='' && $("#serp_meta").text() !='') {
                $("#serp_result").addClass('fadeOutDown');
                setTimeout(function () {
                    $("#serp_result").removeClass('fadeOutDown');
                    if($("#snippet_id").val() == '' || $(".snippet_list[data-snippet-id='" + $("#snippet_id").val() + "']").length === 0) {
                        $('<div class="snippet_list" data-snippet-id="' + Date.now() + Math.random() + '" data-serp-title="' + $("#title_text").val() +  '" data-serp-url="' + $("#url").val() + '" data-serp-meta="' + $("#meta_desc").val() + '" data-list-number="' + (parseInt($(".snippet_list").length) + 1) + '"><div class="snippet_number">' + ($(".snippet_list").length + 1) + '.</div><div class="snippet_text"><span class="saved_title">' + truncateString($("#serp_title").text(), 65) + '</span><span class="saved_url">' + truncateString($("#serp_url").text(), 80) + '</span></div><div class="snippet_options"><i class="material-icons delete_snippet">clear</i></div>').insertAfter($("#snippet_list_header"));
                        if($(".snippet_list").length%2===0){
                            $(".snippet_list:first").addClass('evenDiv');
                        }
                    }
                    else {
                        if($.fn.textWidth($("#title_text").val(), title_font) <= max_length_title && $.fn.textWidth($("#meta_desc").val(), meta_font) <= max_length_meta) {
                            $(".snippet_list[data-snippet-id='" + $("#snippet_id").val() + "']").removeClass('error').removeClass('had_error');
                        }
                        else {
                            $(".snippet_list[data-snippet-id='" + $("#snippet_id").val() + "']").addClass('error');
                        }

                        $(".snippet_list[data-snippet-id='" + $("#snippet_id").val()  + "']").attr("data-serp-title", $("#title_text").val()).attr("data-serp-url", $("#url").val()).attr("data-serp-meta", $("#meta_desc").val());
                        $(".snippet_list[data-snippet-id='" + $("#snippet_id").val()  + "']").find(".saved_title:first").html(truncateString($("#serp_title").text(), 65));
                        $(".snippet_list[data-snippet-id='" + $("#snippet_id").val()  + "']").find(".saved_url:first").html(truncateString($("#serp_url").text(), 80));
                    }

                    extra_snippets = [];
                    $(".snippet_list").each(function(i) {
                        extra_snippets[i] = [$(this).attr("data-list-number"), $(this).attr("data-snippet-id"), $(this).attr("data-serp-title"), $(this).attr("data-serp-url"), $(this).attr("data-serp-meta")];
                    });

                    slug = window.location.pathname.replace(/\//g, '');
                    if(slug) {
                        $.post("https://serpsim.com/process_serpsim", {action:'update', title:$("#title_text").val(), url:$("#url").val(), meta:$("#meta_desc").val(), extra:extra_snippets, slug:slug});
                        gtag('event', 'Update', {'event_category' : 'Button click', 'event_label' : slug});
                    }
                    else {
                        $.post("https://serpsim.com/process_serpsim", {action:'save', title:$("#title_text").val(), url:$("#url").val(), meta:$("#meta_desc").val(), extra:extra_snippets}).done(function(json) {
                            history.replaceState({}, 'Serpsim', "/" + $.parseJSON(json).slug + "/");
                            slug = $.parseJSON(json).slug;
                            gtag('event', 'Save', {'event_category' : 'Button click', 'event_label' : slug});
                        });
                    }

                    $("#list_container").show();
                    var data = {
                        message: 'Snippet saved.',
                        timeout: 2000
                    };
                    document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                    clearInput();
                }, 1000);
            }
            else {
                var data = {
                    message: 'Missing data, unable to save.',
                    timeout: 2000
                };
                document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
            }

        });

        //RICH SNIPPET
        $("#show_rich").click(function() {
            $("#rich_div_mobile").toggle();
            $("#rich_div").toggle();
        });

        //SHOW DATE
        $("#show_date").click(function() {
            var date_string = '24 Dec, 2019 - ';
            var elm_id = 'serp_meta';
            if($("#show_mobile").prop('checked')) {
                date_string = '24 Dec 2019 · ';
                elm_id = 'serp_meta_mobile';
            }
            if($("#show_date").prop('checked')) {
                $("#meta_desc").trigger('keyup');
                $("#" + elm_id).prepend('<span id="rich_date">' + date_string + '</span>');
            }
            else {
                $("#" + elm_id).html($("#serp_meta").html().replace(date_string, ''));
                $("#meta_desc").trigger('keyup');
            }
        });

        //SHOW CACHED
        $("#show_cached").click(function() {
            if($(".arrow_container").css('display') == 'none') {
                $(".arrow_container").css('display', 'inline');
                $("#serp_url_mobile").prepend('<img src="/img/amp_logo.png" alt="AMP logo" style="margin-right: 6px; margin-top: -1px;"/>');
            }
            else {
                $("#serp_url_mobile").text($("#serp_url_mobile").text().replace('<img src="/img/amp_logo.png" alt="AMP logo" style="margin-right: 6px; margin-top: -1px;"/>', ''));
                //console.log($("#serp_url_mobile").text());
                $(".arrow_container").css('display', 'none');
                $("#url").trigger('keyup');
            }
        });

        //MODE MOBILE
        $("#mode_mobile").click(function() {
            setSERPMode('mobile');
        });

        //MODE DESKTOP
        $("#mode_desktop").click(function() {
            setSERPMode('desktop');
        });

        //DELETE SNIPPET
        $(document).on("click", ".delete_snippet", function() {
            $(this).closest('.snippet_list').remove();
            calcNumbers();
            if($(".snippet_list").length == 0) {
                $("#list_container").hide();
            }
            var data = {
                message: 'Snippet removed.',
                timeout: 2000
            };
            slug = window.location.pathname.replace(/\//g, '');
            extra_snippets = [];
            $(".snippet_list").each(function(i) {
                extra_snippets[i] = [$(this).attr("data-list-number"), $(this).attr("data-snippet-id"), $(this).attr("data-serp-title"), $(this).attr("data-serp-url"), $(this).attr("data-serp-meta")];
            });
            $.post("https://serpsim.com/process_serpsim", {action:'update', title:$("#title_text").val(), url:$("#url").val(), meta:$("#meta_desc").val(), extra:extra_snippets, slug:slug}).done(function() {
                document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
            });
            if($(".snippet_list").length == 0) {
                $("#list_container").hide();

            }
        });

        //LOAD SNIPPET
        $(document).on("click", ".snippet_text", function() {
            $(".had_error").each(function() {
                $(this).addClass('error').removeClass('had_error');
            });
            clearInput();
            loadSnippet($(this).closest('.snippet_list'));
        });

        //Bind eventhandler to progressbar
        document.getElementById('p1').addEventListener('mdl-componentupgraded', function() {
            document.getElementById('p1').MaterialProgress.setProgress(0);
        });

        //EXT URL
        $("#ext_url").bind('paste', function() {
            setTimeout(function(){
                var paste_list = $("#ext_url").val();
                arrURLs = paste_list.split(" ");
                if(arrURLs.length<2) {
                    return;
                }
                containsErr = false;
                invalidData = "";
                for(let i=0, size=arrURLs.length; i<size; i++){
                    if(!isURL(arrURLs[i])) {
                        invalidData = arrURLs[i];
                        containsErr = true;
                        break;
                    }
                }
                if(containsErr){ //INVALID DATA
                    var data = {
                        message: 'Data pasted contained invalid url data ("' + invalidData + '").',
                        timeout: 2000
                    };
                    document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                    $("#ext_url").val('');
                }
                else { //URL LIST OK
                    var error_alert = 0;
                    $("#p1").show();
                    var lastResponseLength = false;
                    var ajaxRequest = $.ajax({
                        type: 'get',
                        url: 'https://serpsim.com/process_serpsim',
                        data: {action:'bulk', urls:$("#ext_url").val().trim()},
                        processData: true,
                        xhrFields: {
                            // Getting on progress streaming response
                            onprogress: function(e)
                            {
                                var progressResponse;
                                var response = e.currentTarget.response;
                                if(lastResponseLength === false)
                                {
                                    progressResponse = response;
                                    lastResponseLength = response.length;
                                }
                                else
                                {
                                    progressResponse = response.substring(lastResponseLength);
                                    lastResponseLength = response.length;
                                }
                                if(progressResponse.indexOf('[') == -1) {
                                    try {
                                        var parsedResponse = JSON.parse(progressResponse);
                                        if(parsedResponse.progress !== "undefined") {
                                            document.getElementById('p1').MaterialProgress.setProgress(parsedResponse.progress);
                                        }
                                    } catch (e) {
                                        return false;
                                    }
                                }
                            }
                        }
                    });

                    // On failed
                    ajaxRequest.fail(function(error){
                        if(error == 'sitemap_index') {
                            error_alert = 1;
                            return;
                        }
                    });

                    // On completed
                    ajaxRequest.done(function(json)
                    {
                        $("#p1").hide();
                        document.getElementById('p1').MaterialProgress.setProgress(0);
                        if($("#show_mobile").prop('checked')) {
                            setSERPMode('mobile');
                        }
                        else{
                            setSERPMode('desktop');
                        }
                        uncheckBoxes();

                        parsed_json = JSON.parse(json.slice(json.indexOf('['), json.length));

                        $.each(parsed_json, function(i, item) {
                            var snippet_class = "snippet_list";
                            if($.fn.textWidth(item.title, title_font) > max_length_title || $.fn.textWidth(item.meta, meta_font) > max_length_meta) {
                                snippet_class += " error";
                            }
                            $('<div class="' + snippet_class + '" data-snippet-id="' + Date.now() + Math.random() + '" data-serp-title="' + item.title +  '" data-serp-url="' + item.url + '" data-serp-meta="' + item.meta + '" data-list-number="' + (parseInt($(".snippet_list").length) + 1) + '"><div class="snippet_number">' + (parseInt($(".snippet_list").length) + 1) + '.</div><div class="snippet_text"><span class="saved_title">' + truncateString(item.title, 65) + '</span><span class="saved_url">' + truncateString(item.url, 80) + '</span></div><div class="snippet_options"><i class="material-icons delete_snippet">clear</i></div>').insertAfter($("#snippet_list_header"));
                            if($(".snippet_list").length%2===0){
                                $(".snippet_list:first").addClass('evenDiv');
                            }
                        });
                        if($(".snippet_list").length > 0 ) {
                            $("#list_container").show();
                        }
                        var data = {
                            message: 'Saved snippets loaded',
                            timeout: 2000
                        };
                        if(data) {
                            document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                        }
                        loadSnippet($(".snippet_list:first"));

                        var alert_msg = 'Data from URL downloaded.';
                        if(error_alert == 1) {
                            alert_msg = 'Sitemap index-file detected. Please enter the actual sitemap.xml URL.';
                        }
                        var data = {
                            message: alert_msg,
                            timeout: 3000
                        };
                        document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                    });

                }
            }, 100);
        });

        $("#fetch_url").click(function() {
            $("#ext_url").val($("#ext_url").val().replace('\t','').trim());
            if(!isURL($("#ext_url").val())){
                var data = {
                    message: 'Invalid URL',
                    timeout: 2000
                };
                document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                return;
            }
            //SITEMAP
            if($("#ext_url").val().includes("sitemap") && $("#ext_url").val().endsWith(".xml")) {
                $(".snippet_list").remove();
                $("#list_container").hide();
                $("#title_text").val('').trigger('keyup');
                $("#url").val('').trigger('keyup');
                $("#meta_desc").val('').trigger('keyup');
                $("#snippet_id").val('');
                $(".active_snippet").removeClass('active_snippet');
                uncheckBoxes();

                //$("#ext_url_status").show();
                var error_alert = 0;
                $("#p1").show();
                var lastResponseLength = false;
                var ajaxRequest = $.ajax({
                    type: 'get',
                    url: 'https://serpsim.com/process_serpsim',
                    data: {action:'sitemap', url:$("#ext_url").val().trim()},
                    processData: true,
                    xhrFields: {
                        // Getting on progress streaming response
                        onprogress: function(e)
                        {
                            var progressResponse;
                            var response = e.currentTarget.response;
                            if(lastResponseLength === false)
                            {
                                progressResponse = response;
                                lastResponseLength = response.length;
                            }
                            else
                            {
                                progressResponse = response.substring(lastResponseLength);
                                lastResponseLength = response.length;
                            }
                            try {
                                var parsedResponse = JSON.parse(progressResponse);
                                if(parsedResponse.progress !== "undefined") {
                                    document.getElementById('p1').MaterialProgress.setProgress(parsedResponse.progress);
                                }
                            } catch (e) {
                                return false;
                            }
                            var parsedResponse = JSON.parse(progressResponse);
                            if(parsedResponse.progress !== "undefined") {
                                document.getElementById('p1').MaterialProgress.setProgress(parsedResponse.progress);
                            }
                        }
                    }
                });

                // On failed
                ajaxRequest.fail(function(error){
                    if(error == 'sitemap_index') {
                        error_alert = 1;
                        return;
                    }
                });

                // On completed
                ajaxRequest.done(function(json)
                {
                    $("#p1").hide();
                    document.getElementById('p1').MaterialProgress.setProgress(0);
                    if($("#show_mobile").prop('checked')) {
                        setSERPMode('mobile');
                    }
                    else{
                        setSERPMode('desktop');
                    }
                    uncheckBoxes();

                    parsed_json = JSON.parse(json.slice(json.indexOf('['), json.length));

                    $.each(parsed_json, function(i, item) {
                        var snippet_class = "snippet_list";
                        if($.fn.textWidth(item.title, title_font) > max_length_title || $.fn.textWidth(item.meta, meta_font) > max_length_meta) {
                            snippet_class += " error";
                        }
                        $('<div class="' + snippet_class + '" data-snippet-id="' + Date.now() + Math.random() + '" data-serp-title="' + item.title +  '" data-serp-url="' + item.url + '" data-serp-meta="' + item.meta + '" data-list-number="' + (parseInt($(".snippet_list").length) + 1) + '"><div class="snippet_number">' + (parseInt($(".snippet_list").length) + 1) + '.</div><div class="snippet_text"><span class="saved_title">' + truncateString(item.title, 65) + '</span><span class="saved_url">' + truncateString(item.url, 80) + '</span></div><div class="snippet_options"><i class="material-icons delete_snippet">clear</i></div>').insertAfter($("#snippet_list_header"));
                        if($(".snippet_list").length%2===0){
                            $(".snippet_list:first").addClass('evenDiv');
                        }
                    });
                    if($(".snippet_list").length > 0 ) {
                        $("#list_container").show();
                    }
                    var data = {
                        message: 'Saved snippets loaded',
                        timeout: 2000
                    };
                    if(data) {
                        document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                    }
                    loadSnippet($(".snippet_list:first"));

                    var alert_msg = 'Data from URL downloaded.';
                    if(error_alert == 1) {
                        alert_msg = 'Sitemap index-file detected. Please enter the actual sitemap.xml URL.';
                    }
                    var data = {
                        message: alert_msg,
                        timeout: 3000
                    };
                    document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                    $("#ext_url_status").hide();
                });
            }
            else {
                $("#ext_url_status").show();
                $.getJSON("/process_serpsim", {action:'fetch_url', url:$("#ext_url").val().trim()}, function(json) {
                    if($("#show_mobile").prop('checked')) {
                        setSERPMode('mobile');
                    }
                    else{
                        setSERPMode('desktop');
                    }
                    uncheckBoxes();
                    if(json.error == 'missing_title') {
                        error_alert = 1;
                        return;
                    }

                    $("#serp_favicon_mobile").attr('src', 'https://www.google.com/s2/favicons?domain=' + extractDomain(json.url.replace(/\s+/g, " ")));
                    //$("#serp_favcrumbs_mobile").text(json.url.replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 > $3").replace(/\.[^/.]+$/, ""));
                    $("#serp_favcrumbs_mobile").text(json.url.replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace(/\/$/, ""));
                    $("#title_text").val(json.title.replace(/\s+/g, " ")).trigger('keyup');
                    $("#meta_desc").val(json.meta.replace(/\s+/g, " ")).trigger('keyup');
                    $("#url").val(json.url.replace(/\s+/g, " ")).trigger('keyup');
                    //$("#url").val(json.url.replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace(/\/$/, "")).trigger('keyup');
                    $("#ext_url").val(json.url);
                    $("#snippet_id").val('');
                    $(".active_snippet").removeClass('active_snippet');
                }).done(function() {
                    var alert_msg = 'Data from URL downloaded.';
                    if(error_alert == 1) {
                        alert_msg = "Unable to fetch data from URL. Possibly caused by misconfigured gzip or encoding issue.";
                    }

                    var data = {
                        message: alert_msg,
                        timeout: 3000
                    };
                    document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                    gtag('event', 'Fetch url', {'event_category' : 'Button click', 'event_label' : $("#ext_url").val()});
                    $("#ext_url_status").hide();
                });
            }
        });

        //TITLE
        $("#serp_title").click(function() {
            url = $("#serp_url").text();
            if (!/^https?:\/\//i.test(url)) {
                url = 'http://' + url;
            }
            window.open(url);
        });

        $("#title_text").keyup(function(e) {
            arrowNavigation($(this), e);
            title_pixel_length = $.fn.textWidth($("#title_text").val(), title_font);
            curr_length = "";
            if(title_pixel_length > max_length_title) {
                title_chunks = $("#title_text").val().split(" ");
                real_result = "";
                real_length = 0;
                for (var i = 0, len = title_chunks.length; i < len; i++) {
                    new_title_length = Math.ceil(parseFloat(real_length) + parseFloat($.fn.textWidth('. ..', title_font)) + parseFloat($.fn.textWidth(title_chunks[i], title_font)));
                    if(new_title_length < max_length_title) {
                        real_result += ' ' + title_chunks[i];
                    }
                    else if (title_chunks.length === 1) {
                        real_result = substringPixels(title_chunks[0], max_length_title - $.fn.textWidth('. ..', title_font), title_font) + ' ...'
                    }
                    else {
                        var b = 0;
                        while(!real_result.slice(-1).match(/[a-zåäöA-ZÅÄÖ0-9]/i)) {
                            if(b > 10) {
                                break;
                            }
                            real_result = real_result.slice(0, -1);
                            b++;
                        }
                        real_result += ' ...';
                        break;
                    }
                    real_length = $.fn.textWidth(real_result, title_font);
                }
                if($("#show_mobile").prop('checked')) {
                    $("#serp_title_mobile").text(real_result);
                }
                else {
                    $("#serp_title").text(real_result);
                }
                curr_length = "<strong><span class='alert'>" + Math.ceil(title_pixel_length) + "px</span></strong>";
            }
            else if($("#show_mobile").prop('checked')) {
                $("#serp_title_mobile").text($("#title_text").val());
                curr_length = Math.ceil(title_pixel_length) + "px";
            }
            else {
                $("#serp_title").text($("#title_text").val());
                curr_length = Math.ceil(title_pixel_length) + "px";
            }
            $("#title_length").html('(' + curr_length + ' / ' + max_length_title + 'px)');
            $("#title_length_mobile").html('(' + curr_length + ' / ' + max_length_title + 'px)');
        });

        //META DESCRIPTION
        $("#meta_desc").keyup(function(e) {
            arrowNavigation($(this), e);
            meta_text = $("#meta_desc").val();
            if($("#show_date").prop('checked')) {
                meta_text = '24 Dec, 2018 - ' + meta_text;
            }
            prepend_string = '';
            meta_pixel_length = $.fn.textWidth(meta_text, meta_font);
            if(meta_pixel_length > max_length_meta) {
                meta_chunks = meta_text.split(" ");
                real_result = "";
                real_length = 0;
                for (var i = 0, len = meta_chunks.length; i < len; i++) {
                    new_meta_string = real_result + ' ' + meta_chunks[i];
                    new_meta_length =  Math.ceil($.fn.textWidth(new_meta_string, meta_font));
                    if(new_meta_length < max_length_meta) {
                        real_result += ' ' + meta_chunks[i];
                    }
                    else if (meta_chunks.length === 1) {
                        real_result = $.fn.textWidth(meta_chunks[i], meta_font) + ' ...'
                    }
                    else {
                        var b = 0;
                        split_chunk = meta_chunks[i].replace(/,/g, ' ').split(' ')[0];
                        if((real_length + $.fn.textWidth(split_chunk, meta_font) + $.fn.textWidth('. ..', meta_font)) < max_length_meta) {
                            real_result += ' ' + split_chunk;
                        }
                        real_result += ' ...';
                        break;
                    }
                    real_length = $.fn.textWidth(real_result, meta_font);
                }
                if($("#show_mobile").prop('checked')) {
                    $("#serp_meta_mobile").text(real_result.replace('24 Dec, 2018 - ', ''));
                }
                else {
                    $("#serp_meta").text(real_result.replace('24 Dec, 2018 - ', ''));
                }
                curr_length = "<strong><span class='alert'>" + Math.ceil(meta_pixel_length) + "px</span></strong>";
            }
            else if ($("#show_mobile").prop('checked')) {
                $("#serp_meta_mobile").text($("#meta_desc").val());
                curr_length = Math.ceil(meta_pixel_length) + 'px';
            }
            else {
                $("#serp_meta").text($("#meta_desc").val());
                curr_length = Math.ceil(meta_pixel_length) + 'px';
            }
            $("#meta_desc_length").html('(' + curr_length + ' / ' + max_length_meta + 'px)');
            $("#meta_desc_length_mobile").html('(' + curr_length + ' / ' + max_length_meta + 'px)');
        });


        //URL
        $("#url").keyup(function(e) {
            arrowNavigation($(this), e);
            var url_val = $("#url").val().replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace('.html', '').replace(/\/$/, "");
            if($("#show_mobile").prop('checked')) {
                url_val = mobileURL(url_val);
                $("#serp_favcrumbs_mobile").text($("#url").val().replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace(/\/$/, ""));
            }
            url_pixel_length = $.fn.textWidth(url_val, url_font);
            curr_length = "";
            offset = 0;
            if($("#show_cached").prop('checked')) {
                offset = 54;
            }
            if(url_pixel_length > (max_length_url-offset)) {
                if($("#show_mobile").prop('checked')) {
                    $("#serp_url_mobile").html(truncateUrlMobile(url_val));

                }
                else {
                    $("#serp_favcrumbs_mobile").text($("#url").val().replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace(/\/$/, ""));
                    $("#serp_url").html(truncateUrlMobile(url_val));
                }
                curr_length = "<strong><span class='alert'>" + Math.floor(url_pixel_length + offset) + "px</span></strong>";
            }
            else if($("#show_mobile").prop('checked')) {
                $("#serp_url_mobile").html(url_val);
                curr_length = Math.floor(url_pixel_length) + offset +"px";
            }
            else {
                $("#serp_url").html($("#url").val().replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace('.html', "").replace(/\/$/, ""));
                curr_length = Math.floor(url_pixel_length) + offset +"px";
            }
            $("#url_length").html('(' + curr_length + ' / ' + max_length_url + 'px)');
            $("#url_length_mobile").html('(' + curr_length + ' / ' + max_length_url + 'px)');
        });

        var loaded_slug = '';

        if(loaded_slug) {
            $.getJSON("https://serpsim.com/process_serpsim", {action:'load', slug:loaded_slug}, function(json) {
                $.each(json, function(i, item) {

                    var snippet_class = 'snippet_list';
                    if($.fn.textWidth(item.title, title_font) > max_length_title || $.fn.textWidth(item.meta,  meta_font) > max_length_meta) {
                        snippet_class += " error";
                    }

                    $('<div class="' + snippet_class + '" data-snippet-id="' + item.list_id + '" data-serp-title="' + item.title +  '" data-serp-url="' + item.url + '" data-serp-meta="' + item.meta + '" data-list-number="' + item.list_order + '"><div class="snippet_number">' + item.list_order + '.</div><div class="snippet_text"><span class="saved_title">' + truncateString(item.title, 65) + '</span><span class="saved_url">' + truncateString(item.url, 80) + '</span></div><div class="snippet_options"><i class="material-icons delete_snippet">clear</i></div>').insertAfter($("#snippet_list_header"));
                    if($(".snippet_list").length%2===0){
                        $(".snippet_list:first").addClass('evenDiv');
                    }
                });
                if($(".snippet_list").length > 0 ) {
                    $("#list_container").show();
                }
                var data = {
                    message: 'Saved snippets loaded',
                    timeout: 2000
                };
                if(data) {
                    //document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
                }
                loadSnippet($(".snippet_list:first"));
            });
        }

        function initialAlert(){
            var data = {
                message: 'New META description limits: 930px desktop, 720px mobile.',
                timeout: 10000
            };
            //      document.querySelector('#demo-toast-example').MaterialSnackbar.showSnackbar(data);
        }

        if (/Mobi/.test(navigator.userAgent)) {
            setSERPMode('mobile');
        }

        setTimeout(initialAlert, 1000);

    });
</script>
</body>
</html>

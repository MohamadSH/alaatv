var SerpsimSimulator = function() {

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

    function setSERPMode(mode) {
        //console.log('SERP Mode = ' + mode);
        if(mode === 'mobile') {
            $(".mode_active").removeClass('mode_active');
            $(".SerpsimSimulator .mode_mobile").addClass('mode_active');
            $(".SerpsimSimulator .show_mobile").prop('checked', true);
            $(".SerpsimSimulator .serp_result").hide();
            $(".SerpsimSimulator .serp_result_mobile").show();
            title_font = title_font_mb;
            url_font = url_font_mb;
            meta_font = meta_font_mb;
            max_length_title = max_length_title_mb;
            max_length_url = max_length_url_mb;
            max_length_meta = max_length_meta_mb;
            $(".SerpsimSimulator .title_text").trigger('keyup');
            $(".SerpsimSimulator .url").trigger('keyup');
            $(".SerpsimSimulator .meta_desc").trigger('keyup');
        }
        else if(mode === 'desktop') {
            $(".mode_active").removeClass('mode_active');
            $(".SerpsimSimulator .mode_desktop").addClass('mode_active');
            $(".SerpsimSimulator .show_mobile").prop('checked', false);
            $(".SerpsimSimulator .serp_result_mobile").hide();
            $(".SerpsimSimulator .serp_result").show();
            title_font = title_font_dt;
            url_font = url_font_dt;
            meta_font = meta_font_dt;
            max_length_title = max_length_title_dt;
            max_length_url = max_length_url_dt;
            max_length_meta = max_length_meta_dt;
            $(".SerpsimSimulator .title_text").trigger('keyup');
            $(".SerpsimSimulator .url").trigger('keyup');
            $(".SerpsimSimulator .meta_desc").trigger('keyup');
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

    function substringPixels(phrase, limit, font) {
        var pixel_width = 0;
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

    function updatePreview() {
        updateUrl();
        updateTitle();
        updateMetaDesc();
    }

    function updateTitle() {
        title_pixel_length = $.fn.textWidth($(".SerpsimSimulator .title_text").val(), title_font);
        curr_length = "";
        if(title_pixel_length > max_length_title) {
            title_chunks = $(".SerpsimSimulator .title_text").val().split(" ");
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
            if($(".SerpsimSimulator .show_mobile").prop('checked')) {
                $(".SerpsimSimulator .serp_result_mobile .serp_title_mobile").text(real_result);
            }
            else {
                $(".SerpsimSimulator .serp_result .serp_title").text(real_result);
            }
            curr_length = "<strong><span class='alert'>" + Math.ceil(title_pixel_length) + "px</span></strong>";
        }
        else if($(".SerpsimSimulator .show_mobile").prop('checked')) {
            $(".SerpsimSimulator .serp_result_mobile .serp_title_mobile").text($(".SerpsimSimulator .title_text").val());
            curr_length = Math.ceil(title_pixel_length) + "px";
        }
        else {
            $(".SerpsimSimulator .serp_result .serp_title").text($(".SerpsimSimulator .title_text").val());
            curr_length = Math.ceil(title_pixel_length) + "px";
        }
        $(".SerpsimSimulator .title_length_mobile").html('(' + curr_length + ' / ' + max_length_title + 'px)');
    }

    function updateMetaDesc() {
        meta_text = $(".SerpsimSimulator .meta_desc").val();
        if($(".SerpsimSimulator .show_date").prop('checked')) {
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
            if($(".SerpsimSimulator .show_mobile").prop('checked')) {
                $(".SerpsimSimulator .serp_result_mobile .serp_meta_mobile").text(real_result.replace('24 Dec, 2018 - ', ''));
            }
            else {
                $(".SerpsimSimulator .serp_result .serp_meta").text(real_result.replace('24 Dec, 2018 - ', ''));
            }
            curr_length = "<strong><span class='alert'>" + Math.ceil(meta_pixel_length) + "px</span></strong>";
        }
        else if ($(".SerpsimSimulator .show_mobile").prop('checked')) {
            $(".SerpsimSimulator .serp_result_mobile .serp_meta_mobile").text($(".SerpsimSimulator .meta_desc").val());
            curr_length = Math.ceil(meta_pixel_length) + 'px';
        }
        else {
            $(".SerpsimSimulator .serp_result .serp_meta").text($(".SerpsimSimulator .meta_desc").val());
            curr_length = Math.ceil(meta_pixel_length) + 'px';
        }
        $(".SerpsimSimulator .meta_desc_length_mobile").html('(' + curr_length + ' / ' + max_length_meta + 'px)');
    }

    function updateUrl() {
        var url_val = $(".SerpsimSimulator .url").val().replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace('.html', '').replace(/\/$/, "");
        if($(".SerpsimSimulator .show_mobile").prop('checked')) {
            url_val = mobileURL(url_val);
            $(".SerpsimSimulator .serp_result_mobile .serp_favcrumbs_mobile").text($(".SerpsimSimulator .url").val().replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace(/\/$/, ""));
        }
        url_pixel_length = $.fn.textWidth(url_val, url_font);
        curr_length = "";
        offset = 0;
        if($(".SerpsimSimulator .show_cached").prop('checked')) {
            offset = 54;
        }
        if(url_pixel_length > (max_length_url-offset)) {
            if($(".SerpsimSimulator .show_mobile").prop('checked')) {
                // $("#serp_url_mobile").html(truncateUrlMobile(url_val));

            }
            else {
                $(".SerpsimSimulator .serp_result_mobile .serp_favcrumbs_mobile").text($(".SerpsimSimulator .url").val().replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace(/\/$/, ""));
                $(".SerpsimSimulator .serp_result .serp_url").html(truncateUrlMobile(url_val));
            }
            curr_length = "<strong><span class='alert'>" + Math.floor(url_pixel_length + offset) + "px</span></strong>";
        }
        else if($(".SerpsimSimulator .show_mobile").prop('checked')) {
            // $(".SerpsimSimulator .serp_result .serp_url_mobile").html(url_val);
            curr_length = Math.floor(url_pixel_length) + offset +"px";
        }
        else {
            $(".SerpsimSimulator .serp_result .serp_url").html($(".SerpsimSimulator .url").val().replace(/\s+/g, " ").replace(/([^\/])(\/)([^\/])/g,"$1 › $3").replace('.html', "").replace(/\/$/, ""));
            curr_length = Math.floor(url_pixel_length) + offset +"px";
        }
        $(".SerpsimSimulator .url_length_mobile").html('(' + curr_length + ' / ' + max_length_url + 'px)');
    }

    function getTemplate() {
        return '' +
            '\n' +
            '            <div class="SerpsimSimulator">\n' +
            '\n' +
            '                <div class="panel">\n' +
            '                    <input class="title_text" type="text" placeholder="Enter a title...">\n' +
            '                    <input class="url" type="text" placeholder="Enter a url..." autocapitalize="none">\n' +
            '                    <textarea class="meta_desc" placeholder="Enter a META description..."></textarea>\n' +
            '\n' +
            '                    <div class="input_row">\n' +
            '                        <div class="field_div">\n' +
            '                            <input class="show_rich" type="checkbox" /> Rich snippet\n' +
            '                            <input class="show_date" type="checkbox" /> Date\n' +
            '                            <input class="show_cached" type="checkbox" /> Cached\n' +
            '                            <input class="show_mobile" type="checkbox" style="display: none;"/>\n' +
            '                        </div>\n' +
            '                        <div class="label_div">\n' +
            '                            <span class="input_label">Title</span><span class="title_length_mobile">(0px / 585px)</span>\n' +
            '                            <span class="input_label">URL</span><span class="url_length_mobile">(0px / 536px)</span>\n' +
            '                            <span class="input_label">META</span><span class="meta_desc_length_mobile">(0px / 930px)</span>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '\n' +
            '                </div>\n' +
            '                <div class="serp_preview">\n' +
            '                    <div class="top_bar">\n' +
            '                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 272 92" width="90" height="30.4" class="google_logo"><path fill="#EA4335" d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z"/><path fill="#FBBC05" d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z"/><path fill="#4285F4" d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 7.87 11.17 7.87 7.31 0 11.84-4.51 11.84-13v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.61h9.25zm-8.56 20.92c0-7.81-5.21-13.52-11.84-13.52-6.72 0-12.35 5.71-12.35 13.52 0 7.73 5.63 13.36 12.35 13.36 6.63 0 11.84-5.63 11.84-13.36z"/><path fill="#34A853" d="M225 3v65h-9.5V3h9.5z"/><path fill="#EA4335" d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-23.27-7.98l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z"/><path fill="#4285F4" d="M35.29 41.41V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91.36 15.93 16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.66-2.66 4.41-6.46 5.1-11.65l-22.49.01z"/></svg>\n' +
            '                        <div class="search_div">\n' +
            '                            <div class="search_input" contenteditable="true"></div>\n' +
            '                            <div class="search_categories">\n' +
            '                                <div class="search_cat_active">All</div>\n' +
            '                                <div class="search_cat" style="margin-left: 50px;">Images</div>\n' +
            '                                <div class="search_cat">Videos</div>\n' +
            '                                <div class="search_cat">News</div>\n' +
            '                                <div class="search_cat">Maps</div>\n' +
            '                                <div class="search_cat">More</div>\n' +
            '                                <div class="mode_cat mode_mobile">\n' +
            '                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="25" height="25">\n' +
            '                                        <g>\n' +
            '                                            <g>\n' +
            '                                                <path d="M384,0H128c-17.632,0-32,14.368-32,32v448c0,17.664,14.368,32,32,32h256c17.664,0,32-14.336,32-32V32    C416,14.368,401.664,0,384,0z M256,480c-17.664,0-32-14.336-32-32s14.336-32,32-32s32,14.336,32,32S273.664,480,256,480z M384,384    H128V64h256V384z"/>\n' +
            '                                            </g>\n' +
            '                                        </g>\n' +
            '                                    </svg>\n' +
            '                                    <span style="display:block; font-size: 10px;">Mobile</span>\n' +
            '                                </div>\n' +
            '                                <div class="mode_cat mode_desktop" style="padding-left: 0px;" >\n' +
            '                                    <svg class="mode_active" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 548.172 548.172" style="enable-background:new 0 0 548.172 548.172;" xml:space="preserve" width="25" height="25">\n' +
            '                                        <g>\n' +
            '                                            <path d="M534.75,49.965c-8.945-8.945-19.694-13.422-32.261-13.422H45.681c-12.562,0-23.313,4.477-32.264,13.422   C4.471,58.913,0,69.663,0,82.226v310.633c0,12.566,4.471,23.315,13.417,32.265c8.951,8.945,19.702,13.414,32.264,13.414h155.318   c0,7.231-1.524,14.661-4.57,22.269c-3.044,7.614-6.09,14.273-9.136,19.981c-3.042,5.715-4.565,9.897-4.565,12.56   c0,4.948,1.807,9.24,5.424,12.847c3.615,3.621,7.898,5.435,12.847,5.435h146.179c4.949,0,9.233-1.813,12.848-5.435   c3.62-3.606,5.427-7.898,5.427-12.847c0-2.468-1.526-6.611-4.571-12.415c-3.046-5.801-6.092-12.566-9.134-20.267   c-3.046-7.71-4.569-15.085-4.569-22.128h155.318c12.56,0,23.309-4.469,32.254-13.414c8.949-8.949,13.422-19.698,13.422-32.265   V82.226C548.176,69.663,543.699,58.913,534.75,49.965z M511.627,319.768c0,2.475-0.903,4.613-2.711,6.424   c-1.81,1.804-3.952,2.707-6.427,2.707H45.681c-2.473,0-4.615-0.903-6.423-2.707c-1.807-1.817-2.712-3.949-2.712-6.424V82.226   c0-2.475,0.902-4.615,2.712-6.423c1.809-1.805,3.951-2.712,6.423-2.712h456.815c2.471,0,4.617,0.904,6.42,2.712   c1.808,1.809,2.711,3.949,2.711,6.423V319.768L511.627,319.768z"/>\n' +
            '                                        </g>\n' +
            '                                    </svg>\n' +
            '\n' +
            '                                    <span style="display:block; font-size: 10px;">Desktop</span>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <div class="serp_result">\n' +
            '                        <span class="serp_title"></span><br>\n' +
            '                        <span class="serp_url"></span><div class="arrow_container"><span class="down_arrow"></span></div><br>\n' +
            '                        <div class="rich_div">\n' +
            '                            <span class="serp_rich">\n' +
            '                                <img class="score_stars" src="/acm/AlaatvCustomFiles/components/serpsim/img/stars.png" alt="Rating stars">\n' +
            '                                Rating: 9,7/10 - 112 votes\n' +
            '                            </span>\n' +
            '                        </div>\n' +
            '                        <span class="serp_meta"></span>\n' +
            '                    </div>\n' +
            '                    <div class="serp_result_mobile" style="display: none; background-color: #fff;margin-bottom: 10px;font-size: 14px;line-height: 20px;box-shadow: 0 1px 6px rgba(32, 33, 36, 0.28);border-radius: 8px; width: 359px; margin: 0 auto; margin-top: 50px;">\n' +
            '                        <div class="serp_favdiv_mobile" style="font-size: 14px;line-height: 20px;color: #202124;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;padding-top: 13px;display: block; padding-left: 16px; padding-right: 16px;">\n' +
            '                            <img class="serp_favicon_mobile" style="margin-right: 12px;vertical-align: middle;width: 16px;height: 16px;" src="https://cdn.alaatv.com/upload/favicon2_20190508061941_20190512113140.ico">\n' +
            '                            <span class="serp_favcrumbs_mobile" style="color: #3C4043;white-space: nowrap;font-size: 12px;font-family: Roboto,HelveticaNeue,Arial,sans-serif !important;font-weight: inherit;line-height: 20px;"></span>\n' +
            '                        </div>\n' +
            '                        <div class="serp_title_mobile" style="width: 343px; word-wrap: break-word; font-size: 16px; line-height: 20px; padding-top: 12px; padding-left: 16px; padding-right: 16px; Roboto,HelveticaNeue,Arial,sans-serif !important; color: #1967D2;"></div>\n' +
            '                        <div class="serp_meta_mobile" style="width: 327px; word-wrap: break-word; font-size: 14px; line-height: 20px; padding-top: 12px; padding-left: 16px; padding-right: 16px; padding-bottom: 12px; Roboto,HelveticaNeue,Arial,sans-serif !important; color: #3C4043"></div>\n' +
            '                        <div class="rich_div_mobile" style="margin-top: -4px; width: 327px; word-wrap: break-word; font-size: 14px; line-height: 20px; padding-left: 16px; padding-right: 16px; padding-bottom: 12px;">\n' +
            '                            <div class="rating_mobile" style="font-size: 14px; line-height: 20px; font-family: Roboto,HelveticaNeue,Arial,sans-serif; color: #202124;">Rating</div>\n' +
            '                            <div class="score_mobile" style="margin-top: 5px; font-size: 14px; line-height: 20px; font-family: Roboto,HelveticaNeue,Arial,sans-serif; color: #70757A;">9,2/10 <img id="score_stars_mobile" src="/acm/AlaatvCustomFiles/components/serpsim/img/stars_mobile.png" alt="Rating stars" style="margin-top: -3px;"> (19)</div>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '\n' +
            '            </div>';
    }

    function printTemplate(selector) {
        $(selector).html(getTemplate());
    }

    function addEvents() {

        //RICH SNIPPET
        $(".SerpsimSimulator .show_rich").click(function() {
            $(".SerpsimSimulator .serp_result_mobile .rich_div_mobile").toggle();
            $(".SerpsimSimulator .serp_result .rich_div").toggle();
        });

        //SHOW DATE
        $(".SerpsimSimulator .show_date").click(function() {
            var date_string = '24 Dec, 2019 - ';
            var elm_class = '.SerpsimSimulator .serp_result .serp_meta';
            if($(".SerpsimSimulator .show_mobile").prop('checked')) {
                date_string = '24 Dec 2019 · ';
                elm_class = '.SerpsimSimulator .serp_result_mobile .serp_meta_mobile';
            }
            if($(".SerpsimSimulator .show_date").prop('checked')) {
                $(".SerpsimSimulator .meta_desc").trigger('keyup');
                $(elm_class).prepend('<span id="rich_date">' + date_string + '</span>');
            }
            else {
                $(elm_class).html($(".SerpsimSimulator .serp_result .serp_meta").html().replace(date_string, ''));
                $(".SerpsimSimulator .meta_desc").trigger('keyup');
            }
        });

        //SHOW CACHED
        $(".SerpsimSimulator .show_cached").click(function() {
            if($(".arrow_container").css('display') == 'none') {
                $(".arrow_container").css('display', 'inline');
                // $(".SerpsimSimulator .serp_result .serp_url_mobile").prepend('<img src="/img/amp_logo.png" alt="AMP logo" style="margin-right: 6px; margin-top: -1px;"/>');
            }
            else {
                // $("#serp_url_mobile").text($("#serp_url_mobile").text().replace('<img src="/img/amp_logo.png" alt="AMP logo" style="margin-right: 6px; margin-top: -1px;"/>', ''));
                //console.log($("#serp_url_mobile").text());
                $(".arrow_container").css('display', 'none');
                $(".SerpsimSimulator .url").trigger('keyup');
            }
        });

        //MODE MOBILE
        $(".SerpsimSimulator .mode_mobile").click(function() {
            setSERPMode('mobile');
        });

        //MODE DESKTOP
        $(".SerpsimSimulator .mode_desktop").click(function() {
            setSERPMode('desktop');
        });

        $(".SerpsimSimulator .title_text").keyup(function(e) {
            updateTitle();
        });

        //META DESCRIPTION
        $(".SerpsimSimulator .meta_desc").keyup(function(e) {
            updateMetaDesc();
        });

        //URL
        $(".SerpsimSimulator .url").keyup(function(e) {
            updateUrl();
        });

        $(document).on('SerpsimSimulator-update', function (event, title, url, metaDesc) {
            $(".SerpsimSimulator .title_text").val(title);
            $(".SerpsimSimulator .url").val(url);
            $(".SerpsimSimulator .meta_desc").val(metaDesc);
            updatePreview();
        });
    }

    function init(selector) {
        printTemplate(selector);
        addEvents();
    }


    return {
        init: init
    }

}();

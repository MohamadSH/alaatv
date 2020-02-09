var TelegramTemplate = function() {

    var defaultOptions = {
            videoOrder: 0,
            setName: '', // 'کارگاه_نکته_و_تست',
            nameDars: '', // 'فیزیک_دهم_کنکور',
            videoName1: '',
            videoName2: '',
            teacherName: '', // 'پرویز کازرانیان',
            contentUrl: '',
            productUrl: ''
        },
        options;

    function setData(data) {
        options = $.extend(true, {}, defaultOptions, data);
        cleanData();
    }

    function cleanData() {
        options.setName = options.setName.split(' ').join('_');
        options.nameDars = options.nameDars.split(' ').join('_');
    }

    function getTemplate(template) {
        if (template === 'content') {
            return template_content();
        }
    }

    function template_content() {
        return '👀 #فیلم جلسه '+options.videoOrder+' #'+options.setName+' #'+options.nameDars+' #کنکور  آلاء'+'\n\n'+
            '❤️دوره های ویدئویی کاملا رایگان ▫️▫️▫️▫️'+'\n\n'+
            '🔶 '+options.videoName1+'\n'+
            '🔸 '+options.videoName2+'\n'+
            '🔹دبیر: '+options.teacherName+'\n\n'+
            '➖➖➖➖➖➖➖➖➖➖➖➖'+'\n\n'+
            'تماشای فیلم: 🎦👇'+'\n'+
            '🖥  '+options.contentUrl+'\n'+
            'تهیه جزوه: 🔖👇'+'\n'+
            '📃  '+options.productUrl+'\n\n'+
            '🆔 @alaa_sanatisharif';
    }

    function refreshPreview(template, data, textareaPreview) {
        setData(data);
        $(textareaPreview).val(getTemplate(template));
    }

    function addEvent() {
        $(document).on('TelegramTemplate-update', function (event, template, data, textareaPreview) {
            refreshPreview(template, data, textareaPreview);
        });
    }

    function init(template, data, textareaPreview) {
        refreshPreview(template, data, textareaPreview);
        addEvent();
    }

    return {
        getTemplate: function(template, data) {
            setData(data);
            return getTemplate(template);
        },
        init: init
    };

}();

// TelegramTemplate.init('.TelegramMessagePreviewPortlet .TelegramMessagePreviewTextArea', 'contentsetName', 'nameDars', 'teacherName');

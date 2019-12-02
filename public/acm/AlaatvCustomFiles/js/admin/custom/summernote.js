var summernoteMultiColumnButton = function (context) {
    var ui = $.summernote.ui;

    // create button
    var button = ui.buttonGroup([
        ui.button({
            className: 'dropdown-toggle summernoteMultiColumnButton',
            contents: 'چند ستونه <i class="fa fa-align-justify dropdown-toggle-icon"></i>',
            tooltip: 'چند ستونه',
            data: {
                toggle: 'dropdown'
            },
            // click: function (e) {
            //     var textareaId = $(e.target).parents('.note-editor.note-frame.panel').siblings().attr('id');
            //     var HTMLstring = '<div class="row summernote-row"><div class="col-md-6 summernote-col">column1</div><div class="col-md-6 summernote-col">column2</div></div>';
            //     $('#' + textareaId).summernote('pasteHTML', HTMLstring);
            //
            //     // invoke insertText method with 'hello' on editor module.
            //     // context.invoke('editor.insertText', 'hello');
            // }
        }),
        ui.dropdown({
            className: 'drop-default summernote-list summernoteMultiColumnButton-dropdown',
            contents: '<div class="btn-group">' +
                '<button type="button" class="btn btn-default btn-sm" data-column="2" title="دو ستونه"><i class="fa fa-dice-two"></i></button>' +
                '<button type="button" class="btn btn-default btn-sm" data-column="3" title="سه ستونه"><i class="fa fa-dice-three"></i></button>' +
                '<button type="button" class="btn btn-default btn-sm" data-column="4" title="چهار ستونه"><i class="fa fa-dice-four"></i></button></div>',
            callback: function ($dropdown) {
                $dropdown.find('.btn').click(function (e) {
                    var columnNumber = (typeof $(e.target).attr('data-column')!=='undefined') ? $(e.target).attr('data-column') : $(e.target).parents('.btn').attr('data-column'),
                        HTMLstring = '';

                    if (parseInt(columnNumber) === 2) {
                        HTMLstring = '<div class="row summernote-row"><div class="col-md-6 summernote-col">column2</div><div class="col-md-6 summernote-col">column1</div></div>';
                    } else if (parseInt(columnNumber) === 3) {
                        HTMLstring = '<div class="row justify-content-center summernote-row"><div class="col-md-4 col-sm-6 summernote-col">column3</div><div class="col-md-4 col-sm-6 summernote-col">column2</div><div class="col-md-4 col-sm-6 summernote-col">column1</div></div>';
                    } else if (parseInt(columnNumber) === 4) {
                        HTMLstring = '<div class="row summernote-row"><div class="col-md-3 col-sm-6 summernote-col">column4</div><div class="col-md-3 col-sm-6 summernote-col">column3</div><div class="col-md-3 col-sm-6 summernote-col">column2</div><div class="col-md-3 col-sm-6 summernote-col">column1</div></div>';
                    }

                    var textareaId = $(e.target).parents('.note-editor.note-frame.panel').siblings().attr('id');
                    console.log("$('#"+textareaId+"').summernote('pasteHTML', '"+HTMLstring+"');");
                    $('#' + textareaId).summernote('pasteHTML', HTMLstring);
                });
            }
        })
    ]);

    return button.render();   // return button as jquery object
};
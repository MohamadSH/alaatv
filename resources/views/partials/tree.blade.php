<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        {{--<link href="css/style.css" rel="stylesheet" id="main-css">--}}
        <style>
            div.panel:first-child {
                margin-top:20px;
            }

            div.treeview {
                min-width: 100px;
                min-height: 100px;

                max-height: 256px;
                overflow:auto;

                padding: 4px;

                margin-bottom: 20px;

                color: #369;

                border: solid 1px;
                border-radius: 4px;
            }
            div.treeview ul:first-child:before {
                display: none;
            }
            .treeview, .treeview ul {
                margin:0;
                padding:0;
                list-style:none;

                color: #369;
            }
            .treeview ul {
                margin-left:1em;
                position:relative
            }
            .treeview ul ul {
                margin-left:.5em
            }
            .treeview ul:before {
                content:"";
                display:block;
                width:0;
                position:absolute;
                top:0;
                left:0;
                border-left:1px solid;

                /* creates a more theme-ready standard for the bootstrap themes */
                bottom:15px;
            }
            .treeview li {
                margin:0;
                padding:0 1em;
                line-height:2em;
                font-weight:700;
                position:relative
            }
            .treeview ul li:before {
                content:"";
                display:block;
                width:10px;
                height:0;
                border-top:1px solid;
                margin-top:-1px;
                position:absolute;
                top:1em;
                left:0
            }
            .tree-indicator {
                margin-right:5px;

                cursor:pointer;
            }
            .treeview li a {
                text-decoration: none;
                color:inherit;

                cursor:pointer;
            }
            .treeview li button, .treeview li button:active, .treeview li button:focus {
                text-decoration: none;
                color:inherit;
                border:none;
                background:transparent;
                margin:0px 0px 0px 0px;
                padding:0px 0px 0px 0px;
                outline: 0;
            }
        </style>
        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $.fn.extend({
                treeview: function() {
                    return this.each(function() {
                        // Initialize the top levels;
                        var tree = $(this);
                        tree.addClass('treeview-tree');
                        tree.find('li').each(function() {
                            var stick = $(this);
                        });
                        tree.find('li').has("ul").each(function () {
                            var branch = $(this); //li with children ul

                            branch.prepend("<i class='tree-indicator glyphicon glyphicon-chevron-right'></i>");
                            branch.addClass('tree-branch');
                            branch.on('click', function (e) {
                                if (this == e.target) {
                                    var icon = $(this).children('i:first');

                                    icon.toggleClass("glyphicon-chevron-down glyphicon-chevron-right");
                                    $(this).children().children().toggle();
                                }
                            })
                            branch.children().children().toggle();

                            branch.children('.tree-indicator, button, a').click(function(e) {
                                branch.click();

                                e.preventDefault();
                            });
                        });
                    });
                }
            });

            $(window).on('load', function () {
                $('.treeview').each(function () {
                    var tree = $(this);
                    tree.treeview();
                })
            })
        </script>
    </head>
    <body>
        <div class="container">
            <div class="panel panel-default">
                <h2 class="panel-heading">TreeView Using Bootstrap</h2>
                <div class="panel-body">
                    <ul class="treeview ">
                        @each('partials.subTree', $categories, 'category')
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>



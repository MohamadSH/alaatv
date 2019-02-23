@extends("app")

@section('content')

    <div class = "row">
        <div class = "col-12">

            <div class = "form-group m-form__group">
                <label for = "exampleSelect1">نمونه سلکت</label>
                <select name = "extraAttribute[]" class = "form-control m-input attribute">
                    <option value = "1">نمونه یک</option>
                    <option value = "2">نمونه پسران</option>
                    <option value = "3">نمونه دختران</option>
                </select>
            </div>

        </div>
        <div class = "col-12">

            <label class = "m-checkbox m-checkbox--air m-checkbox--state-success">
                <input type = "checkbox" name = "extraAttribute[]" value = "12">
                نمونه چکباکس
                <span></span>
            </label>

        </div>
        <div class = "col-12">
            <div class = "m-section">
                <h3 class = "m-section__heading">
                    Directions
                </h3>
                <span class = "m-section__sub">
                        Four direction options are available: top, right, bottom, and left aligned:
                    </span>
                <div class = "m-section__content m-demo-buttons">
                    <button type = "button" class = "btn btn-brand" data-container = "body" data-toggle = "m-popover" data-placement = "top" data-content = "Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title = "" title = "">
                        Popover on top
                    </button>

                    <button type = "button" class = "btn btn-primary" data-container = "body" data-toggle = "m-popover" data-placement = "right" data-content = "Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title = "" title = "">
                        Popover on right
                    </button>

                    <button type = "button" class = "btn btn-warning" data-container = "body" data-toggle = "m-popover" data-placement = "bottom" data-content = "Vivamus
                        sagittis lacus vel augue laoreet rutrum faucibus." data-original-title = "" title = "">
                        Popover on bottom
                    </button>

                    <button type = "button" class = "btn btn-success" data-container = "body" data-toggle = "m-popover" data-placement = "left" data-content = "Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title = "" title = "">
                        Popover on left
                    </button>
                </div>
            </div>
        </div>
        <div class = "col-12">
            <div class = "m-section">
                <h3 class = "m-section__heading">
                    Directions
                </h3>
                <span class = "m-section__sub">
                        Four direction options are available: top, right, bottom, and left aligned:
                    </span>
                <div class = "m-section__content">
                    <button type = "button" class = "btn btn-brand" data-container = "body" data-toggle = "m-tooltip" data-placement = "top" title = "" data-original-title = "Tooltip title">
                        Tooltip on top
                    </button>

                    <div class = "m--space-10"></div>

                    <button type = "button" class = "btn btn-primary" data-container = "body" data-toggle = "m-tooltip" data-placement = "right" title = "" data-original-title = "Tooltip title">
                        Tooltip on right
                    </button>

                    <div class = "m--space-10"></div>

                    <button type = "button" class = "btn btn-warning" data-container = "body" data-toggle = "m-tooltip" data-placement = "bottom" title = "" data-original-title = "Tooltip title">
                        Tooltip on bottom
                    </button>

                    <div class = "m--space-10"></div>

                    <button type = "button" class = "btn btn-success" data-container = "body" data-toggle = "m-tooltip" data-placement = "left" title = "" data-original-title = "Tooltip title">
                        Tooltip on left
                    </button>
                </div>
            </div>
        </div>
        <div class = "col-12">

        </div>
    </div>

@endsection
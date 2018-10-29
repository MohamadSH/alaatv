@extends("app",["pageName"=>"aboutUs"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>درباره ما</span>
            </li>
        </ul>
    </div>
@endsection

@section('title')
    <title>آلاء|درباره ما</title>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-paper-plane font-yellow-casablanca"></i>
                        <span class="caption-subject bold font-yellow-casablanca uppercase"> Form Input </span>
                        <span class="caption-helper">more samples...</span>
                    </div>
                    <div class="inputs">
                        <div class="portlet-input input-inline input-medium">
                            <div class="input-group">
                                <input type="text" class="form-control input-circle-left" placeholder="search...">
                                <span class="input-group-btn">
                                                    <button class="btn btn-circle-right btn-default"
                                                            type="submit">Go!</button>
                                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <h4>Heading text goes here...</h4>
                    <p> Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                        Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat
                        porttitor ligula, eget
                        lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est
                        non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis
                        consectetur purus sit amet
                        fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio
                        sem nec elit. Cras mattis consectetur purus sit amet fermentum. </p>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>

@endsection


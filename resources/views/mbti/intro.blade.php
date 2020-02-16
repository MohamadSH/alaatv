@extends('partials.templatePage' , ["pageName" => $pageName])

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/about-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <div class = "portlet light about-text" style = "height: 100%">
                <h4>
                    <i class = "fa fa-check icon-info"></i>
                    آزمون MBTI (خودشناسی)
                </h4>
                <p class = "margin-top-20 bold" style = "font-size: larger;line-height: 3;text-align: justify">
                    تست شخصیت مایرز-بریگز (MBTI) از شناخته شده ترین تست های شخصیت شناسی است. با انجام این آزمون شما متوجه می شوید که درون گرا هستید یا برون گرا، در جمع آوری اطلاعات شهودی هستید یا حسی، شخصیتی احساسی دارید یا منطقی و در سبک هدایت با جهان خارج ادراکی برخورد می کنید یا قضاوتی.
                </p>
                <p style = "text-align: center">
                    <a href = "/شرکت-در-mbti" class = "btn btn-lg blue">
                        <i class = "fa fa-edit"></i>
                        شرکت در آزمون
                    </a>
                </p>

            </div>
        </div>

    </div>@endsection

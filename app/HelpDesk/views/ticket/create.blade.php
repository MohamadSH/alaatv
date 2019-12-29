@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">ایجاد یک تیکت پشتیبانی</div>

                <div class="panel-body">
                    @include('helpDesk::includes.flash')

                    <form class="form-horizontal" role="form" method="POST"
                          action="{{ action('\App\HelpDesk\Controllers\TicketController@store') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="col-md-4 control-label">عنوان</label>

                            <div class="col-md-6">
                                <input id="subject" type="text" class="form-control" name="subject"
                                       value="{{ old('subject') }}">

                                @if ($errors->has('subject'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category" class="col-md-4 control-label">بخش</label>

                            <div class="col-md-6">
                                <select id="category" type="category" class="form-control" name="category">
                                    <option value="">بخش مورد نظر را انتخاب کنید</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <label for="priority" class="col-md-4 control-label">اولویت</label>

                            <div class="col-md-6">
                                <select id="priority" type="" class="form-control" name="priority">
                                    <option value="">اولویت مورد خود را تعیین کنید</option>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-4 control-label">پیام</label>

                            <div class="col-md-6">
                                <textarea rows="10" id="content" class="form-control" name="content"></textarea>

                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-ticket"></i> یک تیکت باز کن
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

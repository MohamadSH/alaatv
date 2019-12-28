@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-ticket">تیکت های من</i>
                </div>

                <div class="panel-body">
                    @if ($tickets->isEmpty())
                        <p>شما تا کنون تیکتی ایجاد نکردید.</p>
                    @else
                        <table class="table">
                            <thead>
                            <tr>
                                <th>بخش</th>
                                <th>موضوع</th>
                                <th>مسئول</th>
                                <th>وضعیت</th>
                                <th>تاریخ ایجاد</th>
                                <th>آخرین بروزرسانی</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>
                                        {{ $ticket->category->name }}
                                    </td>
                                    <td>
                                        <a href="{{ action('\App\HelpDesk\Controllers\TicketController@show',$ticket) }}">
                                            #{{ $ticket->id }} - {{ $ticket->subject }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $ticket->agent->full_name }}
                                    </td>
                                    <td>
                                        <span class="label label-success">{{ $ticket->status->name }}</span>
                                    </td>
                                    <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                    <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $tickets->render() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

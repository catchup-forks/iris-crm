<table class="table table-striped table-responsive" id="accounts-table">
    <thead>
    <th class="h4 text-purple text-uppercase">{{trans('app.general:name')}}</th>
    <th class="h4 text-purple text-uppercase">{{trans('app.general:website')}}</th>
    <th class="h4 text-purple text-uppercase">{{trans('app.general:offices')}}</th>
    <th class="h4 text-purple text-uppercase">{{trans('app.general:contacts')}}</th>
    <th class="h4 text-purple text-uppercase">{{trans('app.general:quotes')}}</th>
    @if(!$isLead)
    <th class="h4 text-purple text-uppercase">{{trans('app.general:invoices')}}</th>
    <th class="h4 text-purple text-uppercase">{{trans('app.account:converted')}}</th>
    @endif
    <th class="h4 text-purple text-uppercase" colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($accounts as $account)
        <tr>
            <td class="text-bold">{!! $account->name !!}</td>
            <td class="text-bold"><a href="{{$account->website}}">{!! $account->website !!}</a></td>
            <td class="text-bold">{!! $account->offices->count() !!}</td>
            <td class="text-bold">{!! $account->contacts->count() !!}</td>
            <td class="text-bold">{!! $account->quotes->count() !!}</td>
            @if(!$isLead)
            <td class="text-bold">{!! $account->invoices->count() !!}</td>
            <td class="text-bold">
                @if($account->converted)
                    {{trans('app.general:yes')}}
                @else
                    {{trans('app.general:no')}}
                @endif
            </td>
            @endif
            <td>
                @if(!$isLead)
                    {!! Form::open(['action' => ['AccountController@destroy', $account->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! action('AccountController@show', [$account->id]) !!}" class='btn btn-info btn-flat'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! action('AccountController@edit', [$account->id]) !!}" class='btn bg-blue btn-flat'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-flat', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                @else
                    {!! Form::open(['action' => ['LeadController@destroy', $account->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! action('LeadController@show', [$account->id]) !!}" class='btn btn-info btn-flat'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! action('LeadController@edit', [$account->id]) !!}" class='btn bg-blue btn-flat'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-flat', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

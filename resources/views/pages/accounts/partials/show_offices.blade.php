@if($account->offices->count() < 1)
    <div class="form-group col-sm-10 text-center">
        <h3 class="box-title animated flash">{{trans('app.account:no-offices-title')}}</h3>
        <h4 class="animated fadeIn">{{trans('app.account:no-offices-desc')}}</h4>
        <div class="col-sm-12 text-center">
            <a class="btn btn-app bg-blue btn-flat animated pulse" style="font-size: 15px;" href="{{action('OfficeController@create', $account->id)}}">
                <i class="fa fa-building"></i> {{trans('app.general:create')}}
            </a>
        </div>
    </div>

@else
    <div class="tab-content">

                @foreach($account->offices as $office)

                    <div class="tab-pane fade {{(!$loop->first)?:'active in'}}" id="{{$office->id}}">

                        <div class="box box-primary">
                            <div class="box-body">

                                <h4 class="box-title pull-left"> {{ $office->name }} </h4>
                                <a class="btn bg-blue btn-flat pull-right" href="{{action('ContactController@create', ["account_id" => $account->id, "office_id" => $office->id])}}">
                                    <i class="fa fa-address-card" style="margin-right:5px"> </i> {{trans('app.contact:office-add')}}
                                </a>
                                <br>
                                <table class="table table-bordered text-center">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-lg btn-block btn-info btn-flat" @click="{{VueHelper::format('loadQuotes', $office->name, $office->load('addresses'))}}">{{trans('app.general:quotes')}}</button>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-lg btn-block btn-info btn-flat" @click="{{VueHelper::format('loadInvoices', $office->name, $office->load('addresses'))}}">{{trans('app.general:invoices')}}</button>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <!-- Office Name Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('name', trans('app.general:name') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->name}}</span>
                                </div>

                                <!-- Type Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('type',trans('app.general:type') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->type}}</span>
                                </div>

                                <!-- Activity Sector Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('activity_sector', trans('app.general:activity-sector') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->activity_sector}}</span>
                                </div>

                                <!-- Workforce Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('workforce', trans('app.general:workforce') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->workforce}}</span>
                                </div>

                                <!-- Siret Number Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('siret_number', trans('app.general:siret-number') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->siret_number}}</span>
                                </div>

                                <!-- Ape Number Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('ape_number', trans('app.general:ape-number') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->ape_number}}</span>
                                </div>

                                <!-- Phone Number Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('phone_number', trans('app.general:phone-number') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->phone_number}}</span>
                                </div>


                                <!-- Website Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('website', trans('app.general:website') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->website}}</span>
                                </div>

                            </div>
                        </div>

                        <div class="box box-primary">
                            <div class="box-body">
                                @foreach($office->addresses as $address)
                                    @if($address->pivot->type == 'delivery')
                                        <h4 class="box-title">{{trans('app.general:delivery-address')}}</h4>
                                    @elseif($address->pivot->type == 'billing')
                                        <h4 class="box-title">{{trans('app.general:billing-address')}}</h4>
                                    @endif
                                    <hr>

                                    <div class="form-group col-sm-6">
                                        {!! Form::label('name', trans('app.address:name') . ' :', ['class' => 'h4 text-purple']) !!}
                                        <span class="h4 text-bold">{{$address->name}}</span>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        {!! Form::label('street_label', trans('app.address:street-label') . ' :', ['class' => 'h4 text-purple']) !!}
                                        <span class="h4 text-bold">{{$address->street_label}}</span>
                                    </div>


                                    <div class="form-group col-sm-6">
                                        {!! Form::label('street_detail', trans('app.address:street-detail') . ' :', ['class' => 'h4 text-purple']) !!}
                                        <span class="h4 text-bold">{{$address->street_detail}}</span>
                                    </div>


                                    <div class="form-group col-sm-6">
                                        {!! Form::label('zipcode', trans('app.general:zipcode') . ' :', ['class' => 'h4 text-purple']) !!}
                                        <span class="h4 text-bold">{{$address->zipcode}}</span>
                                    </div>


                                    <div class="form-group col-sm-6">
                                        {!! Form::label('city', trans('app.general:city') . ' :', ['class' => 'h4 text-purple']) !!}
                                        <span class="h4 text-bold">{{$address->city}}</span>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        {!! Form::label('country', trans('app.general:country') . ' :', ['class' => 'h4 text-purple']) !!}
                                        <span class="h4 text-bold">{{$address->country}}</span>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                        <div class="box box-primary">
                            <div class="box-body">

                                <!-- Is Active Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('is_active', trans('app.general:is-active') . ' :', ['class' => 'h4 text-purple']) !!}
                                    @if($office->is_active)
                                        <h4 class="text-bold"> {{trans('app.general:yes')}}</h4>
                                    @else
                                        <h4 class="text-bold"> {{trans('app.general:no')}}</h4>
                                    @endif
                                </div>

                                <!-- Is Main Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('is_main', trans('app.office:is-main') . ' :', ['class' => 'h4 text-purple']) !!}
                                    @if($office->is_main)
                                        <h4 class="text-bold"> {{trans('app.general:yes')}}</h4>
                                    @else
                                        <h4 class="text-bold"> {{trans('app.general:no')}}</h4>
                                    @endif
                                </div>

                                <!-- Created At Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('created_at', trans('app.general:created-at') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->created_at}}</span>
                                </div>

                                <!-- Updated At Field -->
                                <div class="form-group col-sm-6">
                                    {!! Form::label('updated_at',  trans('app.general:updated-at') . ' :', ['class' => 'h4 text-purple']) !!}
                                    <span class="h4 text-bold">{{$office->updated_at}}</span>
                                </div>

                            </div>
                        </div>


                    </div>
                @endforeach
            </div>


@endif


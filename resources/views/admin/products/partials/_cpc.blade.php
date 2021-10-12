<div class="row">
    <div class="col-lg-4">
        <h3>Offerte</h3>
    </div>
    <BR><BR><BR><BR>


    <a href="{{ route('admin.offerts.create') }}?product={{$product->id}}" class="btn btn-success">NUOVA OFFERTA</a>
    <BR><BR>

            @if($offerts[0] == 'empty')

            @else
                <table class="table table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>{{ __('Accioni') }}</th>
                        <th>{{ __('Listino') }}</th>
                        <th>{{ __('Titolo offerta') }}</th>
                        <th>{{ __('Data scadenza offerta') }} </th>
                        <th>{{ __('Data creazione') }} </th>
                        <th>{{ __('Tipo offerta') }} </th>
                        <th> {{ __('Prezzo') }}  </th>
                        <th> {{ __('Status') }}  </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php   for($i=0;$i<count($offerts);$i++){ ?>
                    @foreach($offerts[$i] as $offert)
                        @if($offert->target_user == 1)
                        <tr>
                            <td class="dt_col_actions selected" style="position: sticky; left: 0px; background-color: rgb(249, 249, 249); z-index: 1;">
{{--                                <a href="{{ route('admin.offerts.show', [$offert->id])  }}"  class="btn btn-xs btn-info" title="View">--}}
{{--                                    <i class="fa fa-eye"></i>--}}
{{--                                </a>--}}
                                <a href="{{ route('admin.offerts.edit', [$offert->id])  }}" class="btn btn-xs btn-success" title="Update">
                                    <i class="fa fa-pencil"></i>
                                </a>

                            </td>
                            <td>UF</td>
                            <td>{{$offert->title_1_uf}}</td>
                            <td>{{ $offert->date_finish_off }}</td>
                            <td>{{ $offert->created_at}}</td>
                            <td>{{ $offert->type_off}}</td>
                            <td>{{$offert->list_price_uf}}</td>
                            <td>@if($offert->status == 1) ONLINE @else OFFLINE @endif</td>

                        </tr>
                        @else
                            <tr>
                                <td class="dt_col_actions selected" style="position: sticky; left: 0px; background-color: rgb(249, 249, 249); z-index: 1;">
{{--                                    <a href="{{ route('admin.offerts.show', [$offert->id])  }}"  class="btn btn-xs btn-info" title="View">--}}
{{--                                        <i class="fa fa-eye"></i>--}}
{{--                                    </a>--}}
                                    <a href="{{ route('admin.offerts.edit', [$offert->id])  }}" class="btn btn-xs btn-success" title="Update">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                </td>
                                <td>CO</td>
                                <td>{{$offert->title_1_co}}</td>
                                <td>{{ $offert->date_finish_off}}</td>
                                <td>{{ $offert->created_at }}</td>
                                <td>{{ $offert->type_off}}</td>
                                <td>{{$offert->list_price_co}}</td>
                                <td>@if($offert->status == 1) ONLINE @else OFFLINE @endif</td>

                            </tr>
                        @endif
                    @endforeach
                    <?php } ?>
                    </tbody>


                </table>
    @endif

</div>

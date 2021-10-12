@if(isset($revisionables) && !empty($revisionables))
    <ul class="list-unstyled">
        @foreach($revisionables as $key => $value)
            @php
                $template = $model::getRevisionableTemplate($key);
            @endphp
            @if(isset($value[0]))
                @includeFirst([$template, 'admin.datatables.partials.revisions.templates._default'], ['label' => $key, 'value' => $value])
            @endif
        @endforeach
    </ul>
@endif

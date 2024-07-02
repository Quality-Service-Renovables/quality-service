{{--  INSPECCIÓN  --}}
@foreach ($inspection->category->sections as $section)
    <h3>{{ $section->ct_inspection_section }}</h3>
    @if (count($section->fields))
        <table class="inspection-table">
            <thead>
                <th>{{ trans('api.revision') }}</th>
                <th>{{ trans('api.estado') }}</th>
                <th>{{ trans('api.comments') }}</th>
            </thead>
            <tbody>
                @foreach ($section->fields as $field)
                    <tr style="border-color: grey">
                        <td>
                            <small>{{ $field->ct_inspection_form }}</small>
                        </td>
                        <td><small>{!! $field->result->inspection_form_value ?? '' !!}</small></td>
                        <td>
                            <small>{!! $field->result->inspection_form_comments ?? '' !!}</small>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if (count($section->subSections))
        @foreach ($section->subSections as $subSection)
            <h4>{{ $subSection->ct_inspection_section }}</h4>
            @if (count($subSection->fields))
                <table class="inspection-table">
                    <thead>
                        <th>{{ trans('api.revision') }}</th>
                        <th>{{ trans('api.estado') }}</th>
                        <th>{{ trans('api.comments') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($subSection->fields as $field)
                            <tr style="border-color: grey">
                                <td>
                                    <small>{{ $field->ct_inspection_form }}</small>
                                </td>
                                <td><small>{!! $field->result->inspection_form_value ?? '' !!}</small></td>
                                <td>
                                    <small>{!! $field->result->inspection_form_comments ?? '' !!}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @endif
@endforeach

{{--  INSPECCIÓN  --}}
@foreach($inspection->category->sections as $section)
    <h3>{{$section->ct_inspection_section}}</h3>
    @if(count($section->subSections))
        @foreach($section->subSections as $subSection)
            <h4>{{$subSection->ct_inspection_section}}</h4>
            @if(count($subSection->fields))
                <table class="inspection-table">
                    @foreach($subSection->fields as $field)
                        <tr style="border-color: red">
                            <td>
                                <small>{{$field->ct_inspection_form}}</small>
                            </td>
                            <td><small>{{$field->result->inspection_form_value ?? ''}}</small></td>
                            <td>
                                <small style="color: gray">{{$field->result->inspection_form_comments ?? ''}}</small>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        @endforeach
    @endif
@endforeach

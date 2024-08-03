{{--  INSPECCIÓN  --}}
<h3 class="primary-color uppercase" style="margin: 0px;">6. RESULTADOS PRINCIPALES</h3>
@foreach ($inspection->category->sections as $section)
    <h3>{{ $section->ct_inspection_section }}</h3>
    @if (count($section->fields))
        @foreach ($section->fields as $field)
            <small>{{ $field->ct_inspection_form }}: {!! $field->result->inspection_form_value ?? '' !!}</small><br>
            @isset($field->result->inspection_form_comments)
                <div class="comment">
                    {{--                        <h3 class="author">{{ $field->ct_inspection_form }}: {!! $field->result->inspection_form_value ?? '' !!}</h3>--}}
                    <p>{!! $field->result->inspection_form_comments ?? '' !!}</p>
                </div>
            @endisset
            @isset($field->result->evidences)
                @foreach($field->result->evidences as $evidence)
                    <div class="image-badge">
                        <img style="border: 10px solid {{ $field->result->risk->ct_color }};"
                             src="{{$evidence->inspection_evidence}}" alt="{{$evidence->description}}">
                        <span class="badge">{{ $evidence->title .' '. $evidence->description}}</span>
                    </div>
                @endforeach
            @endisset
            <hr>
        @endforeach
    @endif
    @if (count($section->subSections))
        @foreach ($section->subSections as $subSection)
            <h4>{{ $subSection->ct_inspection_section }}</h4>
            @if (count($subSection->fields))
                @foreach ($subSection->fields as $field)
                    <small>{{ $field->ct_inspection_form }}: {!! $field->result->inspection_form_value ?? '' !!}</small><br>
                    @isset($field->result->inspection_form_comments)
                        <div class="comment">
                            {{--                        <h3 class="author">{{ $field->ct_inspection_form }}: {!! $field->result->inspection_form_value ?? '' !!}</h3>--}}
                            <p>{!! $field->result->inspection_form_comments ?? '' !!}</p>
                        </div>
                    @endisset
                    @isset($field->result->evidences)
                        @foreach($field->result->evidences as $evidence)
                            <div class="image-badge">
                                <img style="border: 10px solid {{ $field->result->risk->ct_color }};"
                                     src="{{$evidence->inspection_evidence}}" alt="{{$evidence->description}}">
                                <span class="badge">{{ $evidence->title .' '. $evidence->description}}</span>
                            </div>
                        @endforeach
                    @endisset
                    <hr>
                @endforeach
            @endif
        @endforeach
    @endif
@endforeach

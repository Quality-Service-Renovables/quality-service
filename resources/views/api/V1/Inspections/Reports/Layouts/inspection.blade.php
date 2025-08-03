<div class="section">
    {{--  INSPECCIÓN  --}}
    <h3 class="primary-color uppercase">7. RESULTADOS PRINCIPALES</h3>

    {{--  Secciones  --}}
    @php $indexSection = 0; @endphp
    @foreach ($inspection->category->sections as $section)
        @if (has_results($section))
            @php $indexSection ++; @endphp
            <h3 class="primary-color uppercase" style="margin-bottom: 0px;margin-top:15px;">7.{{ $indexSection }}
                {{ $section->ct_inspection_section }}</h3>
            <div class="text-center">
                <p>Tabla 7.{{ $indexSection }} {{ $section->ct_inspection_section }}</p>
            </div>

            {{--  Campos  --}}
            @if (count($section->fields))
                @foreach ($section->fields as $field)
                    @if ($field->result && ($field->result->inspection_form_value || $field->result->inspection_form_comments || $field->result->risk))
                        <table style="margin-bottom:10px;">
                            <tbody>
                                <tr class="text-center">
                                    <td class="bg-gray border" style="width:40%;max-width:40%;">Componente</td>
                                    <td class="bg-gray border" style="width:20%;max-width:20%;">Nivel de riesgo</td>
                                    <td class="bg-gray border" style="width:40%;max-width:40%;">Comentarios</td>
                                </tr>
                                <tr>
                                    <td class="border">{{ $field->ct_inspection_form }}</td>
                                    <td class="border text-center" style="background-color: {!! $field->result->risk->ct_color ?? '' !!}">
                                        {!! $field->result->inspection_form_value ?? '' !!}</td>
                                    <td class="border">
                                        @isset($field->result->inspection_form_comments)
                                            {!! $field->result->inspection_form_comments ?? '' !!}
                                        @endisset
                                    </td>
                                </tr>
                                {{--  Sección campos evidencias --}}
                                @isset($field->result->evidences)
                                    @if (count($field->result->evidences) > 0)
                                        <tr>
                                            <td colspan="3" class="border">
                                                <p class="m-0">Evidencias fotográficas</p>
                                                <table>
                                                    <tr>
                                                        @foreach ($field->result->evidences as $index => $evidence)
                                                            <td style="width: 33.33%; padding:5px;">
                                                                <img src="{{ $evidence->inspection_evidence }}"
                                                                    alt="{{ $evidence->description }}" style="max-width: 220px; height: auto;"><br>
                                                                <small>{{ $evidence->title }} {{ $evidence->description ? ' - ' . $evidence->description : '' }}</small>
                                                            </td>
                                                            @if(($index + 1) % 3 == 0)
                                                                <tr></tr>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @endif
                                @endisset
                            </tbody>
                        </table>
                    @endif
                @endforeach
            @endif
            @php $indexSubSection = 0; @endphp
            {{--  Subsecciones  --}}
            @if (isset($section->subSections) && count($section->subSections))
                @foreach ($section->subSections as $subSection)
                    @if (has_results($subSection))
                        @php $indexSubSection++; @endphp
                        <h3 class="primary-color uppercase" style="margin-bottom: 0px;margin-top:15px;">
                            7.{{ $indexSection }}.{{ $indexSubSection }}
                            {{ $subSection->ct_inspection_section }}</h3>
                        <div class="text-center">
                            <p>Tabla 7.{{ $indexSection }}.{{ $indexSubSection}} {{ $subSection->ct_inspection_section }}</p>
                        </div>
                        {{--  Subsección campos  --}}
                        @if (count($subSection->fields))
                            @foreach ($subSection->fields as $field)
                                @if ($field->result && ($field->result->inspection_form_value || $field->result->inspection_form_comments || $field->result->risk))
                                    <table style="margin-bottom:10px;">
                                        <tbody>
                                            <tr class="text-center">
                                                <td class="bg-gray border" style="width:40%;max-width:40%;">Componente</td>
                                                <td class="bg-gray border" style="width:20%;max-width:20%;">Nivel de riesgo</td>
                                                <td class="bg-gray border" style="width:40%;max-width:40%;">Comentarios</td>
                                            </tr>
                                            <tr>
                                                <td class="border">{{ $field->ct_inspection_form }}</td>
                                                <td class="border text-center"
                                                    style="background-color: {!! $field->result->risk->ct_color ?? '' !!}">
                                                    {!! $field->result->inspection_form_value ?? '' !!}</td>
                                                <td class="border">
                                                    @isset($field->result->inspection_form_comments)
                                                        {!! $field->result->inspection_form_comments ?? '' !!}
                                                    @endisset
                                                </td>
                                            </tr>
                                            {{--  Subsección campos evidencias --}}
                                            @isset($field->result->evidences)
                                                @if (count($field->result->evidences) > 0)
                                                    <tr>
                                                        <td colspan="3" class="border">
                                                            <p class="m-0">Evidencias fotográficas</p>
                                                            <table>
                                                                <tr>
                                                                    @foreach ($field->result->evidences as $index => $evidence)
                                                                        <td style="width: 33.33%; padding:5px;">
                                                                            <img src="{{ $evidence->inspection_evidence }}"
                                                                                alt="{{ $evidence->description }}" style="max-width: 220px; height: auto;"><br>
                                                                            <small>{{ $evidence->title }} {{ $evidence->description ? ' - ' . $evidence->description : '' }}</small>
                                                                        </td>
                                                                        @if(($index + 1) % 3 == 0)
                                                                            <tr></tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endisset
                                        </tbody>
                                    </table>
                                @endif
                            @endforeach
                        @endif
                    @endif
                @endforeach
            @endif
        @endif
    @endforeach
</div>

<div class="section">
    {{--  INSPECCIÓN  --}}
    <h3 class="primary-color uppercase" style="margin: 0px;">6. RESULTADOS PRINCIPALES</h3>
    @foreach ($inspection->category->sections as $index => $section)
        <h3 class="primary-color uppercase" style="margin-bottom: 0px;margin-top:15px;">6.{{ $index + 1 }}
            {{ $section->ct_inspection_section }}</h3>
        <div class="text-center">
            <p>Tabla 6.{{ $index + 1 }} {{ $section->ct_inspection_section }}</p>
        </div>
        @if (count($section->fields))
            @foreach ($section->fields as $field)
                <table style="margin-bottom:10px;">
                    <tbody>

                        <tr class="text-center">
                            <td class="bg-gray border" style="width:40%;max-width:40%;">Componente</td>
                            <td class="bg-gray border" style="width:20%;max-width:20%;">Nivel de riesgo</td>
                            <td class="bg-gray border" style="width:40%;max-width:40%;">Comentarios</td>
                        </tr>
                        <tr>
                            <td class="border">{{ $field->ct_inspection_form }}</td>
                            <td class="border text-center" style="background-color: {!! $field->result->risk->ct_color !!}">
                                {!! $field->result->inspection_form_value ?? '' !!}</td>
                            <td class="border">
                                @isset($field->result->inspection_form_comments)
                                    {!! $field->result->inspection_form_comments ?? '' !!}
                                @endisset
                            </td>

                        </tr>
                        @isset($field->result->evidences)
                            @if (count($field->result->evidences) > 0)
                                <tr>
                                    <td colspan="3" class="border">
                                            <p class="m-0">Evidencias fotográficas</p>
                                        <table>
                                            <tr>
                                                @foreach ($field->result->evidences as $evidence)
                                                    <td style="padding:5px;">
                                                        <img src="{{ $evidence->inspection_evidence }}"
                                                            alt="{{ $evidence->description }}">
                                                        <small>{{ $evidence->title . ' - ' . $evidence->description }}</small>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            @endif
                        @endisset
                    </tbody>

                </table>
            @endforeach
        @endif
    @endforeach

</div>

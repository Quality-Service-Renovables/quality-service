<div class="table-content section">
    {{--  TABLA DE CONTENIDO  --}}
    <h3 class="primary-color uppercase">TABLA DE CONTENIDO</h3>
    <p><a href="#introduction" class="list">1. INTRODUCCIÓN</a></p>
    <p><a href="#introduction" class="list">2. DOCUMENTOS DE REFERENCIA PARA LA INSPECCIÓN</a></p>
    <div>
        <p><a href="#"class="list sub-list">2.1 ESTANDARES</p>
        <p><a href="#"class="list sub-list">2.2 MANUALES Y DOCUMENTACIÓN</a></p>
    </div>
    <p><a href="#introduction" class="list">3. METODOLOGÍA APLICADA</a></p>
    <p><a href="#information" class="list">4. INFORMACIÓN</a></p>
    <div>
        <p><a href="#"class="list sub-list">4.1 INFORMACIÓN GENERAL</a></p>
        <p><a href="#"class="list sub-list">4.2 INFORMACIÓN DEL EQUIPO</a></p>
    </div>
    <p><a href="#escale" class="list">5. ESCALA DE CONDICIÓN</a></p>
    <p><a href="#resume" class="list">6. RESUMEN DE LOS RESULTADOS PRINCIPALES</a></p>
    <p><a href="#main_results" class="list">7. RESULTADOS PRINCIPALES</a></p>
    {{--  Secciones  --}}
    @php $indexSection = 0; @endphp
    @foreach ($inspection->category->sections as $section)
        @if (has_results($section))
            @php $indexSection ++; @endphp
            <p><a href="#{{ $section->ct_inspection_section }}"class="list sub-list uppercase">7.{{ $indexSection }} {{ $section->ct_inspection_section }}</a></p>
        @endif
    @endforeach
    <p><a href="#section5" class="list">8. CONCLUCIONES Y RECOMENDACIONES</a></p>
</div>

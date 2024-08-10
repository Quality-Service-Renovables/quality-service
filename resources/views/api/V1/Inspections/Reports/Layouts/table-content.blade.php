<div class="table-content section">
    {{--  TABLA DE CONTENIDO  --}}
    <h3 class="primary-color uppercase">TABLA DE CONTENIDO</h3>
    <p><a href="#introduction" class="list">1. INTRODUCCIÓN</a></p>
    <p><a href="#introduction" class="list">2. DOCUMENTOS DE REFERENCIA PARA LA INSPECCIÓN</a></p>
    <p><a href="#information" class="list">3. INFORMACIÓN</a></p>
    <p><a href="#escale" class="list">4. ESCALA DE CONDICIÓN</a></p>
    <p><a href="#resume" class="list">5. RESUMEN DE LOS RESULTADOS PRINCIPALES</a></p>
    <p><a href="#main_results" class="list">6. RESULTADOS PRINCIPALES</a></p>
    @foreach ($inspection->category->sections as $index => $section)
        <p><a href="#{{ $section->ct_inspection_section }}"class="list sub-list">6.{{$index+1}} {{ $section->ct_inspection_section }}</a></p>
    @endforeach
    <p><a href="#section5" class="list">7. CONCLUCIONES Y RECOMENDACIONES</a></p>
</div>

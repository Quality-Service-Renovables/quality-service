<div class="table-content section">
    {{--  TABLA DE CONTENIDO  --}}
    <h3 class="primary-color uppercase" style="margin: 0px;">TABLA DE CONTENIDO</h3>
    <p><a href="#introduction" class="list">1. INTRODUCCIÓN</a></p>
    <p><a href="#information" class="list">2. INFORMACIÓN</a></p>
    <p><a href="#escale" class="list">3. ESCALA DE CONDICIÓN</a></p>
    <p><a href="#resume" class="list">4. RESUMEN DE LOS PRINCIPALES RESULTADOS</a></p>
    <p><a href="#main_results" class="list">5. RESULTADOS PRINCIPALES</a></p>
    @foreach ($inspection->category->sections as $index => $section)
        <p><a href="#{{ $section->ct_inspection_section }}"class="list sub-list">5.{{$index+1}} {{ $section->ct_inspection_section }}</a></p>
    @endforeach
    <p><a href="#section5" class="list">6. CONCLUCIONES Y RECOMENDACIONES</a></p>
</div>

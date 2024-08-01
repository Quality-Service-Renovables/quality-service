<div style="margin-top: 20px;">
    <h3>1.2 Descripción De Tarea</h3>
    <p>{{ $inspection->project->description }}</p>
    <h3>1.3 Contenido</h3>

    <ul>
        <li><a href="#section1">Sección 1.4 - Resumen</a></li>
        <li><a href="#section2">Sección 1.5 - Escala Condición</a></li>
        <li><a href="#section3">Sección 1.6 - Inspección</a></li>
        <li><a href="#section4">Sección 1.7 - Conclusión</a></li>
        <li><a href="#section5">Sección 1.8 - Apéndice</a></li>
    </ul>


    <h3 id="section1">1.4 Resumen</h3>
    <p>{!! $inspection->resume !!}</p>
    <h3 id="section2">1.5 Escala de Condición</h3>
    <table class="inspection-table">
        <tbody>
        <tr>
            <td>{!! $inspection->escala_condicion !!}</td>
            <td style="background-color: {!! $inspection->risk->ct_color !!}; min-width: 100px;"></td>
        </tr>
        </tbody>
    </table>
    <ul>
        <li class="normal">Verde: Normal</li>
        <li class="unusual">Amarillo: No Usual</li>
        <li class="repair">Rojo: Reparación</li>
    </ul>
</div>

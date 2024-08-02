 {{--  2. ESCALA DE CONDICIÓN  --}}
<div class="section">
    <h3 class="primary-color uppercase" style="margin: 0px;">ESCALA DE CONDICIÓN</h3>
    <br>
    <table class="inspection-table">
        <tbody>
            <tr>
                <td>{!! $inspection->escala_condicion ?? 'Por definir' !!}</td>
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
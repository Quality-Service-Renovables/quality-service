 {{--  2. ESCALA DE CONDICIÓN  --}}
<div class="section">
    <h3 class="primary-color uppercase" style="margin: 0px;">3. ESCALA DE CONDICIÓN</h3>
    <p>A continuación se resumen los principales hallazgos de las inspecciones.</p>
    <table class="inspection-table">
        <tbody>
            <tr>
                <td>{!! $inspection->escala_condicion ?? 'Por definir' !!}</td>
                <td style="background-color: {!! $inspection->risk->ct_color !!}; min-width: 100px;"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <table>
        @foreach($inspection->risk_catalog as $risk)
        <tr >
            <td style="background-color: {!! $risk->ct_color !!};width:20px;height:75px;"></td>
            <td style="padding:10px;">{{ $risk->ct_description_secondary }}</td>
        </tr>
        @endforeach
    </table>
</div>
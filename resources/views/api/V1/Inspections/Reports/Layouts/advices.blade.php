<div class="font-12">
    <h3 class="primary-color">
        AVISO A TERCEROS
    </h3>
    <p class="justify font-12">
        Este informe fue preparado por Quality Service Renovables S. de R.L. de C.V. y se basa en información que no
        está
        bajo el control de QSR. QSR ha asumido que la información proporcionada por otros, tanto verbal como escrita, es
        completa
        y correcta. Si bien se cree que la información, los datos y las opiniones aquí contenidos serán confiables bajo
        las
        condiciones y sujetos a las limitaciones establecidas en este documento, QSR no garantiza su exactitud. El uso
        de
        este
        informe o cualquier información contenida en el mismo por cualquier parte que no sea el destinatario previsto o
        sus
        afiliados,
        constituirá una renuncia y liberación por parte de dicho tercero de QSR de y contra todas las reclamaciones y
        responsabilidades, incluyendo, pero no
        limitándose a, la responsabilidad por daños especiales, incidentales, indirectos o consecuentes en relación con
        dicho uso. Además, el uso de este informe o de cualquier información contenida en el mismo por cualquier parte
        que
        no sea el destinatario previsto o sus
        afiliadas constituirá un acuerdo por parte de dicho tercero para defender e indemnizar a QSR de y contra
        cualquier
        reclamo
        y responsabilidad, incluida, entre otras, la responsabilidad por daños especiales, incidentales, indirectos o
        consecuentes en
        conexión con dicho uso. En la máxima medida permitida por la ley, dicha renuncia y liberación e indemnización
        se aplicarán a pesar de la negligencia, responsabilidad estricta, culpa, incumplimiento de la garantía o
        incumplimiento del contrato de QSR.
        El beneficio de dichas exenciones, exenciones o limitaciones de responsabilidad se extenderá a las empresas
        relacionadas y
        subcontratistas de cualquier nivel de QSR, y a los directores, funcionarios, socios, empleados y agentes de
        todas
        las
        partes eximidas o
        indemnizadas.
    </p>

    <div class="space"></div>

    <table>
        <tr>
            <td colspan="2" class="primary-color">
                <h3>CLASIFICACIÓN DE DOCUMENTOS</h3>
            </td>
        </tr>
        <tr>
            <td style="width:50%;" class="primary-color">
                ESTRICTAMENTE CONFIDENCIAL
            </td>
            <td style="width:50%;">
                Solo para destinatarios
            </td>
        </tr>
        <tr>
            <td style="width:50%;" class="primary-color">
                CONFIDENCIAL
            </td>
            <td style="width:50%;">
                Puede compartirse dentro de la organización del cliente.
            </td>
        </tr>
        <tr>
            <td style="width:50%;" class="primary-color">
                USO INTERNO SOLAMENTE
            </td>
            <td style="width:50%;">
                No debe distribuirse fuera de QSR
            </td>
        </tr>
        <tr>
            <td style="width:50%;" class="primary-color">
                DISCRECIÓN DEL CLIENTE
            </td>
            <td style="width:50%;">
                Distribución a elección del cliente
            </td>
        </tr>
        <tr>
            <td style="width:50%;" class="primary-color">
                PARA PUBLICACIÓN PÚBLICA
            </td>
            <td style="width:50%;">
                Sin restricción
            </td>
        </tr>
    </table>

    <div class="space"></div>

    <h3 class="primary-color">
        CONTRIBUCIONES AL DOCUMENTO
    </h3>

    <table>
        <tr>
            <td style="width:50%;" class="primary-color border">
                EXPERTO A CARGO
            </td>
            <td style="width:50%;" class="primary-color border">
                APROBADO POR
            </td>
        </tr>
        <tr>
            <td class="border text-center">
                @foreach ($inspection->project->employees as $employee)
                    {{ $employee->user->name }}.<br>
                @endforeach
            </td>
            <td class="border text-center">
                {{ $inspection->diagnosis->name ?? ''}}
            </td>
        </tr>
    </table>

</div>

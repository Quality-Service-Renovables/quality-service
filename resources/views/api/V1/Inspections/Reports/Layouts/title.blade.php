<div class="cover">
    <table style="width: 100%;"> 
        <tr style="width: 100%;">
            <td style="width:40%;">
                <img src="img/qsr-logo-solo.png" alt="QUALITY SERVICE RENOVABLES S. DE R.L DE C.V" class="space">
            </td>
            <td style="width:60%;" style="padding-left:15px;">
                <h3 class="primary-color uppercase" style="margin-top:10px;margin-bottom:0px;">{!! $inspection->category->description !!}</h>
                <p style="color: gray" class="space italic">{{ $inspection->project->title_report }}</p>
                <p>ELABORADO PARA:</p>
                <p class="primary-color space">{{ $inspection->client->client }}</p>
                <p>UBICACIÓN:</p>
                <p class="primary-color space">{{ $inspection->location }}</p>
                <p>FECHA:</p>
                <p class="primary-color space">{{ date('d M Y') }}</p>
            </td>
        </tr>
    </table>
</div>

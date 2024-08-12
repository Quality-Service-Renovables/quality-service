<div class="cover">
    <table style="width: 100%;"> 
        <tr style="width: 100%;">
            <td style="width:100%;text-align:center;">
                @if ($inspection->client->logo)
                    <img src="{{ $inspection->client->logo }}" alt="{{ $inspection->client->client }}" class="space">
                @endif
                <h3 class="primary-color uppercase space" style="margin: 0px;">{!! $inspection->category->description !!}</h>
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

<span>
    <h3>Documentación Gráfica</h3>
    <br>
    @foreach($inspection->evidences as $evidence)
        <div style="display: inline-block; text-align: center; margin: 20px 10px 0px 10px;">
            <img src="{{$evidence->inspection_evidence}}" width="150px" height="150px" style="border-radius: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.5);">
            <p style="font-size: 10px; font-weight: bold">{{$evidence->title}}</p>
            <span style="font-size: 8px;">{{$evidence->description}}</span>
        </div>
        @if($evidence->inspection_evidence_secondary)
            <div style="display: inline-block; text-align: center; margin: 20px 10px 0px 10px;">
                <img src="{{$evidence->inspection_evidence_secondary}}" width="150px" height="150px" style="border-radius: 10px; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                <p style="font-size: 10px; font-weight: bold">{{$evidence->title_secondary}}</p>
                <span style="font-size: 8px;">{{$evidence->description_secondary}}</span>
            </div>
        @endif
    @endforeach
</span>

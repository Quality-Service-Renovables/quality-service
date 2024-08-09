@php $count = 0; @endphp
<div class="inspection-evidence">
    <table>
        @foreach($inspection->evidences as $evidence)
            @if($count % 2 === 0)
                <tr>
                    @endif

                    <td>
                        @if($evidence->inspection_evidence)
                            <img src="{{$evidence->inspection_evidence}}">
                            <p>{{$evidence->title}}</p>
                            <span>{{$evidence->description}}</span>
                        @endif

                        @if($evidence->inspection_evidence_secondary)
                            <img src="{{$evidence->inspection_evidence_secondary}}">
                            <p>{{$evidence->title_secondary}}</p>
                            <span>{{$evidence->description_secondary}}</span>
                        @endif
                    </td>

                    @if($count % 2 === 1 || $loop->last)
                </tr>
            @endif

            @php $count++; @endphp
        @endforeach
    </table>
</div>

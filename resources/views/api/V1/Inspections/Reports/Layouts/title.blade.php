<div style="margin-top: 200px;">
    @if($inspection->client->logo)
        <img src="{{$inspection->client->logo}}" width="300px" height="300px" alt="{{$inspection->client->client}}">
    @endif
    <p>{{$inspection->client->client}}</p>
    <p style="color: gray">{{$inspection->client->legal_name}}</p>
    <p style="color: gray">{{date("d M Y")}}</p>
    <p style="font-size: 16px;"><strong>{{$inspection->category->description}}</strong></p>
</div>

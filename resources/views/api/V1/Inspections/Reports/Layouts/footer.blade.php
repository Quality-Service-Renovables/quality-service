<footer>
    <table>
        <tr>
            <td class="text-left v-top">
                {{ $inspection->client->client }}
                <br>
                Copyright ©  {{$inspection->provider->client}} {{date("Y")}}
                <br>
                www.qsr.mx
            </td>
            <td class="text-right v-top">{{ date('d M Y') }}</td>
            <td class="text-right">
                <img src="{{$inspection->provider->logo}}" width="50px" height="50px" alt="{{$inspection->provider->client}}">
            </td>
        </tr>
    </table>
</footer>

<footer>
    <table>
        <tr>
            <td class="text-left v-top">
                QUALITY SERVICE RENOVABLES S. DE R.L DE C.V
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

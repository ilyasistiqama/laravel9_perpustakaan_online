@php
    use Carbon\Carbon;

    $colspan = 10;
@endphp
<table>
    <thead>
        <tr>
            <th colspan="{{$colspan}}" style="text-align: center; font-size:14px"><b>LAPORAN MASTER BUKU</b></th>
        </tr>
        <tr>
            <th colspan="{{$colspan}}" style="text-align: center; font-size:9px; font-style: italic">Di Download Pada : {{ date('d-m-Y H:i:s', strtotime(Carbon::now()))}}</th>
        </tr>
        <tr>
            <th colspan="{{$colspan}}" style="text-align: center"></th>
        </tr>
        <tr>
            <th style="text-align:center; width: 50px;" rowspan="2"><b>No.</b></th>
            <th style="text-align:center; width: 50px;" rowspan="2"><b>ID</b></th>
            <th style="text-align:center; width: 200px;" rowspan="2"><b>Judul</b></th>
            <th style="text-align:center; width: 200px;" rowspan="2"><b>Kategori</b></th>
            <th style="text-align:center; width: 200px;" rowspan="2"><b>ISBN</b></th>
            <th style="text-align:center; width: 200px;" rowspan="2"><b>Pengarang</b></th>
            <th style="text-align:center; width: 100px;" colspan="2"><b>Jumlah</b></th>
            <th style="text-align:center; width: 100px;" rowspan="2"><b>Tahun Terbit</b></th>
            <th style="text-align:center; width: 1000px;" rowspan="2"><b>Sinopsis</b></th>
        </tr>
        <tr>
            <th style="text-align:center; width: 100px;"><b>Halaman</b></th>
            <th style="text-align:center; width: 100px;"><b>Stok</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse($buku as $index => $row)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$row->id}}</td>
            <td>{{$row->judul}}</td>
            <td>{{$row->Kategori->kategori}}</td>
            <td>{{$row->isbn}}</td>
            <td>{{$row->pengarang}}</td>
            <td>{{$row->jumlah_halaman}}</td>
            <td>{{$row->jumlah_stok}} Buah</td>
            <td>{{date('d-m-Y', strtotime($row->tahun_terbit))}}</td>
            <td>{{$row->sinopsis}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="{{$colspan}}">No data available in table.</td>
        </tr>
        @endforelse
    </tbody>
</table>

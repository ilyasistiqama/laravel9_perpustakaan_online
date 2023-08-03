<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Buku</title>
        <style>
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #table td, #table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #table tr:nth-child(even){background-color: #f2f2f2;}

            #table tr:hover {background-color: #ddd;}

            #table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: left;
                background-color: #007bff;
                color: white;
            }
        </style>
    </head>
    <body>
        @php
            $image = 'Image/Buku/'.$buku->gambar;
            if(@file_get_contents($image) === false){
                $src = 'No Image';
            }else{
                $file_get_contents = file_get_contents($image);
                $imageData = base64_encode($file_get_contents);
                $src = 'data:'. mime_content_type($image). ';base64,'. $imageData;
            }

            use Carbon\Carbon;
        @endphp
        <div style="text-align:center; margin-bottom: 15px;">
            <h3> Detail Buku</h3>
            <small style="font-style: italic;">Di Download Pada : {{ date('d-m-Y H:i:s', strtotime(Carbon::now()))}}</small>
        </div>
        <table id="table">
            <thead>
                <tr>
                    <th colspan="3">Tentang Buku:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jenis Kategori</td>
                    <td>:</td>
                    <td>{{$buku->Kategori->kategori}}</td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>:</td>
                    <td>{{$buku->id}}</td>
                </tr>
                <tr>
                    <td>Judul</td>
                    <td>:</td>
                    <td>{{$buku->id}}</td>
                </tr>
                <tr>
                    <td>ISBN</td>
                    <td>:</td>
                    <td>{{$buku->isbn}}</td>
                </tr>
                <tr>
                    <td>pengarang</td>
                    <td>:</td>
                    <td>{{$buku->pengarang}}</td>
                </tr>
                <tr>
                    <td>Jumlah Halaman</td>
                    <td>:</td>
                    <td>{{$buku->jumlah_halaman}}</td>
                </tr>
                <tr>
                    <td>Jumlah Stok</td>
                    <td>:</td>
                    <td>{{$buku->jumlah_stok}}</td>
                </tr>
                <tr>
                    <td>Tahun Terbit</td>
                    <td>:</td>
                    <td>{{date('d-m-Y', strtotime($buku->tahun_terbit))}}</td>
                </tr>
                <tr>
                    <td>Sinopsis</td>
                    <td>:</td>
                    <td>{{$buku->sinopsis}}</td>
                </tr>
                <tr>
                    <td>Cover Buku</td>
                    <td>:</td>
                    <td style="text-align: center;"><img src="{{ $src }}" alt="No Image" style="margin-top: 10px; margin-bottom: 10px;height: 200px; width: 250px;"></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
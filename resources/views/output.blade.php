<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="fa/css/fontawesome.min.css">

<title>Spell Checker | Output</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand"><b>spell checker</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link"><b>Daftar Verba Baku</b></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><b>Tentang Kami</b></a>
                </li>
            </ul>
        </div>
    </nav>

    <section>
        <div class="container">
            <h1 class="text-center mt-4 mb-4">Spell Check mem+p</h1>
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="card shadow">
                        <div class="card-body" style="width: 698px; height: 380px; overflow-x: hidden;
                        overflow-y: hidden;">
                            <p class="text-justify" style="height: 296px;" id="p1">
                                {!! $hasil !!}
                            </p>
                            <div class="col text-center">
                                <a href="{{ url('/') }}" class="btn btn-sm btn-success">New Text</a>
                                <button class="btn btn-sm btn-success" onclick="goBack()">Back to original</button>
                                <button class="btn btn-sm btn-success" onclick="copyToClipboard('#p1')">Copy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <h5 class="text-center font-weight-light">
                        @if($jml_kata == 0 && $jml_katasuggest == 0)
                            <div class="alert alert-success" role="alert">
                                Tidak ditemukan kata yang salah.
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                Ditemukan <b> {{$jml_kata}} </b> kata salah @if($jml_katasuggest != 0) dan <b> {{$jml_katasuggest}} </b> kata perlu ditinjau. <br>Cek Tabel dibawah untuk melihat <b>{{$jml_hasilsuggest}}</b> kata suggestion. @endif
                            </div>
                        @endif
                    </h5>
                </div>
            </div>
            @if($jml_katasuggest != 0)
            <div class="row justify-content-center mb-4">
                <div class="col-sm-8">
                    <div class="card shadow">
                        <div class="card-body"">
                            <table class="table table-sm table-bordered">
                                <thead class="table-active">
                                    <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">Kata</th>
                                    <th scope="col">Suggestion</th>
                                    <th scope="col">Nilai JWD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $no = 1 @endphp
                                @for($i = 0; $i < count ($inputsuggest); $i++)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{!! $inputsuggest[$i] !!}</td>
                                        <td>{{ $katasuggest[$i] }}</td>
                                        <td>{{ $jwdsuggest[$i] }}</td>
                                    </tr>
                                    @php $no++ @endphp
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
<!-- Optional JavaScript -->
<script>
function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    alert("Teks berhasil dicopy");
}
function goBack() {
    window.history.back();
}
</script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>


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

<title>Spell Checker</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="{{ url('/') }}" class="navbar-brand">
            <b>spell checker</b>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ url('/tabel-verba') }}" class="nav-link"><b>Daftar Verba Baku</b></a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/tentang-kami') }}" class="nav-link"><b>Tentang Kami</b></a>
                </li>
            </ul>
        </div>
    </nav>

    <section>
        <div class="container">
            <h1 class="text-center mt-4">Daftar Verba Baku</h1>
            <h5 class="text-center font-weight-light mb-4">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit.<br> Asperiores ullam tempore iste minima ipsum vero dolores cupiditate, nam itaque vitae?
            </h5>

            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="/cari-verba" method="GET">
                                <input type="text" class="form-control" placeholder="Cari Verba..." value="{{ request('cari') }}" aria-label="Search" aria-describedby="basic-addon2" name="cari">
                                <button class="btn btn-primary mt-2 mb-4" type="submit">Cari</button>
                                <a href="{{ url('tabel-verba') }}" class="btn btn-success mt-2 mb-4">Show All</a>
                            </form>
                            
                            <table class="table table-bordered">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" style="width: 50px">NO</th>
                                        <th scope="col">Verba Baku</th>
                                        <th scope="col">Kata Dasar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $no =  1 @endphp
                                @foreach($target as $word)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $word->Kata_Target }}</td>
                                        <td>cek</td>
                                    </tr>
                                    @php $no++ @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
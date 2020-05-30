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
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <a class="navbar-brand" href="/" id="navbar-brand">Spell Checker</a>
    <button class="navbar-toggler" type="button"><span class="navbar-toggler-icon"></span></button>
</nav>

<section>
    <div class="row">
        <div class="col-sm-4">
        <form>
            <div class="input-group" id="input-file">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="input-file" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="input-file">Choose file</label>
                </div>
            </div>
        </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <form>
                <div class="form-group">
                    <textarea class="form-control" name="input-teks" rows="15"></textarea>
                </div>
                <button type="submit" class="btn btn-danger">Clear</button>
            </form>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <textarea disabled class="form-control" name="output-teks" rows="15"></textarea>
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
<?php
/**
 * @var \Illuminate\Support\MessageBag $errors
 */
?>
    <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Working grid creator - LPT</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <div class="row mt-5 mb-5">

        <div class="card col-12 col-sm-10 col-lg-6 m-auto">

            <div class="card-body">

                <h1 class="card-title">Working grid creator</h1>
                <p class="card-text">This tool allows you to easily create a working grid for chinese characters, with or without stroke order indication.</p>
                <form action="{{ route('englishGrid.pdf') }}" method="GET">

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="学前班, ..." required autofocus maxlength=50 value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="words">Words</label>
                        <input type="text"
                               id="words"
                               name="words"
                               class="form-control mb-3 {{ $errors->has('words') ? 'is-invalid' : '' }}"
                               placeholder="apple, banana, ..."
                               value="{{ old('words') }}" required>
                        @if($errors->has('words'))
                            <div class="invalid-feedback">{{ $errors->first('words') }}</div>
                        @endif
                    </div>

                    <button class="btn btn-primary" type="submit">Generate !</button>

                </form>
            </div>

        </div>

    </div>

</div>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>

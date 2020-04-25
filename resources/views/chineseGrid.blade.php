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
                <form action="{{ route('chineseGrid.pdf') }}" method="GET">

                    <div class="form-group">
                        <label for="className">Class name</label>
                        <input type="text" id="className" name="className" class="form-control" placeholder="学前班, ..." required autofocus maxlength="50" value="{{ old('className') }}">
                    </div>

                    <div class="form-group">
                        <label for="characters">Characters</label>
                        <input type="text" id="characters" name="characters" class="form-control mb-3 {{ $errors->has('characters') ? 'is-invalid' : '' }}" placeholder="两口中水小大多少。。。" value="{{ old('characters') }}" required>
                        @if($errors->has('characters'))
                            <div class="invalid-feedback">{{ $errors->first('characters') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="month">Date</label>
                        <input type="date" id="date" name="date" class="form-control mb-3 {{ $errors->has('date') ? 'is-invalid' : '' }}" value="{{ old('date') }}">
                        @if($errors->has('date'))
                            <div class="invalid-feedback">{{ $errors->first('date') }}</div>
                        @endif
                    </div>

                    <p class="text-muted mb-0">Options</p>
                    <hr class="mt-0">

                    <div class="form-group">
                        <div class="btn-group-toggle d-flex" data-toggle="buttons">
                            <label class="btn btn-outline-secondary">
                                <input type="checkbox" name="strokes" id="strokes"
                                       autocomplete="off" @if(old('strokes') === 'strokes') checked @endif> Strokes
                            </label>
                            &emsp;
                            <label class="btn btn-outline-secondary">
                                <input type="checkbox" name="pinyin" id="pinyin"
                                       autocomplete="off" @if(old('strokes') === 'pinyin') checked @endif> Pinyin
                            </label>
                            {{--<label class="btn btn-secondary active">
                                <input type="checkbox" name="extra" id="none" value="none" autocomplete="off"
                                       @if(old('strokes') === 'none') checked @endif required> None
                            </label>--}}
                        </div>
                        @if($errors->has('extra'))
                            <div class="invalid-feedback d-block">{{ $errors->first('extra') }}</div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="form-group input-group col-12 col-md-6">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="columns">Cells per line</label>
                            </div>
                            <input class="form-control {{ $errors->has('columns') ? 'is-invalid' : '' }}" type="number" min="6" id="columns" name="columns" value="{{ old('columns', 9) }}">
                            @if($errors->has('columns'))
                                <div class="invalid-feedback">{{ $errors->first('columns') }}</div>
                            @endif
                        </div>

                        <div class="form-group input-group col-12 col-md-6">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="lines">Lines per page</label>
                            </div>
                            <input class="form-control {{ $errors->has('lines') ? 'is-invalid' : '' }}" type="number" min="1" id="lines" name="lines" value="{{ old('lines', 10) }}">
                            @if($errors->has('lines'))
                                <div class="invalid-feedback">{{ $errors->first('lines') }}</div>
                            @endif
                        </div>

                        <div class="form-group input-group col-12 col-md-6">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="models">Gray characters</label>
                            </div>
                            <input class="form-control {{ $errors->has('models') ? 'is-invalid' : '' }}" type="number" min="0" max="20" id="models" name="models" value="{{ old('models', 3) }}">
                            @if($errors->has('models'))
                                <div class="invalid-feedback">{{ $errors->first('models') }}</div>
                            @endif
                        </div>

                        <div class="form-group input-group col-12 col-md-6">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="emptyLines">Empty lines</label>
                            </div>
                            <input class="form-control {{ $errors->has('emptyLines') ? 'is-invalid' : '' }}" type="number" min="0" max="50" id="emptyLines" name="emptyLines" value="{{ old('emptyLines', 0) }}">
                            @if($errors->has('emptyLines'))
                                <div class="invalid-feedback">{{ $errors->first('emptyLines') }}</div>
                            @endif
                        </div>
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

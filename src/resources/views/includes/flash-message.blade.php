<!-- https://www.itsolutionstuff.com/post/laravel-5-implement-flash-messages-with-exampleexample.html -->
@if ($message = session('success'))
    <div class="alert alert-success alert-block">
        <i class="fas fa-check-circle"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = session('error'))
    <div class="alert alert-danger alert-block">
        <i class="fas fa-bomb"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = session('warning'))
    <div class="alert alert-warning alert-block">
        <i class="fas fa-exclamation-triangle"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = session('info'))
    <div class="alert alert-info alert-block">
        <i class="fas fa-info-circle"></i>
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Please check the form below for errors
    </div>
@endif

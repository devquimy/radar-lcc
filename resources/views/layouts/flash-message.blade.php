@if ($message = session('success'))
    <div class="container-fluid">
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
    </div>
@endif

@if ($message = session('error'))
    <div class="container-fluid">
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
    </div>
@endif

@if ($message = session('warning'))
    <div class="container-fluid">
        <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif


@if ($message = session('info'))
    <div class="container-fluid">
        <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif


@if ($errors->any())
    <div class="container-fluid">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            @foreach ($errors->all() as $error)
                    <strong><li>{{ $error }}</li></strong>
            @endforeach
        </div>
    </div>
@endif

@if($errors->any())
    <div class="row">
        <div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered col-md-12 offset-md-12">
            <button type="button" class="close" data-dismiss="alert"> <span>x</span><span class="sr-only"></span> </button>
            <span class="text-semibold">Error!</span>
            @foreach ($errors->all() as $error)
                <li> <strong>{{ $error }} </strong></li>
            @endforeach
        </div>
    </div>
@endif
@if (session('status'))
    <div class="row">
        <div class="alert alert-info alert-styled-left alert-arrow-left alert-bordered col-md-12 offset-md-12">
            <button type="button" class="close" data-dismiss="alert"> <span>x</span><span class="sr-only"></span> </button>
            <span class="text-semibold">Well Done</span>
            {{ session('status') }}
        </div>
    </div>
@endif
@if (session('success'))
    <div class="row">
        <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered col-md-12 offset-md-12">
            <button type="button" class="close" data-dismiss="alert"> <span>x</span><span class="sr-only"></span> </button>
            <span class="text-semibold">Well Done!</span>
            <strong>{{ session('success') }}</strong>
        </div>
    </div>
@endif
@if (session('info'))
    <div class="row">
        <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered col-md-12 offset-md-12">
            <button type="button" class="close" data-dismiss="alert"> <span>x</span><span class="sr-only"></span> </button>
            <span class="text-semibold">Info !</span>
            <strong>{{ session('info') }}</strong>
        </div>
    </div>
@endif

@section('style')
    <link rel="stylesheet" href="{{ asset('css/components/course.css') }}">
@endsection

<div class="card col-md-4 mr-3" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card__name card-title">{{ $name }}</h5>
        <h6 class="card__code card-subtitle">{{ $code }}</h6>
    </div>
</div>

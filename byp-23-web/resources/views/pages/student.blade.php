@extends('templates.template')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NRP</th>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ route('student-course', $item['id']) }}">
                            {{ $item['nrp'] }}
                        </a>
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['unit']['name'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@extends('templates.template')

@section('content')
    <a href='{{ route('student') }}'>
        <b>Halaman Utama</b>
    </a><br>
    @if (empty($data))
        <div class="alert alert-secondary" role="alert">
            Mahasiswa/i ini belum mengambil mata kuliah apapun.
        </div>
    @else
        <p class='mt-3'>
            Daftar mata kuliah yang diambil oleh <b>{{ $data['student']['name'] }}, NRP: {{ $data['student']['nrp'] }}</b>
        </p>
        <button type="button" class="btn btn-primary mb-3">Tambah Kelas</button>
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Mata Kuliah Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahForm">
                            <div class="form-group">
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <label for="form-name" class="col-form-label">Mata Kuliah</label>
                                    </div>
                                    <div class="col-9">
                                        <select class="form-control" id="form-class"></select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="alert alert-danger" role="alert" hidden>
                            Mata kuliah telah diambil!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnConfirm" form="tambahData">Tambah Mata Kuliah</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ml-0">
            @foreach ($data['courses'] as $item)
            <div class="card col-md-4 mr-3" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $item['name'] }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $item['code'] }}</h6>
                </div>
            </div>
        @endforeach
        </div>
    @endif
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            document.querySelector('.btn').addEventListener('click', function() {
                $('.modal').modal('show');
            });

            getCoursesByUnit();

            document.querySelector('.btnConfirm').addEventListener('click', function() {
                $('.btnConfirm').attr('disabled', true);
                addCourse();
            });

            document.querySelector('#form-class').addEventListener('change', function() {
                $('.alert').attr('hidden', true);
            });
        });

        function getCoursesByUnit() {
            $.ajax({
                url: 'http://localhost:8000/api/courses/units/:unitId'.replace(
                    ':unitId',
                    '{{ $data['student']['unit']['id'] }}'
                ),
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    res = res.data;
                    res.forEach(function(item) {
                        let option = document.createElement('option');
                        option.value = item.id;
                        option.text = item.name;
                        document.querySelector('#form-class').appendChild(option);
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function addCourse() {
            $.ajax({
                url: '{{ route('student-course', $data['student']['id']) }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    student_id: '{{ $data['student']['id'] }}',
                    course_id: document.querySelector('#form-class').value
                },
                success: function(res) {
                    if (res.success !== true) {
                        $('.alert').removeAttr('hidden');
                        $('.btnConfirm').attr('disabled', false);
                        return;
                    }
                    location.reload();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="card">
            <div class="card-title bg-body-tertiary">
                <h1 class="fw-bold text-center">Kelola User</h1>
            </div>
            <div class="card-body">
                
                <div id="alertMessages" class="alert d-none"></div>
                
                <div class="overflow-hidden">
                    <form id="userForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama</label>
                                <input class="form-control" type="text" id="name" placeholder="Nama">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="text" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="mt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary px-3" type="submit">Submit</button>
                        </div>
                    </form>
                </div>


                <div class="overflow-auto">

                    <table class="mt-5 table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</td>
                                <td>Test</td>
                                <td>Test@gmail.com</td>
                                <td>Test</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
        
    </div>

    <script>
        $(document).ready(function() {
            $('#userForm').on('submit', function(e) {
                e.preventDefault();

                let name = $('#name').val();
                let email = $('#email').val();
                let method = 'POST';
                let url = `{{ route('createUser') }}`;  

                // let id = $('#userId').val();
                // method = id ? 'PUT' : 'POST';
                // url = id ? `{{ route('updateUser', ['id' => '__ID__']) }}`.replace('__ID__', id) : `{{ route('createUser') }}`;

                $('.text-danger').text('');

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        name: name, 
                        email: email, 
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#alertMessages')
                            .removeClass('d-none alert-danger')
                            .addClass('alert-success')
                            .text('User berhasil disimpan!');

                        $('#userForm')[0].reset();

                        setTimeout(() => {
                            // 
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        $('#alertMessages')
                            .removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $(`#${key}`).after(`<div class="text-danger">${value}</div>`);
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection

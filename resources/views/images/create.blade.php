<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('albums.index') }}">Albums</a> / <a href="{{ route('albums.show',$album->id) }}">{{ $album->name }}</a>   /    add new image
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="form-create-image" method="POST" action="{{ route('images.store',$album->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <div>
                                        <label for="image">Image</label>
                                        <input type="file" name="image" class="form-control" id="image">
                                        <div class="invalid-feedback" id="msg-image"> </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="name">Image name</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                                        <div class="invalid-feedback" id="msg-name"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" id="create" class="btn btn-primary mt-3">Create Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        @include('inc-public.send-request')
        <script>
            $(function(){
                $('#form-create-image').submit(function(e){
                    e.preventDefault();
                    var url = $(this).attr('action');
                    var method = $(this).attr('method');
                    var data = new FormData(this);
                    // send request is a function (inc-public / send-request blade)
                    sendRequest(url ,  method , data)

                })
            })
        </script>


    @endsection
</x-app-layout>

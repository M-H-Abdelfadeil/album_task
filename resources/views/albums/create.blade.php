<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('albums.index') }}">Albums</a> / Create album
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="form-create-album" method="POST" action="{{ route('albums.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="arr_numbers" name="arr_numbers" value="1">
                        <input  type="hidden" id="count-images" value="1">
                        <div class="form-group">
                            <label for="name">Album name</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Name">
                            <div class="invalid-feedback" id="msg-name"> </div>
                        </div>
                        <div class=" border border-primary p-2">
                            <div id="container-image" class="">
                                <div class="form-group border border-dark p-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div>
                                                <label for="image_1">Image</label>
                                                <input type="file" name="image_1" class="form-control" id="image_1">
                                                <div class="invalid-feedback" id="msg-image_1"> </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <label for="image_name_1">Image name</label>
                                                <input type="text" name="image_name_1" class="form-control" id="image_name_1" placeholder="Name">
                                                <div class="invalid-feedback" id="msg-image_name_1"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="btn-add-image" class="btn btn-dark fa fa-plus-circle"></button>
                        </div>


                        <button type="submit" id="create" class="btn btn-primary mt-3">Create Album</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        @include('albums.inc.script-create')
        @include('inc-public.send-request')
        {{--    --}}

    @endsection
</x-app-layout>

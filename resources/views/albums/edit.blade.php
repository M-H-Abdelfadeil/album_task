<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             Albums / {{ $album->name }} / Edit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="form-create-album" method="POST" action="{{ route('albums.update',$album->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" id="arr_numbers" name="arr_numbers" value="1">
                        <input  type="hidden" id="count-images" value="1">
                        <div class="form-group">
                            <label for="name">Album name</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$album->name) }}" id="name" placeholder="Name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <button type="submit" class="btn btn-primary mt-3">EDIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

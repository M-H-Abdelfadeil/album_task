<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             Albums / {{ $album->name }} / Delete
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="form-create-album" method="POST" action="{{ route('albums.destroy',$album->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')

                        <div class="form-group">
                            <label for="status">status</label>
                            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" >
                                <option value="">---</option>
                                <option {{ old('status')=="delete" ?'selected' : '' }} value="delete">delete all the pictures in the album</option>
                                <option {{ old('status')=="move" ?'selected' : '' }} value="move">move the pictures to another album</option>
                            </select>


                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="album_move">If you choose to move to another album, select it
                            </label>
                            <select id="album_move" name="album_move" class="form-control @error('album_move') is-invalid @enderror" >
                                <option value="">---</option>
                                @foreach ($albums as $album )
                                    <option {{ old('album_move')==$album->id ? "selected" : ''}} value="{{ $album->id }}">{{ $album->name }}</option>
                                @endforeach

                            </select>
                            @error('album_move')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">DELETE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

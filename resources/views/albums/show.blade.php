<x-app-layout>
    @section('style')
        <style>
            .box-img img {
                height: 100%;
                width: 100%;
                object-fit: contain;
            }

            .box-img {
                height: 200px;
            }
        </style>
    @endsection
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('albums.index') }}">Albums</a> / {{ $album->name }}
            </h2>
            <div>
                <a class="btn btn-primary" href="{{ route('albums.edit', $album->id) }}">Edit album name <i class="fa fa-edit"></i></a>
                <a class="btn btn-danger ml-4" href="{{ route('album.select-status-delete', $album->id) }}">Delete album <i class="fa fa-trash"></i></a>
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('images.create',$album->id) }}" class="btn btn-primary">Add new Image <i
                            class="fa fa-plus-circle"></i></a>

                    <div class="row mt-4">
                        @forelse ($album->images as $img )
                        <div class="col-3">
                            <div>
                                <div class="card">
                                    <div class="box-img">
                                        <img src="{{ asset('storage/albums/' . $img->image) }}" class="card-img-top" alt="...">

                                    </div>
                                    <div class="card-body">
                                      <h5 class="card-title">{{ $img->name }}</h5>
                                      <a href="{{ route('images.edit',$img->id) }}" class="btn btn-primary">Edit <i class="fa fa-edit"></i></a>
                                      <a data-url="{{ route('images.destroy',$img->id) }}" class="btn btn-danger btn-delete-item">Delete <i class="fa fa-trash"></i></a>
                                    </div>
                                  </div>
                            </div>
                        </div>
                        @empty
                             Notfoun data
                        @endforelse

                    </div>

                </div>
            </div>
        </div>
    </div>
    <form method="POST" id="form-delete-items">
        @csrf
        @method('DELETE')
    </form>
    @section('script')
        <script>
            $(function(){
                $('.btn-delete-item').click(function(e){
                    e.preventDefault();
                    if(confirm('Are you sure you want to move  to the trash?')){
                         var action =  $(this).data('url');
                         $('#form-delete-items').attr('action',action).submit();
                     }

                })
            })
        </script>
    @endsection
</x-app-layout>

<x-app-layout>
    @section('style')
        <link rel="stylesheet"  href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Albums
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('albums.create') }}" class="btn btn-primary">Create New Album <i class="fa fa-plus-circle"></i></a>

                    <div class="row mb mt-3 justify-center">
                        <div class="col-6">
                            <div class="card shade ">
                                <div class="card-body">
                                    <h5 class="card-title">Chart</h5>

                                    <hr>
                                    <canvas id="myChart"></canvas>
                                    <hr class="hr-dashed">
                                    <p class="text-center c-danger">Example of bar chart</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <h1>Albums</h1>
                    </div>
                    <table class="table  table-dark mt-5 text-center" id="albums_tbl">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Images count</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($albums as $album)
                                <tr>
                                    <th scope="row">{{ $album->id }}</th>
                                    <td>{{ $album->name }}</td>
                                    <td>{{ $album->images_count ? $album->images_count : 'Not found' }}</td>
                                    <td>{{ $album->created_at->format('j F Y') }}</td>
                                    <td>{{ $album->created_at->format('h:i a') }}</td>
                                    <th scope="col">
                                        <a class="btn btn-primary" href="{{ route('albums.show', $album->id) }}">Show <i
                                                class="fa fa-eye"></i></a>
                                    </th>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Notfound albums</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

       <script>
            var albums_name = "{{ $albums->pluck('name')->implode(',') }}".split(',');
            var albums_count_images = "{{ $albums->pluck('images_count')->implode(',') }}".split(',');

            var background=[];
            $.each(albums_count_images,function(key,val){
                if(+val < 3){
                    background.push('#ff6384')
                }else if(+val < 20){
                    background.push('#36a2eb')
                }else{
                    background.push('#4bc0c0')

                }
            })
            var myChart = document.getElementById('myChart');
            var myChart = new Chart(myChart, {
                type: 'bar',
                data: {
                    labels: albums_name,
                    datasets: [{
                        label: '# images count',
                        data: albums_count_images,
                        backgroundColor:background
                    }]
                },
                options: {

                }
            });
        </script>

        <script>
            $(function(){
                $(document).ready( function () {
                    $('#albums_tbl').DataTable();
                } );
            })
        </script>
    @endsection
</x-app-layout>

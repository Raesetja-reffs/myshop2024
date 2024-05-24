<x-app-layout>
    <x-slot name="header">
        {{ __('GRV') }}
    </x-slot>
    <x-slot name="breadcrum">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('grv.dashboard') }}" class="text-muted text-hover-primary">
                Dashboard
            </a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">
            Issues
        </li>
    </x-slot>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card smaller-card">
                <div class="card-body">
                    <div class="table-responsive scroll h-400px">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($issues)
                                    @foreach ($issues as $issue)
                                        <tr>
                                            <td>{{ $issue['name'] }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm ps-6 pe-6">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

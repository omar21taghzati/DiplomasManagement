@extends($layout)

@section('content')
    <div class="container">
        <!-- Improved search bar -->
        <form method="GET" action="{{ route('diplomas.index') }}" class="form-inline mb-4">
            <div class="input-group">
                <input type="text" name="cef" class="form-control" placeholder="Search by CEF"
                    value="{{ request('cef') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                </div>
            </div>
        </form>

        @if ($stagiaires->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>CEF</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Group</th>
                            <th>Diploma Status</th>
                            <th>Date Issued</th>
                            <th>Phone</th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        {{-- <script>
                            const cef = @json($diplomas);
                            console.log(cef);
                        </script> --}}
                        @foreach ($stagiaires as $stagiaire)
                            <tr>
                                <td>{{ $stagiaire->CEF }}</td>
                                <td>{{ $stagiaire->user->name }}</td>
                                <td>{{ $stagiaire->group->filier->name }}</td>
                                <td>{{ $stagiaire->group->name }}</td>
                                <td>
                                    <span
                                        class="badge {{ $stagiaire->diploma->certificat->status === 'delivered' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $stagiaire->diploma->certificat->status }}
                                    </span>
                                </td>
                                <td>{{ $stagiaire->diploma->certificat->issuedDate }}
                                </td>

                                {{-- \Carbon\Carbon::parse($diploma->diploma->certificat->issuedDate)->format('d M Y') --}}
                                <td>{{ $stagiaire->user->phone }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary show-details"
                                            title="View Details" data-id="{{ $stagiaire->id }}" data-bs-toggle="modal"
                                            data-bs-target="#showDetailDiplomaModal">
                                            <i class="fas fa-info-circle"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-outline-success show-deliver"
                                            @if ($stagiaire->diploma->certificat->status == 'delivered') disabled @endif title="Deliver Diploma"
                                            data-id="{{ $stagiaire->id }}" data-bs-toggle="modal"
                                            data-bs-target="#showDeliverDiplomaModal">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>

                                        <a href="{{ route('diplomas.download', $stagiaire->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Download Diploma">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Improved pagination -->
            {{ $stagiaires->links('pagination::bootstrap-4') }}
        @else
            <h6>There are no diplomas</h6>
        @endif
    </div>
    @include('diplomas.partials.details-modal')
    @include('diplomas.partials.deliver-modal')
    @push('scripts')
        <script>
            $(document).ready(function() {
                function attachEventHandlers() {
                    // Handle edit product button click
                    $('.show-details').on('click', function() {
                        let stagiaireId = $(this).data('id');
                        console.log(stagiaireId);
                        $.ajax({
                            url: `/diplomas/${stagiaireId}`,
                            type: 'GET',
                            success: function(data) {
                                // console.log(data);
                                if (data.user)
                                    $('#issuedBy').text(data.user.name);
                                else
                                    $('#issuedBy').text(
                                        'there is no user that issued this certificat');

                                if (data.taken_date)
                                    $('#dateTakenDiploma').text(data.taken_date);
                                else
                                    $('#dateTakenDiploma').text('no taken date');

                                if (data.additional_notes)
                                    $('#notes').text(data.additional_notes);
                                else
                                    $('#notes').text('there is no notes');
                            },
                            error: function(xhr) {
                                console.error('Error fetching product data:', xhr);
                            }
                        });
                    });

                    $('.show-deliver').on('click', function() {
                        let stagiaireId = $(this).data('id');
                        //console.log(stagiaireId);
                        $('#editStagiaireId').val(stagiaireId);
                    });
                }
                // Initial event handlers attachment
                attachEventHandlers();
            });
        </script>
    @endpush
@endsection



{{-- <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>CEF</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Group</th>
                        <th>Diploma Status</th>
                        <th>Date Issued</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diplomas as $diploma)
                        <tr>
                            <td>{{ $diploma->CEF }}</td>
                            <td>{{ $diploma->user->name }}</td>
                            <td>{{ $diploma->group->filier->name }}</td>
                            <td>{{ $diploma->group->name }}</td>
                            <td>{{ $diploma->diploma->certificat->status }}</td>
                            <td>{{ $diploma->diploma->certificat->issuedDate }}</td>
                            <td>{{ $diploma->user->phone }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('diplomas.show', $diploma->id) }}"
                                        class="btn btn-sm btn-primary">Details</a>

                                    <form action="{{ route('diplomas.deliver', $diploma->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Deliver</button>
                                    </form>

                                    <a href="{{ route('diplomas.download', $diploma->id) }}"
                                        class="btn btn-sm btn-info">Download</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}

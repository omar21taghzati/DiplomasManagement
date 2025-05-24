@extends($layout)

@section('content')
    <div class="container">
        <!-- Improved search bar -->
        <form method="GET" action="{{ route('bacs.index') }}" class="form-inline mb-4">
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
                            <th>Bac Status</th>
                            <th>Date Issued</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($stagiaires as $stagiaire)
                            <tr>
                                <td>{{ $stagiaire->CEF }}</td>
                                <td>{{ $stagiaire->user->name }}</td>
                                <td>{{ $stagiaire->group->filier->name }}</td>
                                <td>{{ $stagiaire->group->name }}</td>
                                <td>
                                    {{-- <span
                                        class="badge {{ $bac->bac->certificat->status === 'delivered' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $bac->bac->certificat->status }}
                                    </span> --}}
                                    @php
                                        $status = $stagiaire->bac->certificat->status;
                                    @endphp

                                    <span
                                        class="badge 
                                        @if ($status === 'delivered') bg-success
                                        @elseif ($status === 'reserved')
                                             bg-primary
                                        @else
                                             bg-warning text-dark @endif">
                                        {{ $status }}
                                    </span>

                                </td>
                                <td>{{ \Carbon\Carbon::parse($stagiaire->bac->certificat->issuedDate)->format('d M Y') }}
                                </td>
                                <td>{{ $stagiaire->user->phone }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary show-bac-details"
                                            title="View Details" data-id="{{ $stagiaire->id }}" data-bs-toggle="modal"
                                            data-bs-target="#showDetailBacModal">
                                            <i class="fas fa-info-circle"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-outline-success show-deliver-bac"
                                            @if (in_array($stagiaire->bac->certificat->status, ['delivered', 'reserved'])) disabled @endif title="Deliver Bac"
                                            data-id="{{ $stagiaire->id }}" data-bs-toggle="modal"
                                            data-bs-target="#showDeliverBacModal">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>

                                        <a href="{{ route('bacs.download', $stagiaire->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Download Diploma">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-outline-danger show-return-bac"
                                            @if (in_array($stagiaire->bac->certificat->status, ['delivered', 'undelivered'])) disabled @endif title="Return"
                                            data-id="{{ $stagiaire->id }}" data-bs-toggle="modal"
                                            data-bs-target="#showReturnBacModal">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>


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
            <h6>There are no bacs</h6>
        @endif
    </div>

    @include('bacs.partials.details-modal')
    @include('bacs.partials.deliver-modal')
    @include('bacs.partials.return-modal')
    @push('scripts')
        <script>
            $(document).ready(function() {
                function attachEventHandlers() {
                    // Handle edit product button click
                    $('.show-bac-details').on('click', function() {
                        let stagiaireId = $(this).data('id');
                        console.log(stagiaireId);
                        $.ajax({
                            url: `/bacs/${stagiaireId}`,
                            type: 'GET',
                            success: function(data) {
                                // console.log(data);
                                if (data.user)
                                    $('#issuedBy').text(data.user.name);
                                else
                                    $('#issuedBy').text(
                                        'there is no user that issued this certificat');

                                if (data.taken_date)
                                    $('#dateTakenBac').text(data.taken_date);
                                else
                                    $('#dateTakenBac').text('no taken date');

                                // Status handling
                                const status = data.stagiaire.bac.certificat.status;

                                if (status === 'delivered') {
                                    $("#part-return-date").hide();
                                    $("#part-duration").hide();
                                } else {
                                    $("#part-return-date").show();

                                    if (data.return_date)
                                        $('#dateReturnBac').text(data.return_date);
                                    else
                                        $('#dateReturnBac').text('no return date');
                                }

                                if (data.additional_notes)
                                    $('#notes').text(data.additional_notes);
                                else
                                    $('#notes').text('there is no notes');

                                if (status === 'reserved') {
                                    $("#part-duration").show();
                                    $('#taking_duration').text(`${data.taking_duration} days`);
                                } else {
                                    $("#part-duration").hide();
                                }
                            },
                            error: function(xhr) {
                                console.error('Error fetching product data:', xhr);
                            }
                        });
                    });

                    $('.show-deliver-bac').on('click', function() {
                        let stagiaireId = $(this).data('id');
                        //console.log(stagiaireId);
                        $('#editStagiaireId').val(stagiaireId);
                    });

                    $('.show-return-bac').on('click', function() {
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

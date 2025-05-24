@extends('layouts.directeur')

@section('content')
    <style>
        .card-summary {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .card-summary h5 {
            font-weight: 500;
            margin-bottom: 10px;
        }

        .card-summary .count {
            font-size: 24px;
            font-weight: bold;
        }

        .card-summary .change {
            font-size: 14px;
        }

        .filter-form .form-control,
        .filter-form .form-select {
            border-radius: 6px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .pagination .page-item .page-link {
            border-radius: 6px;
        }
    </style>

    <div class="container-fluid py-16">
        {{-- <h4 class="fw-bold mb-4">Overview</h4> --}}

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card-summary text-center">
                    <h5>Diplomas</h5>
                    <div class="count text-primary">{{ $total }}</div>
                    <div class="change text-primary">▲ 100%</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card-summary text-center">
                    <h5>Delivered Diplomas</h5>
                    <div class="count text-danger">{{ $delivered }}</div>
                    <div class="change text-danger">▼
                        {{ $total > 0 ? number_format(($delivered * 100) / $total, 2) : '0.00' }}%</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card-summary text-center">
                    <h5>Undelivered Diploma</h5>
                    <div class="count text-success">{{ $undelivered }}</div>
                    <div class="change text-success">▲
                        {{ $total > 0 ? number_format(($undelivered * 100) / $total, 2) : '0.00' }}%</div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <form method="POST" class="row g-2 align-items-center filter-form mb-4" id='inputsForm'>
            {{-- <div class="col-md-3">
                <input type="text" name="cef" class="form-control" placeholder="Search by CEF" id='searchInput'
                    value="{{ request('search') }}">
            </div> --}}
            <div class="col-md-3">
                <select name="sector" class="form-select" id="select-sector">
                    <option value="">Select a sector</option>
                    @foreach ($secteurs as $index => $s)
                        <option value="{{ $s->id }}" {{ $index === 0 ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
                <span class="text-red-500 text-xs mt-2 text-danger" id='error_sector'></span>
            </div>
            <div class="col-md-3">
                <select name="branch" class="form-select" id='select-filier'>
                    <option value="">Select a branch</option>
                    @foreach ($filiers as $index => $f)
                        <option value="{{ $f->id }}" {{ $index === 0 ? 'selected' : '' }}>{{ $f->name }}
                        </option>
                    @endforeach
                </select>
                <span class="text-red-500 text-xs mt-2 text-danger" id='error_branch'></span>
            </div>
            <div class="col-md-3">
                <select name="group" class="form-select" id="select-group">
                    <option value="">Select a group</option>
                    @foreach ($groups as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
                <span class="text-red-500 text-xs mt-2 text-danger" id='error_group'></span>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select" id="select-status">
                    <option value="">Diploma Status</option>
                    <option value="delivered">Delivered</option>
                    <option value="undelivered">Undelivered</option>
                </select>
                <span class="text-red-500 text-xs mt-2 text-danger" id='error_status'></span>
            </div>
            <div class="col-md-3" id='select-type-date'>
                <select name="type_date" class="form-select" id="select-type">
                    <option value="">select type of date</option>
                    <option value="all">complete date</option>
                    <option value="month">month</option>
                    <option value="year">year</option>
                </select>
                <span class="text-red-500 text-xs mt-2 text-danger" id='error_type_date'></span>
            </div>
            <div class="col-md-3" id='choose-date'>
                <input type="date" name="date" id="select-date" class="form-control" value="{{ request('date') }}">
                <span class="text-red-500 text-xs mt-2 text-danger" id='error_date'></span>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>CEF</th>
                        <th>Name</th>
                        <th>Date Issued</th>
                        <th>Diploma Status</th>
                        <th>Date Take Diploma</th>
                        <th>Issued By</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody id="fill-body">
                    @forelse ($statistics as $statistic)
                        <tr>
                            <td>{{ $statistic->stagiaire->CEF }}</td>
                            <td>{{ $statistic->stagiaire->user->name }}</td>
                            <td>{{ $statistic->certificat->issuedDate }}</td>
                            <td>
                                <span
                                    class="badge {{ $statistic->certificat->status === 'delivered' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $statistic->certificat->status }}
                                </span>
                            </td>
                            @if ($statistic->taken_date)
                                <td>{{ $statistic->taken_date }}</td>
                            @else
                                <td>No Taken Date</td>
                            @endif

                            @if ($statistic->user)
                                <td>{{ $statistic->user->name }}</td>
                            @else
                                <td>No One</td>
                            @endif

                            <td>{{ $statistic->stagiaire->user->phone }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No diplomas found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination-statistic">
            {{ $statistics->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @push('scripts')
        <script>
            //select secteur
            document.getElementById('select-sector').addEventListener('change', function() {
                var id = this.value;
                const filierSelect = document.getElementById('select-filier');
                // Clear current options
                filierSelect.innerHTML = '<option value="">Select a branch</option>';
                if (id) {
                    document.getElementById("error_sector").innerHTML = "";

                    axios.get(`/secteur/${id}/filiers`)
                        .then(res => {
                            document.getElementById("error_branch").innerHTML = "";
                            const filiers = res.data.branches;
                            var fil_id = 0;
                            filiers.forEach((filier, index) => {
                                const option = document.createElement('option');
                                option.value = filier.id;
                                option.text = filier.name;

                                if (index === 0) {
                                    option.selected = true; // select the first one
                                    fil_id = filier.id;
                                    console.log(fil_id);
                                }
                                filierSelect.appendChild(option);
                            });
                            SelectGroup(fil_id);

                        })
                        .catch(error => {
                            console.error('Error fetching filiers:', error);
                        })
                } else {
                    SelectGroup(null);
                }
            })

            //Status
            document.getElementById('select-status').addEventListener('change', function() {
                const value = this.value;
                const typeDateDiv = document.getElementById('select-type-date');
                const dateDiv = document.getElementById('choose-date');
                if (value !== "") {
                    document.getElementById("error_status").innerHTML = "";
                }

                if (value === 'undelivered' || value === "") {
                    typeDateDiv.style.display = 'none';
                    dateDiv.style.display = 'none';
                } else {
                    typeDateDiv.style.display = 'block';
                    dateDiv.style.display = 'block';
                }
            });

            //select filier
            document.getElementById('select-filier').addEventListener('change', function() {
                var id = this.value;
                if (id) {
                    document.getElementById("error_branch").innerHTML = "";
                }
                SelectGroup(id);
            })
            //select group
            document.getElementById('select-group').addEventListener('change', function() {
                var id = this.value;
                if (id) {
                    console.log(id)
                    document.getElementById("error_group").innerHTML = "";
                }

            })

            //select type_date
            document.getElementById('select-type').addEventListener('change', function() {
                var id = this.value;
                if (id) {
                    document.getElementById("error_type_date").innerHTML = "";
                }

            })

            //select date
            document.getElementById('select-date').addEventListener('change', function() {
                var val = this.value;
                if (val) {
                    document.getElementById("error_date").innerHTML = "";
                }

            })


            function SelectGroup(id) {
                const groupSelect = document.getElementById('select-group');
                // Clear current options
                groupSelect.innerHTML = '<option value="">Select a group</option>';
                if (id) {

                    axios.get(`/filier/${id}/groups`)
                        .then(res => {
                            document.getElementById("error_group").innerHTML = "";
                            console.log(res.data.groups);
                            const groups = res.data.groups;
                            groups.forEach((group, index) => {
                                const option = document.createElement('option');
                                option.value = group.id;
                                option.text = group.name;

                                if (index === 0) {
                                    option.selected = true; // select the first one
                                }
                                groupSelect.appendChild(option);
                            });

                        })
                        .catch(error => {
                            console.error('Error fetching groups:', error);
                        })
                }
            }


            const form = document.getElementById('inputsForm');
            const tbody = document.getElementById("fill-body");
            const paginationContainer = document.getElementById("pagination-statistic");
            let filterActive = false;
            function loadPage(url, formData) {
                axios.post(url, formData)
                    .then(res => {
                        tbody.innerHTML = '';
                        paginationContainer.innerHTML = '';
                        const statistics = res.data.statistic;

                        if (!Array.isArray(statistics) || statistics.length === 0) {
                            tbody.innerHTML = `<tr><td colspan="8" class="text-center">No statistics found.</td></tr>`;
                            return;
                        }

                        statistics.forEach(statistic => {
                            const tr = document.createElement('tr');
                            const status = statistic.certificat?.status ?? 'unknown';
                            const takenDate = statistic.taken_date ?? 'No Taken Date';
                            const deliveredBy = statistic.user ? statistic.user.name : 'No One';
                            const phone = statistic.stagiaire?.user?.phone ?? 'N/A';

                            tr.innerHTML = `
                        <td>${statistic.stagiaire?.CEF ?? 'N/A'}</td>
                        <td>${statistic.stagiaire?.user?.name ?? 'N/A'}</td>
                        <td>${statistic.certificat?.issuedDate ?? 'N/A'}</td>
                        <td>
                            <span class="badge ${status === 'delivered' ? 'bg-success' : 'bg-warning text-dark'}">
                                ${status}
                            </span>
                        </td>
                        <td>${takenDate}</td>
                        <td>${deliveredBy}</td>
                        <td>${phone}</td>
                    `;
                            tbody.appendChild(tr);
                        });

                        if (res.data.pagination_html) {
                            paginationContainer.innerHTML = res.data.pagination_html;
                        }
                        filterActive = true;
                    })
                    .catch(error => {
                        if (error.response && error.response.data.errors) {
                            const errors = error.response.data.errors;
                            console.log(errors);
                            for (const field in errors) {
                                console.log(field)
                                document.getElementById(`error_${field}`).innerText = errors[field][0];
                            }
                        }
                    });
            }

            // Handle form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                loadPage('/statistic', formData);
            });

            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                if (filterActive && e.target.closest('#pagination-statistic a')) {
                    e.preventDefault();
                    const link = e.target.closest('a');
                    const url = link.getAttribute('href');
                    const formData = new FormData(form);
                    loadPage(url, formData);
                }
            });
        </script>
    @endpush
@endsection

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('sms.import.file') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Import</button>
</form>

<div class="container my-5">
    <!-- Upper pagination bar -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="text-muted">
                {{ __('Showing') }} {{ $sendAttempts->firstItem() }} {{ __('to') }} {{ $sendAttempts->lastItem() }} {{ __('of') }} {{ $sendAttempts->total() }} {{ __('entries') }}
            </span>
        </div>
        <div class="btn-group" role="group">
            <!-- Previous page button -->
            @if ($sendAttempts->onFirstPage())
                <button class="btn btn-outline-secondary" disabled>{{ __('Previous') }}</button>
            @else
                <button class="btn btn-outline-primary" onclick="window.location='{{ $sendAttempts->previousPageUrl() }}'">{{ __('Previous') }}</button>
            @endif

            <!-- Page buttons -->
            @foreach ($sendAttempts->getUrlRange(1, $sendAttempts->lastPage()) as $page => $url)
                @if ($page == $sendAttempts->currentPage())
                    <button class="btn btn-primary active">{{ $page }}</button>
                @else
                    <button class="btn btn-outline-primary" onclick="window.location='{{ $url }}'">{{ $page }}</button>
                @endif
            @endforeach

            <!-- Next page button -->
            @if ($sendAttempts->hasMorePages())
                <button class="btn btn-outline-primary" onclick="window.location='{{ $sendAttempts->nextPageUrl() }}'">{{ __('Next') }}</button>
            @else
                <button class="btn btn-outline-secondary" disabled>{{ __('Next') }}</button>
            @endif
        </div>
    </div>

        <!-- Record table -->
    <div class="table-responsive">
        <style>
            /* Personalized edges for edges */
            .table-bordered th,
            .table-bordered td {
                border: 2px solid #dee2e6; /* Thicker edges */
            }

            .table-bordered thead th {
                background-color: #f8f9fa; /* Clear background for headers */
                text-align: center; /* Alignment centered on headers */
            }

            .table-bordered tbody tr:nth-child(odd) {
                background-color: #fdfdfe; /* Lighter background for odd ranks */
            }
        </style>
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>{{ __('Subject') }}</th>
                    <th>{{ __('Sponsor') }}</th>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Message') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Response ID') }}</th>
                    <th>{{ __('Created') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sendAttempts as $sendAttempt)
                    <tr>
                        <td>{{ $sendAttempt->subject }}</td>
                        <td>{{ $sendAttempt->sponsor }}</td>
                        <td>{{ $sendAttempt->identification_id }}</td>
                        <td>{{ $sendAttempt->phone }}</td>
                        <td>{{ $sendAttempt->message }}</td>
                        <td>
                            <span class="badge {{ $sendAttempt->status == 'success' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($sendAttempt->status) }}
                            </span>
                        </td>
                        <td>{{ $sendAttempt->response_id }}</td>
                        <td>{{ $sendAttempt->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Lower paging bar -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            <span class="text-muted">
                {{ __('Showing') }} {{ $sendAttempts->firstItem() }} {{ __('to') }} {{ $sendAttempts->lastItem() }} {{ __('of') }} {{ $sendAttempts->total() }} {{ __('entries') }}
            </span>
        </div>
        <div class="btn-group" role="group">
            <!-- Previous page button -->
            @if ($sendAttempts->onFirstPage())
                <button class="btn btn-outline-secondary" disabled>{{ __('Previous') }}</button>
            @else
                <button class="btn btn-outline-primary" onclick="window.location='{{ $sendAttempts->previousPageUrl() }}'">{{ __('Previous') }}</button>
            @endif

            <!-- Page buttons -->
            @foreach ($sendAttempts->getUrlRange(1, $sendAttempts->lastPage()) as $page => $url)
                @if ($page == $sendAttempts->currentPage())
                    <button class="btn btn-primary active">{{ $page }}</button>
                @else
                    <button class="btn btn-outline-primary" onclick="window.location='{{ $url }}'">{{ $page }}</button>
                @endif
            @endforeach

            <!-- Next page button -->
            @if ($sendAttempts->hasMorePages())
                <button class="btn btn-outline-primary" onclick="window.location='{{ $sendAttempts->nextPageUrl() }}'">{{ __('Next') }}</button>
            @else
                <button class="btn btn-outline-secondary" disabled>{{ __('Next') }}</button>
            @endif
        </div>
    </div>
</div>

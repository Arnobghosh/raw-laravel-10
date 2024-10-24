@section('js')
    <script>
        // Execute the toast function based on session data
        @if(Session::has('success'))
            showToast('success', '{{ Session::get('success') }}');
            {{ session()->forget('success') }}
        @endif

        @if(Session::has('error'))
            showToast('error', '{{ Session::get('error') }}');
            {{ session()->forget('error') }}
        @endif

        @if(Session::has('warning'))
            showToast('warning', '{{ Session::get('warning') }}');
            {{ session()->forget('warning') }}
        @endif

        @if(Session::has('info'))
            showToast('info', '{{ Session::get('info') }}');
            {{ session()->forget('info') }}
        @endif
    </script>
@endsection
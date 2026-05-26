<div id="toast" class="toast-msg"></div>

@if (session('success'))
    <div id="success-msg" class="alert-msg success-msg">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div id="error-msg" class="alert-msg error-msg">
        {{ session('error') }}
    </div>
@endif

@if (session('status'))
    <div class="container mt-3">
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    </div>
@endif

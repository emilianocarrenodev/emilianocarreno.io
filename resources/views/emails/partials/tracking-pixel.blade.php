@if ($trackingToken)
    <img src="{{ route('email.open', $trackingToken) }}" width="1" height="1" alt="" aria-hidden="true" style="display: block; width: 1px; height: 1px; border: 0;">
@endif

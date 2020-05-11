@extends('layouts.app')

@section('content')
<div class="container">
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-3">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">Dashboard--}}
{{--                    <i class="fa fa-times float-right" aria-hidden="true"></i></div>--}}
{{--                <div class="card-body">--}}
                    <chat-component></chat-component>
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-9">--}}
{{--            <message-component v-if="open"></message-component>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
@endsection
<script>

</script>

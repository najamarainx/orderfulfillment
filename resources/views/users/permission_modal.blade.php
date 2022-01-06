<div class="row">
    @if(!empty($permissions))
        @foreach($permissions as $categoryName => $p)
            @php
                $printPermissionHeading = true;
            @endphp
            @foreach($p as $p_name)
                @if($printPermissionHeading)
                    <div class="col-md-12 mb-1 mt-1">
                        <b>{{$categoryName}}</b>
                    </div>
                    @php
                        $printPermissionHeading = false;
                    @endphp
                @endif
                <div class="col-md-3">
                    <i class="la la-check"></i> {{ucwords(preg_replace('/(.*?[a-z]{1})([A-Z]{1}.*?)/','${1} ${2}',$p_name['name']))}}
                </div>
            @endforeach
        @endforeach
    @else
        <div class="col-md-12">
            <div class="alert alert-danger">
                No permission assigned to role yet.
            </div>
        </div>
    @endif
</div>

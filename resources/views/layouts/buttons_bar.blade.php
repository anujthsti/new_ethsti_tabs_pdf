@if(!empty($createBtnTitle) && !empty($createBtnLink))
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="text-right mb-2">
            <a class="btn btn-success" href="{{ $createBtnLink }}"> {{ $createBtnTitle }}</a>
        </div>
    </div>
</div>
@endif
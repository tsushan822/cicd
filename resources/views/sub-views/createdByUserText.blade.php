@if(isset($copy))

        @if(isset($notShowId))
            <h2 class="section-heading  d-flex justify-content-center justify-content-md-start"> @lang('master.Copy') {!!$type!!}</h2>
        @else
            <h2 class="section-heading  d-flex justify-content-center justify-content-md-start"> @lang('master.Copy') {!!$type!!} @if(isset($deal->short_name)) ({!! $deal->short_name !!}) @else {!!$deal->id!!} @endif</h2>
        @endif


@elseif(isset($deal))
        @if(isset($notShowId))
            <h2 class="section-heading  d-flex justify-content-center justify-content-md-start"> {!!$type!!}</h2>
        @else
            <h2 class="section-heading  d-flex justify-content-center justify-content-md-start">{!!$type!!} @if(isset($deal->short_name)) ({!! $deal->short_name !!}) @elseif(isset($deal->name)) ({!! $deal->name !!}) @else {!!$deal->id!!} @endif</h2>
        @endif
        <small class="d-flex justify-content-md-start justify-content-center"> @lang('master.Created by') {!! $deal->createdByUser->name ?? ''!!}

            @lang('master.on')
            <?php

            switch(Auth ::user() -> locale){
                case "fi":
                    setlocale(LC_TIME, 'fi_FI.utf8');
                    echo Carbon\Carbon ::parse($deal -> created_at) -> formatLocalized('%d %Bta %Y');
                    break;
                case "sv":
                    setlocale(LC_TIME, 'sv_SV.utf8');
                    echo Carbon\Carbon ::parse($deal -> created_at) -> formatLocalized('%d %B %Y');
                    break;
                case "de":
                    setlocale(LC_TIME, 'de_DE.utf8');
                    echo Carbon\Carbon ::parse($deal -> created_at) -> formatLocalized('%d %B %Y');
                    break;
                case "fr":
                    setlocale(LC_TIME, 'fr_FR.utf8');
                    echo Carbon\Carbon ::parse($deal -> created_at) -> formatLocalized('%d %B %Y');
                    break;
                default:
                    setlocale(LC_TIME, 'en');
                    echo Carbon\Carbon ::parse($deal -> created_at) -> formatLocalized('%d %B %Y');
            }?>
            @if(isset($deal->updated_user_id) && $deal->updated_user_id!=0)@lang('master.and last updated by') {!!
            $deal->updatedByUser->name ?? ''!!}
            @lang('master.on') <?php

            switch(Auth ::user() -> locale){
                case "fi":
                    setlocale(LC_TIME, 'fi_FI.utf8');
                    echo Carbon\Carbon ::parse($deal -> updated_at) -> formatLocalized('%d %Bta %Y');

                    break;
                case "sv":
                    setlocale(LC_TIME, 'sv_SV.utf8');
                    echo Carbon\Carbon ::parse($deal -> updated_at) -> formatLocalized('%d %B %Y');
                    break;
                case "de":
                    setlocale(LC_TIME, 'de_DE.utf8');
                    echo Carbon\Carbon ::parse($deal -> updated_at) -> formatLocalized('%d %B %Y');
                    break;
                case "fr":
                    setlocale(LC_TIME, 'fr_FR.utf8');
                    echo Carbon\Carbon ::parse($deal -> updated_at) -> formatLocalized('%d %B %Y');
                    break;
                default:
                    setlocale(LC_TIME, 'en');
                    echo Carbon\Carbon ::parse($deal -> updated_at) -> formatLocalized('%d %B %Y');
            }

            ?>
            @endif
        </small>
        <small class="d-none">
            <span class="required">*</span> @lang('master.indicates required fields')
        </small>
@else


        <h2 class="section-heading  d-flex justify-content-center justify-content-md-start">@lang('master.New') {!!$type!!}  </h2>
        <small class="d-none">
            <span class="required">*</span> @lang('master.indicates required fields')
        </small>


@endif

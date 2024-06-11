@extends('layouts.app')
@section('title', "FAQ - Very Friendly Sharks: Your Top Card Trading Questions Answered")
@section('description','Find Answers to Your Card Trading Queries - Shipping, Grading, and More. Start Trading Confidently with Very Friendly Sharks!')
@push('css')
@endpush
@section('content')
<section>
    <div class="container">
        <div class="row my-5">
            <div class="col-md-12 px-md-5">
                <h1 class="text-site-primary rules-page-header mb-5 text-center">{{$setting['faqs_title'] ?? ''}}</h1>
                @foreach($faqs as $key => $faq)
                <h4 class=" my-3 fs-5 fw-bold">
                    {{getCategoryById($key)}}
                </h4>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach($faq as $item)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="flush-heading{{$item->id}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{$item->id}}" aria-expanded="false"
                                aria-controls="flush-collapse{{$item->id}}">
                                <p class="mb-0">{{$item->question}}</p>
                            </button>
                        </h3>
                        <div id="flush-collapse{{$item->id}}" class="accordion-collapse collapse"
                            aria-labelledby="flush-heading{{$item->id}}" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>{!! $item->answer !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                <div>
                </div>
            </div>
</section>

@endsection

@push('js')

@endpush

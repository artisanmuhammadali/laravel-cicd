@extends('layouts.app')
@section('title',$set->title ?? "")
@section('description',$set->meta_description ?? '')
@push('css')
@endpush
@section('content')
<div class="container-fluid px-0">
    @if(isset($set->banner))
        @include('front.components.sw.set.has-banner',['detail'=>$set , 'banner'=>$set->banner])
    @else
    @include('front.components.sw.set.no-banner',['detail'=>$set])
    @endif
    <section>
        <div class="product-section my-5">
            <div class="container">
                <div class="row">
                    @if($set->first_single_card)
                    <div class="col-lg-3 col-md-4 col-sm-6 ">
                        <a href="{{ route('sw.expansion.type',[$set->slug ,'single-cards']) }}" class="text-decoration-none">
                            <div class="card border-0 card-set" >
                                <div class="set_card_img d-flex justify-content-center">
                                    <img src="{{$set->first_single_card->png_image ?? ''}}" loading="lazy" class="img-fluid" alt="single_card" width="90%">
                                </div>
                                <div class="card-body ">
                                    <p class="card-text text-center fs-17">Singles ({{ $set->single_count }})</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($set->first_sealed_card)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card border-0 card-set d-flex justify-content-center ">
                            <a href="{{ route('sw.expansion.type',[$set->slug ,'sealed-products']) }}" class="text-decoration-none text-black">
                                <div class="set_card_img d-flex justify-content-center px-sm-3 px-5">
                                    <img src="{{$set->first_sealed_card->png_image ?? ''}}" loading="lazy" class="img-fluid" alt="sealed-products"  width="100%">
                                </div>
                                <div class="card-footer border-0 bg-white text-center">
                                    <p class="card-text text-center fs-17">Sealed ({{ $set->sealed_count }})</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($set->first_completed_card)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card border-0 card-set ">
                            <a href="{{ route('sw.expansion.type',[$set->slug ,'complete-sets']) }}" class="text-decoration-none text-black">
                                <div class="set_card_img text-center">
                                    <img src="{{$set->first_completed_card->png_image ?? ""}}" class="img-fluid" alt="complete-sets">
                                </div>
                                <div class="card-footer border-0 bg-white text-center">
                                    <p class="card-text text-center fs-17">Complete Sets ({{ $set->completed_count }})</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    {{-- @foreach($childs as $key => $child)

                    @if($key == 'singles')
                        @foreach ($child as $single)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <a href="{{ route('mtg.expansion.type',[$set->slug ,$single->slug]) }}" class="text-decoration-none">
                                    <div class="card border-0 card-set" >
                                        <div class="set_card_img d-flex justify-content-center">
                                            <img src="{{$single->first_single_card->png_image ?? ""}}" class="img-fluid" alt="single" width="90%">
                                        </div>
                                        <div class="card-body ">
                                            <p class="card-text text-center fs-17">{{ $single->name }} ({{ $single->card_count }})</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <a href="{{ route('mtg.expansion.type',[$set->slug, $child[0]->url_type]) }}" class="text-decoration-none">
                                <div class="card border-0 card-set" >
                                    <div class="set_card_img d-flex justify-content-center">
                                        <img src="{{$child[0]->first_single_card->png_image ?? ""}}" class="img-fluid" alt="..." width="90%">
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text text-center fs-17">{{ $key }} ({{ countCardTotal($childs[$key]) }})</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif


                    @endforeach --}}
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@push('js')

@endpush

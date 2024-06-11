@extends('layouts.app')
@section('title','Help')
@section('description','Get Expert Assistance - Your Go-To Resource for All Your Card Trading Queries. Join the Community Now!')
@push('css')
@endpush
@section('content')
<style>

</style>
<div class="container-fluid px-0">
    <section>
        <div class="container-md">
            <div class="row my-5">
                <div class="col-12">
                    <div class="row ">
                        <div class="col-12 text-center">
                            <h1 class="text-site-primary Welcome-Friendly pro_range_heading_2_area">Support Helpdesk</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row   justify-content-center py-5">
                    <div class="  col-md-8 col-12 text-center">
                    <form action="{{route('supporthelp')}}" method="post"  class="shadow_site p-md-5 p-3" enctype="multipart/form-data" >
                        @csrf
                        @if($report_condition)
                        <input type="hidden" name="tag" value="report">
                        <input type="hidden" name="report_to_id" value="{{$report_user->id}}">
                        <input type="hidden" name="report_by_id" value="{{$auth->id}}">
                        @endif
                            <div class="test-start">
                                    <div class="d-flex justify-content-between">
                                        <label class="fw-bold">Select Issue Category</label>
                                    </div>
                                    <select  class="form-select form-select-lg border-site-primary mb-2 w-100 rounded-0 fs-sm-14" name="category" aria-label=".form-select-lg example" required>
                                        @if($report_condition)
                                        <option class="form-control" value="4">Report User</option>
                                        @else
                                        <option class="form-control" value="1">Technical Issues</option>
                                        <option class="form-control" value="2">Account Issues</option>
                                        <option class="form-control" value="3">Order Issues</option>
                                        <option class="form-control" value="4">Report User</option>
                                        <option class="form-control" value="6">Others</option>
                                        @endif
                                    </select>
                                    <!-- <span class="md-text">Minimum 8 character long, contain symbols and numbers</span> -->
                                    @error('category')
                                        <p class="text-danger text-start">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-2 text-start">
                                    <label class="fw-bold">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" required placeholder="user@gmail.com" {{auth()->user() ? "readonly" : ''}} value="{{$auth->email ?? null}}" class="form-control-lg form-control-site-lg w-100 br-none fs-sm-14">
                                    <!-- <span class="md-text">Please provide a valid email address where we can contact you directly.</span> -->
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-2 text-start">
                                    <label class="fw-bold">Subject<span class="text-danger">*</span></label>
                                    <input type="text" name="subject" required placeholder="eg : 'lost acces s to account'" class="form-control-lg form-control-site-lg w-100 br-none fs-sm-14">
                                    <!-- <span class="md-text">Please provide one sentence to summarize the issue you're encountering.</span> -->
                                    @error('subject')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-2 text-start">
                                    <label class="fw-bold">Describe Your Issue<span class="text-danger">*</span></label>
                                    <textarea required class="form-control-lg form-control-site-lg w-100 br-none fs-sm-14" name="issue" rows="4" cols="50" >@if($report_condition)Email : {{$report_user->email}}
                                    Username : {{$report_user->user_name}}
                                    Reason : @endif</textarea>
                                    <!-- <span class="md-text">Please provide a detailed description of your issue below (maximum 1000 characters).</span> -->
                                    @error('issue')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-2 text-start">
                                    <label class="fw-bold">Attachment</label>
                                    <input type="file" name="attachment_file" accept=".jpg, .png, .jpeg" class=" form-control-lg form-control-site-lg w-100 br-none fs-sm-14" >
                                    <span class="md-text">Please provide us with an image or proof of the issue.</span>
                                    <!-- <span class="md-text">Please upload a file in JPG or PDF format that is no larger than 2MB.</span> -->
                                    @error('attachment_file')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="row mt-3 text-start">
                                    <div class="col-12 d-flex align-items-start">
                                        <input type="checkbox" class="mt-1 me-2" required name="terms" value="1" id="policy-1">
                                        <label for="policy-1" class=""><span class="text-danger">*</span>I have read and
                                            agree to the Very Friendly Sharks <a href="{{getPagesRoute('terms-conditions')}}" class=" hover-blue">Terms & Conditions</a></label>
                                    </div>
                                    @error('terms')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="row my-3 text-start">
                                        <div class="col-md-12">
                                            <div class="form-group d-flex">
                                                <div class="g-recaptcha"
                                                    data-sitekey="6LegtnQoAAAAAHtABNI-tj1nHNNxmMAAY3ap17HF"
                                                    data-callback='onSubmit' data-action='submit'></div>
                                            </div>
                                        </div>
                                        @error('g-recaptcha-response')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                <div class="row mt-2 text-start">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-site-primary btn-lg px-5" title="Submit Form">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection


@push('js')
<script>
    $(document).ready(function(){
        loadRecaptcha();
    })
</script>
@endpush